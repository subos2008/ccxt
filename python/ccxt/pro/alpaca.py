# -*- coding: utf-8 -*-

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

import ccxt.async_support
from ccxt.async_support.base.ws.cache import ArrayCache, ArrayCacheBySymbolById, ArrayCacheByTimestamp
from ccxt.async_support.base.ws.client import Client
from typing import Optional
from ccxt.base.errors import ExchangeError
from ccxt.base.errors import AuthenticationError


class alpaca(ccxt.async_support.alpaca):

    def describe(self):
        return self.deep_extend(super(alpaca, self).describe(), {
            'has': {
                'ws': True,
                'watchBalance': False,
                'watchMyTrades': True,
                'watchOHLCV': True,
                'watchOrderBook': True,
                'watchOrders': True,
                'watchTicker': True,
                'watchTickers': False,  # for now
                'watchTrades': True,
                'watchPosition': False,
            },
            'urls': {
                'api': {
                    'ws': {
                        'crypto': 'wss://stream.data.alpaca.markets/v1beta2/crypto',
                        'trading': 'wss://api.alpaca.markets/stream',
                    },
                },
                'test': {
                    'ws': {
                        'crypto': 'wss://stream.data.alpaca.markets/v1beta2/crypto',
                        'trading': 'wss://paper-api.alpaca.markets/stream',
                    },
                },
            },
            'options': {
            },
            'streaming': {},
            'exceptions': {
                'ws': {
                    'exact': {
                    },
                },
            },
        })

    async def watch_ticker(self, symbol: str, params={}):
        """
        watches a price ticker, a statistical calculation with the information calculated over the past 24 hours for a specific market
        :param str symbol: unified symbol of the market to fetch the ticker for
        :param dict params: extra parameters specific to the alpaca api endpoint
        :returns dict: a `ticker structure <https://docs.ccxt.com/#/?id=ticker-structure>`
        """
        url = self.urls['api']['ws']['crypto']
        await self.authenticate(url)
        await self.load_markets()
        market = self.market(symbol)
        messageHash = 'ticker:' + market['symbol']
        request = {
            'action': 'subscribe',
            'quotes': [market['id']],
        }
        return await self.watch(url, messageHash, self.extend(request, params), messageHash)

    def handle_ticker(self, client: Client, message):
        #
        #    {
        #         T: 'q',
        #         S: 'BTC/USDT',
        #         bp: 17394.44,
        #         bs: 0.021981,
        #         ap: 17397.99,
        #         as: 0.02,
        #         t: '2022-12-16T06:07:56.611063286Z'
        #    ]
        #
        ticker = self.parse_ticker(message)
        symbol = ticker['symbol']
        messageHash = 'ticker:' + symbol
        self.tickers[symbol] = ticker
        client.resolve(self.tickers[symbol], messageHash)

    def parse_ticker(self, ticker, market=None):
        #
        #    {
        #         T: 'q',
        #         S: 'BTC/USDT',
        #         bp: 17394.44,
        #         bs: 0.021981,
        #         ap: 17397.99,
        #         as: 0.02,
        #         t: '2022-12-16T06:07:56.611063286Z'
        #    }
        #
        marketId = self.safe_string(ticker, 'S')
        datetime = self.safe_string(ticker, 't')
        return self.safe_ticker({
            'symbol': self.safe_symbol(marketId, market),
            'timestamp': self.parse8601(datetime),
            'datetime': datetime,
            'high': None,
            'low': None,
            'bid': self.safe_string(ticker, 'bp'),
            'bidVolume': self.safe_string(ticker, 'bs'),
            'ask': self.safe_string(ticker, 'ap'),
            'askVolume': self.safe_string(ticker, 'as'),
            'vwap': None,
            'open': None,
            'close': None,
            'last': None,
            'previousClose': None,
            'change': None,
            'percentage': None,
            'average': None,
            'baseVolume': None,
            'quoteVolume': None,
            'info': ticker,
        }, market)

    async def watch_ohlcv(self, symbol: str, timeframe='1m', since: Optional[int] = None, limit: Optional[int] = None, params={}):
        """
        watches historical candlestick data containing the open, high, low, and close price, and the volume of a market
        :param str symbol: unified symbol of the market to fetch OHLCV data for
        :param str timeframe: the length of time each candle represents
        :param int|None since: timestamp in ms of the earliest candle to fetch
        :param int|None limit: the maximum amount of candles to fetch
        :param dict params: extra parameters specific to the alpaca api endpoint
        :returns [[int]]: A list of candles ordered, open, high, low, close, volume
        """
        url = self.urls['api']['ws']['crypto']
        await self.authenticate(url)
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        request = {
            'action': 'subscribe',
            'bars': [market['id']],
        }
        messageHash = 'ohlcv:' + symbol
        ohlcv = await self.watch(url, messageHash, self.extend(request, params), messageHash)
        if self.newUpdates:
            limit = ohlcv.getLimit(symbol, limit)
        return self.filter_by_since_limit(ohlcv, since, limit, 0, True)

    def handle_ohlcv(self, client: Client, message):
        #
        #    {
        #        T: 'b',
        #        S: 'BTC/USDT',
        #        o: 17416.39,
        #        h: 17424.82,
        #        l: 17416.39,
        #        c: 17424.82,
        #        v: 1.341054,
        #        t: '2022-12-16T06:53:00Z',
        #        n: 21,
        #        vw: 17421.9529234915
        #    }
        #
        marketId = self.safe_string(message, 'S')
        symbol = self.safe_symbol(marketId)
        stored = self.safe_value(self.ohlcvs, symbol)
        if stored is None:
            limit = self.safe_integer(self.options, 'OHLCVLimit', 1000)
            stored = ArrayCacheByTimestamp(limit)
            self.ohlcvs[symbol] = stored
        parsed = self.parse_ohlcv(message)
        stored.append(parsed)
        messageHash = 'ohlcv:' + symbol
        client.resolve(stored, messageHash)

    async def watch_order_book(self, symbol: str, limit: Optional[int] = None, params={}):
        """
        watches information on open orders with bid(buy) and ask(sell) prices, volumes and other data
        :param str symbol: unified symbol of the market to fetch the order book for
        :param int|None limit: the maximum amount of order book entries to return.
        :param dict params: extra parameters specific to the alpaca api endpoint
        :returns dict: A dictionary of `order book structures <https://docs.ccxt.com/#/?id=order-book-structure>` indexed by market symbols
        """
        url = self.urls['api']['ws']['crypto']
        await self.authenticate(url)
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        messageHash = 'orderbook' + ':' + symbol
        request = {
            'action': 'subscribe',
            'orderbooks': [market['id']],
        }
        orderbook = await self.watch(url, messageHash, self.extend(request, params), messageHash)
        return orderbook.limit()

    def handle_order_book(self, client: Client, message):
        #
        # snapshot
        #    {
        #        T: "o",
        #        S: "BTC/USDT",
        #        t: "2022-12-16T06:35:31.585113205Z",
        #        b: [{
        #                p: 17394.37,
        #                s: 0.015499,
        #            },
        #            ...
        #        ],
        #        a: [{
        #                p: 17398.8,
        #                s: 0.042919,
        #            },
        #            ...
        #        ],
        #        r: True,
        #    }
        #
        marketId = self.safe_string(message, 'S')
        symbol = self.safe_symbol(marketId)
        datetime = self.safe_string(message, 't')
        timestamp = self.parse8601(datetime)
        isSnapshot = self.safe_value(message, 'r', False)
        orderbook = self.safe_value(self.orderbooks, symbol)
        if orderbook is None:
            orderbook = self.order_book()
        if isSnapshot:
            snapshot = self.parse_order_book(message, symbol, timestamp, 'b', 'a', 'p', 's')
            orderbook.reset(snapshot)
        else:
            asks = self.safe_value(message, 'a', [])
            bids = self.safe_value(message, 'b', [])
            self.handle_deltas(orderbook['asks'], asks)
            self.handle_deltas(orderbook['bids'], bids)
            orderbook['timestamp'] = timestamp
            orderbook['datetime'] = datetime
        messageHash = 'orderbook' + ':' + symbol
        self.orderbooks[symbol] = orderbook
        client.resolve(orderbook, messageHash)

    def handle_delta(self, bookside, delta):
        bidAsk = self.parse_bid_ask(delta, 'p', 's')
        bookside.storeArray(bidAsk)

    def handle_deltas(self, bookside, deltas):
        for i in range(0, len(deltas)):
            self.handle_delta(bookside, deltas[i])

    async def watch_trades(self, symbol: str, since: Optional[int] = None, limit: Optional[int] = None, params={}):
        """
        watches information on multiple trades made in a market
        :param str symbol: unified market symbol of the market orders were made in
        :param int|None since: the earliest time in ms to fetch orders for
        :param int|None limit: the maximum number of  orde structures to retrieve
        :param dict params: extra parameters specific to the alpaca api endpoint
        :returns [dict]: a list of [order structures]{@link https://docs.ccxt.com/#/?id=order-structure
        """
        url = self.urls['api']['ws']['crypto']
        await self.authenticate(url)
        await self.load_markets()
        market = self.market(symbol)
        symbol = market['symbol']
        messageHash = 'trade:' + symbol
        request = {
            'action': 'subscribe',
            'trades': [market['id']],
        }
        trades = await self.watch(url, messageHash, self.extend(request, params), messageHash)
        if self.newUpdates:
            limit = trades.getLimit(symbol, limit)
        return self.filter_by_since_limit(trades, since, limit, 'timestamp', True)

    def handle_trades(self, client: Client, message):
        #
        #     {
        #         T: 't',
        #         S: 'BTC/USDT',
        #         p: 17408.8,
        #         s: 0.042919,
        #         t: '2022-12-16T06:43:18.327Z',
        #         i: 16585162,
        #         tks: 'B'
        #     ]
        #
        marketId = self.safe_string(message, 'S')
        symbol = self.safe_symbol(marketId)
        stored = self.safe_value(self.trades, symbol)
        if stored is None:
            limit = self.safe_integer(self.options, 'tradesLimit', 1000)
            stored = ArrayCache(limit)
            self.trades[symbol] = stored
        parsed = self.parse_trade(message)
        stored.append(parsed)
        messageHash = 'trade' + ':' + symbol
        client.resolve(stored, messageHash)

    async def watch_my_trades(self, symbol: Optional[str] = None, since: Optional[int] = None, limit: Optional[int] = None, params={}):
        """
        watches information on multiple trades made by the user
        :param str symbol: unified market symbol of the market orders were made in
        :param int|None since: the earliest time in ms to fetch orders for
        :param int|None limit: the maximum number of  orde structures to retrieve
        :param dict params: extra parameters specific to the alpaca api endpoint
        :param boolean params['unifiedMargin']: use unified margin account
        :returns [dict]: a list of [order structures]{@link https://docs.ccxt.com/#/?id=order-structure
        """
        url = self.urls['api']['ws']['trading']
        await self.authenticate(url)
        messageHash = 'myTrades'
        await self.load_markets()
        if symbol is not None:
            symbol = self.symbol(symbol)
            messageHash += ':' + symbol
        request = {
            'action': 'listen',
            'data': {
                'streams': ['trade_updates'],
            },
        }
        trades = await self.watch(url, messageHash, self.extend(request, params), messageHash)
        if self.newUpdates:
            limit = trades.getLimit(symbol, limit)
        return self.filter_by_since_limit(trades, since, limit, 'timestamp', True)

    async def watch_orders(self, symbol: Optional[str] = None, since: Optional[int] = None, limit: Optional[int] = None, params={}):
        """
        watches information on multiple orders made by the user
        :param str|None symbol: unified market symbol of the market orders were made in
        :param int|None since: the earliest time in ms to fetch orders for
        :param int|None limit: the maximum number of  orde structures to retrieve
        :param dict params: extra parameters specific to the alpaca api endpoint
        :returns [dict]: a list of [order structures]{@link https://docs.ccxt.com/#/?id=order-structure
        """
        url = self.urls['api']['ws']['trading']
        await self.authenticate(url)
        await self.load_markets()
        messageHash = 'orders'
        if symbol is not None:
            market = self.market(symbol)
            symbol = market['symbol']
            messageHash = 'orders:' + symbol
        request = {
            'action': 'listen',
            'data': {
                'streams': ['trade_updates'],
            },
        }
        orders = await self.watch(url, messageHash, self.extend(request, params), messageHash)
        if self.newUpdates:
            limit = orders.getLimit(symbol, limit)
        return self.filter_by_symbol_since_limit(orders, symbol, since, limit, True)

    def handle_trade_update(self, client: Client, message):
        self.handle_order(client, message)
        self.handle_my_trade(client, message)

    def handle_order(self, client: Client, message):
        #
        #    {
        #        stream: 'trade_updates',
        #        data: {
        #          event: 'new',
        #          timestamp: '2022-12-16T07:28:51.67621869Z',
        #          order: {
        #            id: 'c2470331-8993-4051-bf5d-428d5bdc9a48',
        #            client_order_id: '0f1f3764-107a-4d09-8b9a-d75a11738f5c',
        #            created_at: '2022-12-16T02:28:51.673531798-05:00',
        #            updated_at: '2022-12-16T02:28:51.678736847-05:00',
        #            submitted_at: '2022-12-16T02:28:51.673015558-05:00',
        #            filled_at: null,
        #            expired_at: null,
        #            cancel_requested_at: null,
        #            canceled_at: null,
        #            failed_at: null,
        #            replaced_at: null,
        #            replaced_by: null,
        #            replaces: null,
        #            asset_id: '276e2673-764b-4ab6-a611-caf665ca6340',
        #            symbol: 'BTC/USD',
        #            asset_class: 'crypto',
        #            notional: null,
        #            qty: '0.01',
        #            filled_qty: '0',
        #            filled_avg_price: null,
        #            order_class: '',
        #            order_type: 'market',
        #            type: 'market',
        #            side: 'buy',
        #            time_in_force: 'gtc',
        #            limit_price: null,
        #            stop_price: null,
        #            status: 'new',
        #            extended_hours: False,
        #            legs: null,
        #            trail_percent: null,
        #            trail_price: null,
        #            hwm: null
        #          },
        #          execution_id: '5f781a30-b9a3-4c86-b466-2175850cf340'
        #        }
        #      }
        #
        data = self.safe_value(message, 'data', {})
        rawOrder = self.safe_value(data, 'order', {})
        if self.orders is None:
            limit = self.safe_integer(self.options, 'ordersLimit', 1000)
            self.orders = ArrayCacheBySymbolById(limit)
        orders = self.orders
        order = self.parse_order(rawOrder)
        orders.append(order)
        messageHash = 'orders'
        client.resolve(orders, messageHash)
        messageHash = 'orders:' + order['symbol']
        client.resolve(orders, messageHash)

    def handle_my_trade(self, client: Client, message):
        #
        #    {
        #        stream: 'trade_updates',
        #        data: {
        #          event: 'new',
        #          timestamp: '2022-12-16T07:28:51.67621869Z',
        #          order: {
        #            id: 'c2470331-8993-4051-bf5d-428d5bdc9a48',
        #            client_order_id: '0f1f3764-107a-4d09-8b9a-d75a11738f5c',
        #            created_at: '2022-12-16T02:28:51.673531798-05:00',
        #            updated_at: '2022-12-16T02:28:51.678736847-05:00',
        #            submitted_at: '2022-12-16T02:28:51.673015558-05:00',
        #            filled_at: null,
        #            expired_at: null,
        #            cancel_requested_at: null,
        #            canceled_at: null,
        #            failed_at: null,
        #            replaced_at: null,
        #            replaced_by: null,
        #            replaces: null,
        #            asset_id: '276e2673-764b-4ab6-a611-caf665ca6340',
        #            symbol: 'BTC/USD',
        #            asset_class: 'crypto',
        #            notional: null,
        #            qty: '0.01',
        #            filled_qty: '0',
        #            filled_avg_price: null,
        #            order_class: '',
        #            order_type: 'market',
        #            type: 'market',
        #            side: 'buy',
        #            time_in_force: 'gtc',
        #            limit_price: null,
        #            stop_price: null,
        #            status: 'new',
        #            extended_hours: False,
        #            legs: null,
        #            trail_percent: null,
        #            trail_price: null,
        #            hwm: null
        #          },
        #          execution_id: '5f781a30-b9a3-4c86-b466-2175850cf340'
        #        }
        #      }
        #
        data = self.safe_value(message, 'data', {})
        event = self.safe_string(data, 'event')
        if event != 'fill' and event != 'partial_fill':
            return
        rawOrder = self.safe_value(data, 'order', {})
        myTrades = self.myTrades
        if myTrades is None:
            limit = self.safe_integer(self.options, 'tradesLimit', 1000)
            myTrades = ArrayCacheBySymbolById(limit)
        trade = self.parse_my_trade(rawOrder)
        myTrades.append(trade)
        messageHash = 'myTrades:' + trade['symbol']
        client.resolve(myTrades, messageHash)
        messageHash = 'myTrades'
        client.resolve(myTrades, messageHash)

    def parse_my_trade(self, trade, market=None):
        #
        #    {
        #        id: 'c2470331-8993-4051-bf5d-428d5bdc9a48',
        #        client_order_id: '0f1f3764-107a-4d09-8b9a-d75a11738f5c',
        #        created_at: '2022-12-16T02:28:51.673531798-05:00',
        #        updated_at: '2022-12-16T02:28:51.678736847-05:00',
        #        submitted_at: '2022-12-16T02:28:51.673015558-05:00',
        #        filled_at: null,
        #        expired_at: null,
        #        cancel_requested_at: null,
        #        canceled_at: null,
        #        failed_at: null,
        #        replaced_at: null,
        #        replaced_by: null,
        #        replaces: null,
        #        asset_id: '276e2673-764b-4ab6-a611-caf665ca6340',
        #        symbol: 'BTC/USD',
        #        asset_class: 'crypto',
        #        notional: null,
        #        qty: '0.01',
        #        filled_qty: '0',
        #        filled_avg_price: null,
        #        order_class: '',
        #        order_type: 'market',
        #        type: 'market',
        #        side: 'buy',
        #        time_in_force: 'gtc',
        #        limit_price: null,
        #        stop_price: null,
        #        status: 'new',
        #        extended_hours: False,
        #        legs: null,
        #        trail_percent: null,
        #        trail_price: null,
        #        hwm: null
        #    }
        #
        marketId = self.safe_string(trade, 'symbol')
        datetime = self.safe_string(trade, 'filled_at')
        type = self.safe_string(trade, 'type')
        if type.find('limit') >= 0:
            # might be limit or stop-limit
            type = 'limit'
        return self.safe_trade({
            'id': self.safe_string(trade, 'i'),
            'info': trade,
            'timestamp': self.parse8601(datetime),
            'datetime': datetime,
            'symbol': self.safe_symbol(marketId, None, '/'),
            'order': self.safe_string(trade, 'id'),
            'type': type,
            'side': self.safe_string(trade, 'side'),
            'takerOrMaker': 'taker' if (type == 'market') else 'maker',
            'price': self.safe_string(trade, 'filled_avg_price'),
            'amount': self.safe_string(trade, 'filled_qty'),
            'cost': None,
            'fee': None,
        }, market)

    async def authenticate(self, url, params={}):
        self.check_required_credentials()
        messageHash = 'authenticated'
        client = self.client(url)
        future = self.safe_value(client.subscriptions, messageHash)
        if future is None:
            future = client.future('authenticated')
            request = {
                'action': 'auth',
                'key': self.apiKey,
                'secret': self.secret,
            }
            if url == self.urls['api']['ws']['trading']:
                # self auth request is being deprecated in test environment
                request = {
                    'action': 'authenticate',
                    'data': {
                        'key_id': self.apiKey,
                        'secret_key': self.secret,
                    },
                }
            self.spawn(self.watch, url, messageHash, request, messageHash, future)
        return await future

    def handle_error_message(self, client: Client, message):
        #
        #    {
        #        T: 'error',
        #        code: 400,
        #        msg: 'invalid syntax'
        #    }
        #
        code = self.safe_string(message, 'code')
        msg = self.safe_value(message, 'msg', {})
        raise ExchangeError(self.id + ' code: ' + code + ' message: ' + msg)

    def handle_connected(self, client: Client, message):
        #
        #    {
        #        T: 'success',
        #        msg: 'connected'
        #    }
        #
        return message

    def handle_crypto_message(self, client: Client, message):
        for i in range(0, len(message)):
            data = message[i]
            T = self.safe_string(data, 'T')
            msg = self.safe_value(data, 'msg', {})
            if T == 'subscription':
                return self.handle_subscription(client, data)
            if T == 'success' and msg == 'connected':
                return self.handle_connected(client, data)
            if T == 'success' and msg == 'authenticated':
                return self.handle_authenticate(client, data)
            methods = {
                'error': self.handle_error_message,
                'b': self.handle_ohlcv,
                'q': self.handle_ticker,
                't': self.handle_trades,
                'o': self.handle_order_book,
            }
            method = self.safe_value(methods, T)
            if method is not None:
                method(client, data)

    def handle_trading_message(self, client: Client, message):
        stream = self.safe_string(message, 'stream')
        methods = {
            'authorization': self.handle_authenticate,
            'listening': self.handle_subscription,
            'trade_updates': self.handle_trade_update,
        }
        method = self.safe_value(methods, stream)
        if method is not None:
            method(client, message)

    def handle_message(self, client: Client, message):
        if isinstance(message, list):
            return self.handle_crypto_message(client, message)
        self.handle_trading_message(client, message)

    def handle_authenticate(self, client: Client, message):
        #
        # crypto
        #    {
        #        T: 'success',
        #        msg: 'connected'
        #    ]
        #
        # trading
        #    {
        #        "stream": "authorization",
        #        "data": {
        #            "status": "authorized",
        #            "action": "authenticate"
        #        }
        #    }
        # error
        #    {
        #        stream: 'authorization',
        #        data: {
        #            action: 'authenticate',
        #            message: 'access key verification failed',
        #            status: 'unauthorized'
        #        }
        #    }
        #
        T = self.safe_string(message, 'T')
        data = self.safe_value(message, 'data', {})
        status = self.safe_string(data, 'status')
        if T == 'success' or status == 'authorized':
            client.resolve(message, 'authenticated')
            return
        raise AuthenticationError(self.id + ' failed to authenticate.')

    def handle_subscription(self, client: Client, message):
        #
        # crypto
        #    {
        #          T: 'subscription',
        #          trades: [],
        #          quotes: ['BTC/USDT'],
        #          orderbooks: [],
        #          bars: [],
        #          updatedBars: [],
        #          dailyBars: []
        #    }
        # trading
        #    {
        #        stream: 'listening',
        #        data: {
        #            streams: ['trade_updates']
        #        }
        #    }
        #
        return message
