<?php
namespace ccxt;
use \ccxt\Precise;

// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

// -----------------------------------------------------------------------------
include_once __DIR__ . '/../base/test_ticker.php';

function test_fetch_ticker($exchange, $symbol) {
    $method = 'fetchTicker';
    $ticker = $exchange->fetch_ticker($symbol);
    test_ticker($exchange, $method, $ticker, $symbol);
}
