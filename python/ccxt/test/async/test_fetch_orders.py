import os
import sys

root = os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__)))))
sys.path.append(root)

# ----------------------------------------------------------------------------

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

# ----------------------------------------------------------------------------
# -*- coding: utf-8 -*-


from ccxt.test.base import test_shared_methods  # noqa E402
from ccxt.test.base import test_order  # noqa E402


async def test_fetch_orders(exchange, symbol):
    method = 'fetchOrders'
    orders = await exchange.fetch_orders(symbol)
    assert isinstance(orders, list), exchange.id + ' ' + method + ' must return an array, returned ' + exchange.json(orders)
    now = exchange.milliseconds()
    for i in range(0, len(orders)):
        test_order(exchange, method, orders[i], symbol, now)
    test_shared_methods.assert_timestamp_order(exchange, method, symbol, orders)
