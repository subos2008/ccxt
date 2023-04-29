<?php

namespace ccxt\abstract;

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code


abstract class ascendex extends \ccxt\Exchange {
    public function v1_public_get_assets($params = array()) {
        return $this->request('assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_products($params = array()) {
        return $this->request('products', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_ticker($params = array()) {
        return $this->request('ticker', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_barhist_info($params = array()) {
        return $this->request('barhist/info', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_barhist($params = array()) {
        return $this->request('barhist', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_depth($params = array()) {
        return $this->request('depth', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_trades($params = array()) {
        return $this->request('trades', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_cash_assets($params = array()) {
        return $this->request('cash/assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_cash_products($params = array()) {
        return $this->request('cash/products', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_margin_assets($params = array()) {
        return $this->request('margin/assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_margin_products($params = array()) {
        return $this->request('margin/products', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_futures_collateral($params = array()) {
        return $this->request('futures/collateral', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_futures_contracts($params = array()) {
        return $this->request('futures/contracts', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_futures_ref_px($params = array()) {
        return $this->request('futures/ref-px', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_futures_market_data($params = array()) {
        return $this->request('futures/market-data', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_futures_funding_rates($params = array()) {
        return $this->request('futures/funding-rates', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_risk_limit_info($params = array()) {
        return $this->request('risk-limit-info', array('v1', 'public'), 'GET', $params);
    }
    public function v1_public_get_exchange_info($params = array()) {
        return $this->request('exchange-info', array('v1', 'public'), 'GET', $params);
    }
    public function v1_private_get_info($params = array()) {
        return $this->request('info', array('v1', 'private'), 'GET', $params);
    }
    public function v1_private_get_wallet_transactions($params = array()) {
        return $this->request('wallet/transactions', array('v1', 'private'), 'GET', $params);
    }
    public function v1_private_get_wallet_deposit_address($params = array()) {
        return $this->request('wallet/deposit/address', array('v1', 'private'), 'GET', $params);
    }
    public function v1_private_get_data_balance_snapshot($params = array()) {
        return $this->request('data/balance/snapshot', array('v1', 'private'), 'GET', $params);
    }
    public function v1_private_get_data_balance_history($params = array()) {
        return $this->request('data/balance/history', array('v1', 'private'), 'GET', $params);
    }
    public function v1_private_accountcategory_get_balance($params = array()) {
        return $this->request('balance', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1_private_accountcategory_get_order_open($params = array()) {
        return $this->request('order/open', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1_private_accountcategory_get_order_status($params = array()) {
        return $this->request('order/status', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1_private_accountcategory_get_order_hist_current($params = array()) {
        return $this->request('order/hist/current', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1_private_accountcategory_get_risk($params = array()) {
        return $this->request('risk', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1_private_accountcategory_post_order($params = array()) {
        return $this->request('order', array('v1', 'private', 'accountCategory'), 'POST', $params);
    }
    public function v1_private_accountcategory_post_order_batch($params = array()) {
        return $this->request('order/batch', array('v1', 'private', 'accountCategory'), 'POST', $params);
    }
    public function v1_private_accountcategory_delete_order($params = array()) {
        return $this->request('order', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1_private_accountcategory_delete_order_all($params = array()) {
        return $this->request('order/all', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1_private_accountcategory_delete_order_batch($params = array()) {
        return $this->request('order/batch', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1_private_accountgroup_get_cash_balance($params = array()) {
        return $this->request('cash/balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_margin_balance($params = array()) {
        return $this->request('margin/balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_margin_risk($params = array()) {
        return $this->request('margin/risk', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_futures_collateral_balance($params = array()) {
        return $this->request('futures/collateral-balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_futures_position($params = array()) {
        return $this->request('futures/position', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_futures_risk($params = array()) {
        return $this->request('futures/risk', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_futures_funding_payments($params = array()) {
        return $this->request('futures/funding-payments', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_order_hist($params = array()) {
        return $this->request('order/hist', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_get_spot_fee($params = array()) {
        return $this->request('spot/fee', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1_private_accountgroup_post_transfer($params = array()) {
        return $this->request('transfer', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v1_private_accountgroup_post_futures_transfer_deposit($params = array()) {
        return $this->request('futures/transfer/deposit', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v1_private_accountgroup_post_futures_transfer_withdraw($params = array()) {
        return $this->request('futures/transfer/withdraw', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_public_get_assets($params = array()) {
        return $this->request('assets', array('v2', 'public'), 'GET', $params);
    }
    public function v2_public_get_futures_contract($params = array()) {
        return $this->request('futures/contract', array('v2', 'public'), 'GET', $params);
    }
    public function v2_public_get_futures_collateral($params = array()) {
        return $this->request('futures/collateral', array('v2', 'public'), 'GET', $params);
    }
    public function v2_public_get_futures_pricing_data($params = array()) {
        return $this->request('futures/pricing-data', array('v2', 'public'), 'GET', $params);
    }
    public function v2_public_get_futures_ticker($params = array()) {
        return $this->request('futures/ticker', array('v2', 'public'), 'GET', $params);
    }
    public function v2_private_data_get_order_hist($params = array()) {
        return $this->request('order/hist', array('v2', 'private', 'data'), 'GET', $params);
    }
    public function v2_private_get_account_info($params = array()) {
        return $this->request('account/info', array('v2', 'private'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_order_hist($params = array()) {
        return $this->request('order/hist', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_futures_position($params = array()) {
        return $this->request('futures/position', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_futures_free_margin($params = array()) {
        return $this->request('futures/free-margin', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_futures_order_hist_current($params = array()) {
        return $this->request('futures/order/hist/current', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_futures_order_open($params = array()) {
        return $this->request('futures/order/open', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_get_futures_order_status($params = array()) {
        return $this->request('futures/order/status', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2_private_accountgroup_post_futures_isolated_position_margin($params = array()) {
        return $this->request('futures/isolated-position-margin', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_margin_type($params = array()) {
        return $this->request('futures/margin-type', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_leverage($params = array()) {
        return $this->request('futures/leverage', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_transfer_deposit($params = array()) {
        return $this->request('futures/transfer/deposit', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_transfer_withdraw($params = array()) {
        return $this->request('futures/transfer/withdraw', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_order($params = array()) {
        return $this->request('futures/order', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_order_batch($params = array()) {
        return $this->request('futures/order/batch', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_futures_order_open($params = array()) {
        return $this->request('futures/order/open', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_subuser_subuser_transfer($params = array()) {
        return $this->request('subuser/subuser-transfer', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_post_subuser_subuser_transfer_hist($params = array()) {
        return $this->request('subuser/subuser-transfer-hist', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2_private_accountgroup_delete_futures_order($params = array()) {
        return $this->request('futures/order', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
    public function v2_private_accountgroup_delete_futures_order_batch($params = array()) {
        return $this->request('futures/order/batch', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
    public function v2_private_accountgroup_delete_futures_order_all($params = array()) {
        return $this->request('futures/order/all', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
    public function v1PublicGetAssets($params = array()) {
        return $this->request('assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetProducts($params = array()) {
        return $this->request('products', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetTicker($params = array()) {
        return $this->request('ticker', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetBarhistInfo($params = array()) {
        return $this->request('barhist/info', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetBarhist($params = array()) {
        return $this->request('barhist', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetDepth($params = array()) {
        return $this->request('depth', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetTrades($params = array()) {
        return $this->request('trades', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetCashAssets($params = array()) {
        return $this->request('cash/assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetCashProducts($params = array()) {
        return $this->request('cash/products', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetMarginAssets($params = array()) {
        return $this->request('margin/assets', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetMarginProducts($params = array()) {
        return $this->request('margin/products', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetFuturesCollateral($params = array()) {
        return $this->request('futures/collateral', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetFuturesContracts($params = array()) {
        return $this->request('futures/contracts', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetFuturesRefPx($params = array()) {
        return $this->request('futures/ref-px', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetFuturesMarketData($params = array()) {
        return $this->request('futures/market-data', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetFuturesFundingRates($params = array()) {
        return $this->request('futures/funding-rates', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetRiskLimitInfo($params = array()) {
        return $this->request('risk-limit-info', array('v1', 'public'), 'GET', $params);
    }
    public function v1PublicGetExchangeInfo($params = array()) {
        return $this->request('exchange-info', array('v1', 'public'), 'GET', $params);
    }
    public function v1PrivateGetInfo($params = array()) {
        return $this->request('info', array('v1', 'private'), 'GET', $params);
    }
    public function v1PrivateGetWalletTransactions($params = array()) {
        return $this->request('wallet/transactions', array('v1', 'private'), 'GET', $params);
    }
    public function v1PrivateGetWalletDepositAddress($params = array()) {
        return $this->request('wallet/deposit/address', array('v1', 'private'), 'GET', $params);
    }
    public function v1PrivateGetDataBalanceSnapshot($params = array()) {
        return $this->request('data/balance/snapshot', array('v1', 'private'), 'GET', $params);
    }
    public function v1PrivateGetDataBalanceHistory($params = array()) {
        return $this->request('data/balance/history', array('v1', 'private'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryGetBalance($params = array()) {
        return $this->request('balance', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryGetOrderOpen($params = array()) {
        return $this->request('order/open', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryGetOrderStatus($params = array()) {
        return $this->request('order/status', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryGetOrderHistCurrent($params = array()) {
        return $this->request('order/hist/current', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryGetRisk($params = array()) {
        return $this->request('risk', array('v1', 'private', 'accountCategory'), 'GET', $params);
    }
    public function v1PrivateAccountCategoryPostOrder($params = array()) {
        return $this->request('order', array('v1', 'private', 'accountCategory'), 'POST', $params);
    }
    public function v1PrivateAccountCategoryPostOrderBatch($params = array()) {
        return $this->request('order/batch', array('v1', 'private', 'accountCategory'), 'POST', $params);
    }
    public function v1PrivateAccountCategoryDeleteOrder($params = array()) {
        return $this->request('order', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1PrivateAccountCategoryDeleteOrderAll($params = array()) {
        return $this->request('order/all', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1PrivateAccountCategoryDeleteOrderBatch($params = array()) {
        return $this->request('order/batch', array('v1', 'private', 'accountCategory'), 'DELETE', $params);
    }
    public function v1PrivateAccountGroupGetCashBalance($params = array()) {
        return $this->request('cash/balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetMarginBalance($params = array()) {
        return $this->request('margin/balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetMarginRisk($params = array()) {
        return $this->request('margin/risk', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetFuturesCollateralBalance($params = array()) {
        return $this->request('futures/collateral-balance', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetFuturesPosition($params = array()) {
        return $this->request('futures/position', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetFuturesRisk($params = array()) {
        return $this->request('futures/risk', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetFuturesFundingPayments($params = array()) {
        return $this->request('futures/funding-payments', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetOrderHist($params = array()) {
        return $this->request('order/hist', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupGetSpotFee($params = array()) {
        return $this->request('spot/fee', array('v1', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v1PrivateAccountGroupPostTransfer($params = array()) {
        return $this->request('transfer', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v1PrivateAccountGroupPostFuturesTransferDeposit($params = array()) {
        return $this->request('futures/transfer/deposit', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v1PrivateAccountGroupPostFuturesTransferWithdraw($params = array()) {
        return $this->request('futures/transfer/withdraw', array('v1', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PublicGetAssets($params = array()) {
        return $this->request('assets', array('v2', 'public'), 'GET', $params);
    }
    public function v2PublicGetFuturesContract($params = array()) {
        return $this->request('futures/contract', array('v2', 'public'), 'GET', $params);
    }
    public function v2PublicGetFuturesCollateral($params = array()) {
        return $this->request('futures/collateral', array('v2', 'public'), 'GET', $params);
    }
    public function v2PublicGetFuturesPricingData($params = array()) {
        return $this->request('futures/pricing-data', array('v2', 'public'), 'GET', $params);
    }
    public function v2PublicGetFuturesTicker($params = array()) {
        return $this->request('futures/ticker', array('v2', 'public'), 'GET', $params);
    }
    public function v2PrivateDataGetOrderHist($params = array()) {
        return $this->request('order/hist', array('v2', 'private', 'data'), 'GET', $params);
    }
    public function v2PrivateGetAccountInfo($params = array()) {
        return $this->request('account/info', array('v2', 'private'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetOrderHist($params = array()) {
        return $this->request('order/hist', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetFuturesPosition($params = array()) {
        return $this->request('futures/position', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetFuturesFreeMargin($params = array()) {
        return $this->request('futures/free-margin', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetFuturesOrderHistCurrent($params = array()) {
        return $this->request('futures/order/hist/current', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetFuturesOrderOpen($params = array()) {
        return $this->request('futures/order/open', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupGetFuturesOrderStatus($params = array()) {
        return $this->request('futures/order/status', array('v2', 'private', 'accountGroup'), 'GET', $params);
    }
    public function v2PrivateAccountGroupPostFuturesIsolatedPositionMargin($params = array()) {
        return $this->request('futures/isolated-position-margin', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesMarginType($params = array()) {
        return $this->request('futures/margin-type', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesLeverage($params = array()) {
        return $this->request('futures/leverage', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesTransferDeposit($params = array()) {
        return $this->request('futures/transfer/deposit', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesTransferWithdraw($params = array()) {
        return $this->request('futures/transfer/withdraw', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesOrder($params = array()) {
        return $this->request('futures/order', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesOrderBatch($params = array()) {
        return $this->request('futures/order/batch', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostFuturesOrderOpen($params = array()) {
        return $this->request('futures/order/open', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostSubuserSubuserTransfer($params = array()) {
        return $this->request('subuser/subuser-transfer', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupPostSubuserSubuserTransferHist($params = array()) {
        return $this->request('subuser/subuser-transfer-hist', array('v2', 'private', 'accountGroup'), 'POST', $params);
    }
    public function v2PrivateAccountGroupDeleteFuturesOrder($params = array()) {
        return $this->request('futures/order', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
    public function v2PrivateAccountGroupDeleteFuturesOrderBatch($params = array()) {
        return $this->request('futures/order/batch', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
    public function v2PrivateAccountGroupDeleteFuturesOrderAll($params = array()) {
        return $this->request('futures/order/all', array('v2', 'private', 'accountGroup'), 'DELETE', $params);
    }
}