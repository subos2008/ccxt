# -*- coding: utf-8 -*-

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

import ccxt.async_support
from ccxt.async_support.base.ws.cache import ArrayCache
import hashlib
from ccxt.async_support.base.ws.client import Client
from typing import Optional
from ccxt.base.errors import ExchangeError


class bitopro(ccxt.async_support.bitopro):

    def describe(self):
        return self.deep_extend(super(bitopro, self).describe(), {
            'has': {
                'ws': True,
                'watchBalance': True,
                'watchMyTrades': False,
                'watchOHLCV': False,
                'watchOrderBook': True,
                'watchOrders': False,
                'watchTicker': True,
                'watchTickers': False,
                'watchTrades': True,
            },
            'urls': {
                'ws': {
                    'public': 'wss://stream.bitopro.com:9443/ws/v1/pub',
                    'private': 'wss://stream.bitopro.com:9443/ws/v1/pub/auth',
                },
            },
            'requiredCredentials': {
                'apiKey': True,
                'secret': True,
                'login': True,
            },
            'options': {
                'tradesLimit': 1000,
                'ordersLimit': 1000,
                'ws': {
                    'options': {
                        # headers is required for the authentication
                        'headers': {},
                    },
                },
            },
        })

    async def watch_public(self, path, messageHash, marketId):
        url = self.urls['ws']['public'] + '/' + path + '/' + marketId
        return await self.watch(url, messageHash, None, messageHash)

    async def watch_order_book(self, symbol: str, limit: Optional[int] = None, params={}):
        """
        watches information on open orders with bid(buy) and ask(sell) prices, volumes and other data
        :param str symbol: unified symbol of the market to fetch the order book for
        :param int|None limit: the maximum amount of order book entries to return
        :param dict params: extra parameters specific to the bitopro api endpoint
        :returns dict: A dictionary of `order book structures <https://docs.ccxt.com/#/?id=order-book-structure>` indexed by market symbols
        """
        if limit is not None:
            if (limit != 5) and (limit != 10) and (limit != 20) and (limit != 50) and (limit != 100) and (limit != 500) and (limit != 1000):
                raise ExchangeError(self.id + ' watchOrderBook limit argument must be None, 5, 10, 20, 50, 100, 500 or 1000')
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        messageHash = 'ORDER_BOOK' + ':' + symbol
        endPart = None
        if limit is None:
            endPart = market['id']
        else:
            endPart = market['id'] + ':' + limit
        orderbook = await self.watch_public('order-books', messageHash, endPart)
        return orderbook.limit()

    def handle_order_book(self, client: Client, message):
        #
        #     {
        #         event: 'ORDER_BOOK',
        #         timestamp: 1650121915308,
        #         datetime: '2022-04-16T15:11:55.308Z',
        #         pair: 'BTC_TWD',
        #         limit: 5,
        #         scale: 0,
        #         bids: [
        #             {price: '1188178', amount: '0.0425', count: 1, total: '0.0425'},
        #         ],
        #         asks: [
        #             {
        #                 price: '1190740',
        #                 amount: '0.40943964',
        #                 count: 1,
        #                 total: '0.40943964'
        #             },
        #         ]
        #     }
        #
        marketId = self.safe_string(message, 'pair')
        market = self.safe_market(marketId, None, '_')
        symbol = market['symbol']
        event = self.safe_string(message, 'event')
        messageHash = event + ':' + symbol
        orderbook = self.safe_value(self.orderbooks, symbol)
        if orderbook is None:
            orderbook = self.order_book({})
        timestamp = self.safe_integer(message, 'timestamp')
        snapshot = self.parse_order_book(message, symbol, timestamp, 'bids', 'asks', 'price', 'amount')
        orderbook.reset(snapshot)
        client.resolve(orderbook, messageHash)

    async def watch_trades(self, symbol: str, since: Optional[int] = None, limit: Optional[int] = None, params={}):
        """
        get the list of most recent trades for a particular symbol
        :param str symbol: unified symbol of the market to fetch trades for
        :param int|None since: timestamp in ms of the earliest trade to fetch
        :param int|None limit: the maximum amount of trades to fetch
        :param dict params: extra parameters specific to the bitopro api endpoint
        :returns [dict]: a list of `trade structures <https://docs.ccxt.com/en/latest/manual.html?#public-trades>`
        """
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        messageHash = 'TRADE' + ':' + symbol
        trades = await self.watch_public('trades', messageHash, market['id'])
        if self.newUpdates:
            limit = trades.getLimit(symbol, limit)
        return self.filter_by_since_limit(trades, since, limit, 'timestamp', True)

    def handle_trade(self, client: Client, message):
        #
        #     {
        #         event: 'TRADE',
        #         timestamp: 1650116346665,
        #         datetime: '2022-04-16T13:39:06.665Z',
        #         pair: 'BTC_TWD',
        #         data: [
        #             {
        #                 event: '',
        #                 datetime: '',
        #                 pair: '',
        #                 timestamp: 1650116227,
        #                 price: '1189429',
        #                 amount: '0.0153127',
        #                 isBuyer: True
        #             },
        #         ]
        #     }
        #
        marketId = self.safe_string(message, 'pair')
        market = self.safe_market(marketId, None, '_')
        symbol = market['symbol']
        event = self.safe_string(message, 'event')
        messageHash = event + ':' + symbol
        rawData = self.safe_value(message, 'data', [])
        trades = self.parse_trades(rawData, market)
        tradesCache = self.safe_value(self.trades, symbol)
        if tradesCache is None:
            limit = self.safe_integer(self.options, 'tradesLimit', 1000)
            tradesCache = ArrayCache(limit)
        for i in range(0, len(trades)):
            tradesCache.append(trades[i])
        self.trades[symbol] = tradesCache
        client.resolve(tradesCache, messageHash)

    async def watch_ticker(self, symbol: str, params={}):
        """
        watches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
        :param str symbol: unified symbol of the market to fetch the ticker for
        :param dict params: extra parameters specific to the bitopro api endpoint
        :returns dict: a `ticker structure <https://docs.ccxt.com/#/?id=ticker-structure>`
        """
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        messageHash = 'TICKER' + ':' + symbol
        return await self.watch_public('tickers', messageHash, market['id'])

    def handle_ticker(self, client: Client, message):
        #
        #     {
        #         event: 'TICKER',
        #         timestamp: 1650119165710,
        #         datetime: '2022-04-16T14:26:05.710Z',
        #         pair: 'BTC_TWD',
        #         lastPrice: '1189110',
        #         lastPriceUSD: '40919.1328',
        #         lastPriceTWD: '1189110',
        #         isBuyer: True,
        #         priceChange24hr: '1.23',
        #         volume24hr: '7.2090',
        #         volume24hrUSD: '294985.5375',
        #         volume24hrTWD: '8572279',
        #         high24hr: '1193656',
        #         low24hr: '1179321'
        #     }
        #
        marketId = self.safe_string(message, 'pair')
        market = self.safe_market(marketId, None, '_')
        symbol = market['symbol']
        event = self.safe_string(message, 'event')
        messageHash = event + ':' + symbol
        result = self.parse_ticker(message)
        timestamp = self.safe_integer(message, 'timestamp')
        datetime = self.safe_string(message, 'datetime')
        result['timestamp'] = timestamp
        result['datetime'] = datetime
        self.tickers[symbol] = result
        client.resolve(result, messageHash)

    def authenticate(self, url):
        if (self.clients is not None) and (url in self.clients):
            return
        self.check_required_credentials()
        nonce = self.milliseconds()
        rawData = self.json({
            'nonce': nonce,
            'identity': self.login,
        })
        payload = self.string_to_base64(rawData)
        signature = self.hmac(payload, self.encode(self.secret), hashlib.sha384)
        defaultOptions = {
            'ws': {
                'options': {
                    'headers': {},
                },
            },
        }
        self.options = self.extend(defaultOptions, self.options)
        originalHeaders = self.options['ws']['options']['headers']
        headers = {
            'X-BITOPRO-API': 'ccxt',
            'X-BITOPRO-APIKEY': self.apiKey,
            'X-BITOPRO-PAYLOAD': payload,
            'X-BITOPRO-SIGNATURE': signature,
        }
        self.options['ws']['options']['headers'] = headers
        # instantiate client
        self.client(url)
        self.options['ws']['options']['headers'] = originalHeaders

    async def watch_balance(self, params={}):
        """
        query for balance and get the amount of funds available for trading or funds locked in orders
        :param dict params: extra parameters specific to the bitopro api endpoint
        :returns dict: a `balance structure <https://docs.ccxt.com/en/latest/manual.html?#balance-structure>`
        """
        self.check_required_credentials()
        await self.load_markets()
        messageHash = 'ACCOUNT_BALANCE'
        url = self.urls['ws']['private'] + '/' + 'account-balance'
        self.authenticate(url)
        return await self.watch(url, messageHash, None, messageHash)

    def handle_balance(self, client: Client, message):
        #
        #     {
        #         event: 'ACCOUNT_BALANCE',
        #         timestamp: 1650450505715,
        #         datetime: '2022-04-20T10:28:25.715Z',
        #         data: {
        #           ADA: {
        #             currency: 'ADA',
        #             amount: '0',
        #             available: '0',
        #             stake: '0',
        #             tradable: True
        #           },
        #         }
        #     }
        #
        event = self.safe_string(message, 'event')
        data = self.safe_value(message, 'data')
        timestamp = self.safe_integer(message, 'timestamp')
        datetime = self.safe_string(message, 'datetime')
        currencies = list(data.keys())
        result = {
            'info': data,
            'timestamp': timestamp,
            'datetime': datetime,
        }
        for i in range(0, len(currencies)):
            currency = self.safe_string(currencies, i)
            balance = self.safe_value(data, currency)
            currencyId = self.safe_string(balance, 'currency')
            code = self.safe_currency_code(currencyId)
            account = self.account()
            account['free'] = self.safe_string(balance, 'available')
            account['total'] = self.safe_string(balance, 'amount')
            result[code] = account
        self.balance = self.safe_balance(result)
        client.resolve(self.balance, event)

    def handle_message(self, client: Client, message):
        methods = {
            'TRADE': self.handle_trade,
            'TICKER': self.handle_ticker,
            'ORDER_BOOK': self.handle_order_book,
            'ACCOUNT_BALANCE': self.handle_balance,
        }
        event = self.safe_string(message, 'event')
        method = self.safe_value(methods, event)
        if method is None:
            return message
        else:
            return method(client, message)
