<?php
namespace ccxt;
use \ccxt\Precise;
use React\Async;
use React\Promise;

// ----------------------------------------------------------------------------

// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

// -----------------------------------------------------------------------------
include_once __DIR__ . '/../base/test_borrow_interest.php';

function test_fetch_borrow_interest($exchange, $code, $symbol) {
    return Async\async(function () use ($exchange, $code, $symbol) {
        $method = 'fetchBorrowInterest';
        $borrow_interest = Async\await($exchange->fetch_borrow_interest($code, $symbol));
        assert(gettype($borrow_interest) === 'array' && array_keys($borrow_interest) === array_keys(array_keys($borrow_interest)), $exchange->id . ' ' . $method . ' ' . $code . ' must return an array. ' . $exchange->json($borrow_interest));
        for ($i = 0; $i < count($borrow_interest); $i++) {
            test_borrow_interest($exchange, $method, $borrow_interest[$i], $code, $symbol);
        }
    }) ();
}
