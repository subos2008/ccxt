<?php

namespace ccxt\abstract;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code


abstract class btcex extends \ccxt\Exchange {
    public function public_get_get_last_trades_by_currency($params = array()) {
        return $this->request('get_last_trades_by_currency', 'public', 'GET', $params);
    }
    public function public_get_get_last_trades_by_instrument($params = array()) {
        return $this->request('get_last_trades_by_instrument', 'public', 'GET', $params);
    }
    public function public_get_get_order_book($params = array()) {
        return $this->request('get_order_book', 'public', 'GET', $params);
    }
    public function public_get_tickers($params = array()) {
        return $this->request('tickers', 'public', 'GET', $params);
    }
    public function public_get_get_instruments($params = array()) {
        return $this->request('get_instruments', 'public', 'GET', $params);
    }
    public function public_get_get_tradingview_chart_data($params = array()) {
        return $this->request('get_tradingview_chart_data', 'public', 'GET', $params);
    }
    public function public_get_cmc_spot_summary($params = array()) {
        return $this->request('cmc_spot_summary', 'public', 'GET', $params);
    }
    public function public_get_cmc_spot_ticker($params = array()) {
        return $this->request('cmc_spot_ticker', 'public', 'GET', $params);
    }
    public function public_get_cmc_spot_orderbook($params = array()) {
        return $this->request('cmc_spot_orderbook', 'public', 'GET', $params);
    }
    public function public_get_cmc_market_trades($params = array()) {
        return $this->request('cmc_market_trades', 'public', 'GET', $params);
    }
    public function public_get_cmc_contracts($params = array()) {
        return $this->request('cmc_contracts', 'public', 'GET', $params);
    }
    public function public_get_cmc_contract_orderbook($params = array()) {
        return $this->request('cmc_contract_orderbook', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_spot_pairs($params = array()) {
        return $this->request('coin_gecko_spot_pairs', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_spot_ticker($params = array()) {
        return $this->request('coin_gecko_spot_ticker', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_spot_orderbook($params = array()) {
        return $this->request('coin_gecko_spot_orderbook', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_market_trades($params = array()) {
        return $this->request('coin_gecko_market_trades', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_contracts($params = array()) {
        return $this->request('coin_gecko_contracts', 'public', 'GET', $params);
    }
    public function public_get_coin_gecko_contract_orderbook($params = array()) {
        return $this->request('coin_gecko_contract_orderbook', 'public', 'GET', $params);
    }
    public function public_get_get_perpetual_leverage_bracket($params = array()) {
        return $this->request('get_perpetual_leverage_bracket', 'public', 'GET', $params);
    }
    public function public_get_get_perpetual_leverage_bracket_all($params = array()) {
        return $this->request('get_perpetual_leverage_bracket_all', 'public', 'GET', $params);
    }
    public function public_post_auth($params = array()) {
        return $this->request('auth', 'public', 'POST', $params);
    }
    public function private_get_get_deposit_record($params = array()) {
        return $this->request('get_deposit_record', 'private', 'GET', $params);
    }
    public function private_get_get_withdraw_record($params = array()) {
        return $this->request('get_withdraw_record', 'private', 'GET', $params);
    }
    public function private_get_get_position($params = array()) {
        return $this->request('get_position', 'private', 'GET', $params);
    }
    public function private_get_get_positions($params = array()) {
        return $this->request('get_positions', 'private', 'GET', $params);
    }
    public function private_get_get_open_orders_by_currency($params = array()) {
        return $this->request('get_open_orders_by_currency', 'private', 'GET', $params);
    }
    public function private_get_get_open_orders_by_instrument($params = array()) {
        return $this->request('get_open_orders_by_instrument', 'private', 'GET', $params);
    }
    public function private_get_get_order_history_by_currency($params = array()) {
        return $this->request('get_order_history_by_currency', 'private', 'GET', $params);
    }
    public function private_get_get_order_history_by_instrument($params = array()) {
        return $this->request('get_order_history_by_instrument', 'private', 'GET', $params);
    }
    public function private_get_get_order_state($params = array()) {
        return $this->request('get_order_state', 'private', 'GET', $params);
    }
    public function private_get_get_user_trades_by_currency($params = array()) {
        return $this->request('get_user_trades_by_currency', 'private', 'GET', $params);
    }
    public function private_get_get_user_trades_by_instrument($params = array()) {
        return $this->request('get_user_trades_by_instrument', 'private', 'GET', $params);
    }
    public function private_get_get_user_trades_by_order($params = array()) {
        return $this->request('get_user_trades_by_order', 'private', 'GET', $params);
    }
    public function private_get_get_perpetual_user_config($params = array()) {
        return $this->request('get_perpetual_user_config', 'private', 'GET', $params);
    }
    public function private_post_logout($params = array()) {
        return $this->request('logout', 'private', 'POST', $params);
    }
    public function private_post_get_assets_info($params = array()) {
        return $this->request('get_assets_info', 'private', 'POST', $params);
    }
    public function private_post_add_withdraw_address($params = array()) {
        return $this->request('add_withdraw_address', 'private', 'POST', $params);
    }
    public function private_post_buy($params = array()) {
        return $this->request('buy', 'private', 'POST', $params);
    }
    public function private_post_sell($params = array()) {
        return $this->request('sell', 'private', 'POST', $params);
    }
    public function private_post_cancel($params = array()) {
        return $this->request('cancel', 'private', 'POST', $params);
    }
    public function private_post_cancel_all_by_currency($params = array()) {
        return $this->request('cancel_all_by_currency', 'private', 'POST', $params);
    }
    public function private_post_cancel_all_by_instrument($params = array()) {
        return $this->request('cancel_all_by_instrument', 'private', 'POST', $params);
    }
    public function private_post_close_position($params = array()) {
        return $this->request('close_position', 'private', 'POST', $params);
    }
    public function private_post_adjust_perpetual_leverage($params = array()) {
        return $this->request('adjust_perpetual_leverage', 'private', 'POST', $params);
    }
    public function private_post_adjust_perpetual_margin_type($params = array()) {
        return $this->request('adjust_perpetual_margin_type', 'private', 'POST', $params);
    }
    public function private_post_submit_transfer($params = array()) {
        return $this->request('submit_transfer', 'private', 'POST', $params);
    }
    public function publicGetGetLastTradesByCurrency($params = array()) {
        return $this->request('get_last_trades_by_currency', 'public', 'GET', $params);
    }
    public function publicGetGetLastTradesByInstrument($params = array()) {
        return $this->request('get_last_trades_by_instrument', 'public', 'GET', $params);
    }
    public function publicGetGetOrderBook($params = array()) {
        return $this->request('get_order_book', 'public', 'GET', $params);
    }
    public function publicGetTickers($params = array()) {
        return $this->request('tickers', 'public', 'GET', $params);
    }
    public function publicGetGetInstruments($params = array()) {
        return $this->request('get_instruments', 'public', 'GET', $params);
    }
    public function publicGetGetTradingviewChartData($params = array()) {
        return $this->request('get_tradingview_chart_data', 'public', 'GET', $params);
    }
    public function publicGetCmcSpotSummary($params = array()) {
        return $this->request('cmc_spot_summary', 'public', 'GET', $params);
    }
    public function publicGetCmcSpotTicker($params = array()) {
        return $this->request('cmc_spot_ticker', 'public', 'GET', $params);
    }
    public function publicGetCmcSpotOrderbook($params = array()) {
        return $this->request('cmc_spot_orderbook', 'public', 'GET', $params);
    }
    public function publicGetCmcMarketTrades($params = array()) {
        return $this->request('cmc_market_trades', 'public', 'GET', $params);
    }
    public function publicGetCmcContracts($params = array()) {
        return $this->request('cmc_contracts', 'public', 'GET', $params);
    }
    public function publicGetCmcContractOrderbook($params = array()) {
        return $this->request('cmc_contract_orderbook', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoSpotPairs($params = array()) {
        return $this->request('coin_gecko_spot_pairs', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoSpotTicker($params = array()) {
        return $this->request('coin_gecko_spot_ticker', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoSpotOrderbook($params = array()) {
        return $this->request('coin_gecko_spot_orderbook', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoMarketTrades($params = array()) {
        return $this->request('coin_gecko_market_trades', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoContracts($params = array()) {
        return $this->request('coin_gecko_contracts', 'public', 'GET', $params);
    }
    public function publicGetCoinGeckoContractOrderbook($params = array()) {
        return $this->request('coin_gecko_contract_orderbook', 'public', 'GET', $params);
    }
    public function publicGetGetPerpetualLeverageBracket($params = array()) {
        return $this->request('get_perpetual_leverage_bracket', 'public', 'GET', $params);
    }
    public function publicGetGetPerpetualLeverageBracketAll($params = array()) {
        return $this->request('get_perpetual_leverage_bracket_all', 'public', 'GET', $params);
    }
    public function publicPostAuth($params = array()) {
        return $this->request('auth', 'public', 'POST', $params);
    }
    public function privateGetGetDepositRecord($params = array()) {
        return $this->request('get_deposit_record', 'private', 'GET', $params);
    }
    public function privateGetGetWithdrawRecord($params = array()) {
        return $this->request('get_withdraw_record', 'private', 'GET', $params);
    }
    public function privateGetGetPosition($params = array()) {
        return $this->request('get_position', 'private', 'GET', $params);
    }
    public function privateGetGetPositions($params = array()) {
        return $this->request('get_positions', 'private', 'GET', $params);
    }
    public function privateGetGetOpenOrdersByCurrency($params = array()) {
        return $this->request('get_open_orders_by_currency', 'private', 'GET', $params);
    }
    public function privateGetGetOpenOrdersByInstrument($params = array()) {
        return $this->request('get_open_orders_by_instrument', 'private', 'GET', $params);
    }
    public function privateGetGetOrderHistoryByCurrency($params = array()) {
        return $this->request('get_order_history_by_currency', 'private', 'GET', $params);
    }
    public function privateGetGetOrderHistoryByInstrument($params = array()) {
        return $this->request('get_order_history_by_instrument', 'private', 'GET', $params);
    }
    public function privateGetGetOrderState($params = array()) {
        return $this->request('get_order_state', 'private', 'GET', $params);
    }
    public function privateGetGetUserTradesByCurrency($params = array()) {
        return $this->request('get_user_trades_by_currency', 'private', 'GET', $params);
    }
    public function privateGetGetUserTradesByInstrument($params = array()) {
        return $this->request('get_user_trades_by_instrument', 'private', 'GET', $params);
    }
    public function privateGetGetUserTradesByOrder($params = array()) {
        return $this->request('get_user_trades_by_order', 'private', 'GET', $params);
    }
    public function privateGetGetPerpetualUserConfig($params = array()) {
        return $this->request('get_perpetual_user_config', 'private', 'GET', $params);
    }
    public function privatePostLogout($params = array()) {
        return $this->request('logout', 'private', 'POST', $params);
    }
    public function privatePostGetAssetsInfo($params = array()) {
        return $this->request('get_assets_info', 'private', 'POST', $params);
    }
    public function privatePostAddWithdrawAddress($params = array()) {
        return $this->request('add_withdraw_address', 'private', 'POST', $params);
    }
    public function privatePostBuy($params = array()) {
        return $this->request('buy', 'private', 'POST', $params);
    }
    public function privatePostSell($params = array()) {
        return $this->request('sell', 'private', 'POST', $params);
    }
    public function privatePostCancel($params = array()) {
        return $this->request('cancel', 'private', 'POST', $params);
    }
    public function privatePostCancelAllByCurrency($params = array()) {
        return $this->request('cancel_all_by_currency', 'private', 'POST', $params);
    }
    public function privatePostCancelAllByInstrument($params = array()) {
        return $this->request('cancel_all_by_instrument', 'private', 'POST', $params);
    }
    public function privatePostClosePosition($params = array()) {
        return $this->request('close_position', 'private', 'POST', $params);
    }
    public function privatePostAdjustPerpetualLeverage($params = array()) {
        return $this->request('adjust_perpetual_leverage', 'private', 'POST', $params);
    }
    public function privatePostAdjustPerpetualMarginType($params = array()) {
        return $this->request('adjust_perpetual_margin_type', 'private', 'POST', $params);
    }
    public function privatePostSubmitTransfer($params = array()) {
        return $this->request('submit_transfer', 'private', 'POST', $params);
    }
}