import os
import sys

root = os.path.dirname(os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__)))))
sys.path.append(root)

# ----------------------------------------------------------------------------

# PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
# https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

# ----------------------------------------------------------------------------
# -*- coding: utf-8 -*-


from ccxt.test.base import test_leverage_tier  # noqa E402


async def test_fetch_leverage_tiers(exchange, symbol):
    method = 'fetchLeverageTiers'
    tiers = await exchange.fetch_leverage_tiers(symbol)
    # const format = {
    #     'RAY/USDT': [
    #       {},
    #     ],
    # };
    assert isinstance(tiers, dict), exchange.id + ' ' + method + ' ' + symbol + ' must return an object. ' + exchange.json(tiers)
    tier_keys = list(tiers.keys())
    array_length = len(tier_keys)
    assert array_length >= 1, exchange.id + ' ' + method + ' ' + symbol + ' must have at least one entry. ' + exchange.json(tiers)
    for i in range(0, array_length):
        tiers_for_symbol = tiers[tier_keys[i]]
        array_length_symbol = len(tiers_for_symbol)
        assert array_length_symbol >= 1, exchange.id + ' ' + method + ' ' + symbol + ' must have at least one entry. ' + exchange.json(tiers)
        for j in range(0, len(tiers_for_symbol)):
            test_leverage_tier(exchange, method, tiers_for_symbol[j])
