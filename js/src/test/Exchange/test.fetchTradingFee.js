// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code
// EDIT THE CORRESPONDENT .ts FILE INSTEAD

import assert from 'assert';
import testTradingFee from './base/test.tradingFee.js';
async function testFetchTradingFee(exchange, symbol) {
    const method = 'fetchTradingFee';
    const fee = await exchange.fetchTradingFee(symbol);
    assert(typeof fee === 'object', exchange.id + ' ' + method + ' ' + symbol + ' must return an object. ' + exchange.json(fee));
    testTradingFee(exchange, method, symbol, fee);
}
export default testFetchTradingFee;
