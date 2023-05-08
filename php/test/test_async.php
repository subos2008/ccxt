<?php
namespace ccxt;

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('UTC');
ini_set('memory_limit', '512M');

define('rootDir', __DIR__ . '/../../');
include_once rootDir .'/vendor/autoload.php';
use React\Async;
use React\Promise;

assert_options (ASSERT_CALLBACK, function(){
    $args = func_get_args();
    try {
        $file = $args[0];
        $line = $args[1];
        $message = $args[3];
        var_dump("[TEST_FAILURE] ASSERT - $message [ $file : $line ]");
    } catch (\Exception $exc) {
        var_dump("[TEST_FAILURE] -");
        var_dump($args);
    }
    exit;
});

$filetered_args = array_filter(array_map (function ($x) { return stripos($x,'--')===false? $x : null;} , $argv));
$exchangeId = array_key_exists(1, $filetered_args) ? $filetered_args[1] : null; // this should be different than JS
$exchangeSymbol = null; // todo: this should be different than JS

// non-transpiled part, but shared names among langs

class baseMainTestClass {
    public $testFiles = [];
    public $skippedMethods = [];
    public $checkedPublicTests = [];
    public $publicTests = [];
    public $info = false;
    public $verbose = false;
    public $debug = false;
    public $privateTest = false;
    public $privateTestOnly = false;
    public $sandbox = false;
}

define ('is_synchronous', stripos(__FILE__, '_async') === false);

define('rootDirForSkips', __DIR__ . '/../../');
define('envVars', $_ENV);
define('ext', 'php');
define('httpsAgent', null);

function dump(...$s) {
    $args = array_map(function ($arg) {
        if (is_array($arg) || is_object($arg)) {
            return json_encode($arg);
        } else {
            return $arg;
        }
    }, func_get_args());
    echo implode(' ', $args) . "\n";
}

function get_cli_arg_value ($arg) {
    return in_array($arg, $GLOBALS['argv']);
}

function get_test_name($methodName) {
    $snake_cased = strtolower(preg_replace('/(?<!^)(?=[A-Z])/', '_', $methodName)); // snake_case
    $snake_cased = str_replace('o_h_l_c_v', 'ohlcv', $snake_cased);
    return 'test_' . $snake_cased;
}

function io_file_exists($path) {
    return file_exists($path);
}

function io_file_read($path, $decode = true) {
    $content = file_get_contents($path);
    return $decode ? json_decode($content, true) : $content;
}

function call_method($testFiles, $methodName, $exchange, $skippedProperties, $args) {
    return $testFiles[$methodName]($exchange, $skippedProperties, ... $args);
}

function exception_message ($exc) {
    $inner_message = $exc->getMessage();
    return '[' . get_class($exc) . '] ' . substr($inner_message, 0, 500);
}

function add_proxy ($exchange, $http_proxy) {
    // just add a simple redirect through proxy
    $exchange->proxy = $http_proxy;
}

function exit_script() {
    exit(0);
}

function get_exchange_prop ($exchange, $prop, $defaultValue = null) {
    return property_exists ($exchange, $prop) ? $exchange->{$prop} : $defaultValue;
}

function set_exchange_prop ($exchange, $prop, $value) {
    $exchange->{$prop} = $value;
}

function init_exchange ($exchangeId, $args) {
    $exchangeClassString = '\\ccxt\\' . (is_synchronous ? '' : 'async\\') . $exchangeId;
    return new $exchangeClassString($args);
}

function set_test_files ($holderClass, $properties) {
    return Async\async (function() use ($holderClass, $properties){
        $skiped = ['test_throttle'];
        foreach (glob(__DIR__ . '/' . (is_synchronous ? 'sync' : 'async') . '/test_*.php') as $filename) {
            $basename = basename($filename);
            if (!in_array($basename, $skiped)) {
                include_once $filename;
            }
        }
        $allfuncs = get_defined_functions()['user'];
        foreach ($allfuncs as $fName) {
            if (stripos($fName, 'ccxt\\test_')!==false) {
                $nameWithoutNs = str_replace('ccxt\\', '', $fName);
                $holderClass->testFiles[$nameWithoutNs] = $fName;
            }
        }
    })();
}

function close($exchange) {
    return Async\async (function() {
        // stub
        return true;
    })();
}

// *********************************
// ***** AUTO-TRANSPILER-START *****


// PLEASE DO NOT EDIT THIS FILE, IT IS GENERATED AND WILL BE OVERWRITTEN:
// https://github.com/ccxt/ccxt/blob/master/CONTRIBUTING.md#how-to-contribute-code

use Exception; // a common import

use ccxt\AuthenticationError;

class testMainClass extends baseMainTestClass {

    public function parse_cli_args() {
        $this->info = get_cli_arg_value ('--info');
        $this->verbose = get_cli_arg_value ('--verbose');
        $this->debug = get_cli_arg_value ('--debug');
        $this->privateTest = get_cli_arg_value ('--private');
        $this->privateTestOnly = get_cli_arg_value ('--privateOnly');
        $this->sandbox = get_cli_arg_value ('--sandbox');
    }

    public function init($exchangeId, $symbol) {
        return Async\async(function () use ($exchangeId, $symbol) {
            $this->parse_cli_args();
            $symbolStr = $symbol !== null ? $symbol : 'all';
            var_dump ('\nTESTING ', ext, array( 'exchange' => $exchangeId, 'symbol' => $symbolStr ), '\n');
            $exchangeArgs = array(
                'verbose' => $this->verbose,
                'debug' => $this->debug,
                'httpsAgent' => httpsAgent,
                'enableRateLimit' => true,
                'timeout' => 20000,
            );
            $exchange = init_exchange ($exchangeId, $exchangeArgs);
            Async\await($this->import_files($exchange));
            $this->expand_settings($exchange, $symbol);
            Async\await($this->start_test($exchange, $symbol));
            Async\await(close ($exchange));
        }) ();
    }

    public function import_files($exchange) {
        return Async\async(function () use ($exchange) {
            // $exchange tests
            $this->testFiles = array();
            $properties = is_array($exchange->has) ? array_keys($exchange->has) : array();
            $properties[] = 'loadMarkets';
            Async\await(set_test_files ($this, $properties));
        }) ();
    }

    public function expand_settings($exchange, $symbol) {
        $exchangeId = $exchange->id;
        $keysGlobal = rootDir . 'keys.json';
        $keysLocal = rootDir . 'keys.local.json';
        $keysGlobalExists = io_file_exists ($keysGlobal);
        $keysLocalExists = io_file_exists ($keysLocal);
        $globalSettings = $keysGlobalExists ? io_file_read ($keysGlobal) : array();
        $localSettings = $keysLocalExists ? io_file_read ($keysLocal) : array();
        $allSettings = $exchange->deep_extend($globalSettings, $localSettings);
        $exchangeSettings = $exchange->safe_value($allSettings, $exchangeId, array());
        if ($exchangeSettings) {
            $settingKeys = is_array($exchangeSettings) ? array_keys($exchangeSettings) : array();
            for ($i = 0; $i < count($settingKeys); $i++) {
                $key = $settingKeys[$i];
                if ($exchangeSettings[$key]) {
                    $finalValue = null;
                    if (gettype($exchangeSettings[$key]) === 'array') {
                        $existing = get_exchange_prop ($exchange, $key, array());
                        $finalValue = $exchange->deep_extend($existing, $exchangeSettings[$key]);
                    } else {
                        $finalValue = $exchangeSettings[$key];
                    }
                    set_exchange_prop ($exchange, $key, $finalValue);
                }
            }
        }
        // credentials
        $reqCreds = get_exchange_prop ($exchange, 're' . 'quiredCredentials'); // dont glue the r-e-q-u-$i-r-e phrase, because leads to messed up transpilation
        $objkeys = is_array($reqCreds) ? array_keys($reqCreds) : array();
        for ($i = 0; $i < count($objkeys); $i++) {
            $credential = $objkeys[$i];
            $isRequired = $reqCreds[$credential];
            if ($isRequired && get_exchange_prop ($exchange, $credential) === null) {
                $fullKey = $exchangeId . '_' . $credential;
                $credentialEnvName = strtoupper($fullKey); // example => KRAKEN_APIKEY
                $credentialValue = (is_array(envVars) && array_key_exists($credentialEnvName, envVars)) ? envVars[$credentialEnvName] : null;
                if ($credentialValue) {
                    set_exchange_prop ($exchange, $credential, $credentialValue);
                }
            }
        }
        // skipped tests
        $skippedFile = rootDirForSkips . 'skip-tests.json';
        $skippedSettings = io_file_read ($skippedFile);
        $skippedSettingsForExchange = $exchange->safe_value($skippedSettings, $exchangeId, array());
        // others
        $skipReason = $exchange->safe_value($skippedSettingsForExchange, 'skip');
        if ($skipReason !== null) {
            dump ('[SKIPPED] exchange', $exchangeId, $skipReason);
            exit_script ();
        }
        if ($exchange->alias) {
            dump ('[SKIPPED] Alias $exchange-> ', 'exchange', $exchangeId, 'symbol', $symbol);
            exit_script ();
        }
        $proxy = $exchange->safe_string($skippedSettingsForExchange, 'httpProxy');
        if ($proxy !== null) {
            add_proxy ($exchange, $proxy);
        }
        $this->skippedMethods = $exchange->safe_value($skippedSettingsForExchange, 'skipMethods', array());
        $this->checkedPublicTests = array();
    }

    public function add_padding($message, $size) {
        // has to be transpilable
        $res = '';
        $missingSpace = $size - strlen($message) - 0; // - 0 is added just to trick transpile to treat the .length string for php
        if ($missingSpace > 0) {
            for ($i = 0; $i < $missingSpace; $i++) {
                $res .= ' ';
            }
        }
        return $message . $res;
    }

    public function test_method($methodName, $exchange, $args, $isPublic) {
        return Async\async(function () use ($methodName, $exchange, $args, $isPublic) {
            $methodNameInTest = get_test_name ($methodName);
            // if this is a private test, and the implementation was already tested in public, then no need to re-test it in private test (exception is fetchCurrencies, because our approach in base $exchange)
            if (!$isPublic && (is_array($this->checkedPublicTests) && array_key_exists($methodNameInTest, $this->checkedPublicTests)) && ($methodName !== 'fetchCurrencies')) {
                return;
            }
            $skipMessage = null;
            $isFetchOhlcvEmulated = ($methodName === 'fetchOHLCV' && $exchange->has['fetchOHLCV'] === 'emulated'); // todo => remove emulation from base
            if (($methodName !== 'loadMarkets') && (!(is_array($exchange->has) && array_key_exists($methodName, $exchange->has)) || !$exchange->has[$methodName]) || $isFetchOhlcvEmulated) {
                $skipMessage = '[INFO:UNSUPPORTED_TEST]'; // keep it aligned with the longest message
            } elseif ((is_array($this->skippedMethods) && array_key_exists($methodName, $this->skippedMethods)) && (gettype($this->skippedMethods[$methodName]) === 'string')) {
                $skipMessage = '[INFO:SKIPPED_TEST]';
            } elseif (!(is_array($this->testFiles) && array_key_exists($methodNameInTest, $this->testFiles))) {
                $skipMessage = '[INFO:UNIMPLEMENTED_TEST]';
            }
            if ($skipMessage) {
                if ($this->info) {
                    dump ($this->add_padding($skipMessage, 25), $exchange->id, $methodNameInTest);
                }
                return;
            }
            $argsStringified = '(' . implode(',', $args) . ')';
            if ($this->info) {
                dump ($this->add_padding('[INFO:TESTING]', 25), $exchange->id, $methodNameInTest, $argsStringified);
            }
            $result = null;
            try {
                $skippedProperties = $exchange->safe_value($this->skippedMethods, $methodName, array());
                $result = Async\await(call_method ($this->testFiles, $methodNameInTest, $exchange, $skippedProperties, $args));
                if ($isPublic) {
                    $this->checkedPublicTests[$methodNameInTest] = true;
                }
            } catch (Exception $e) {
                $isAuthError = ($e instanceof AuthenticationError);
                if (!($isPublic && $isAuthError)) {
                    dump ('[TEST_FAILURE]', exception_message ($e), ' | Exception from => ', $exchange->id, $methodNameInTest, $argsStringified);
                    throw $e;
                }
            }
            return $result;
        }) ();
    }

    public function test_safe($methodName, $exchange, $args, $isPublic) {
        return Async\async(function () use ($methodName, $exchange, $args, $isPublic) {
            try {
                Async\await($this->test_method($methodName, $exchange, $args, $isPublic));
                return true;
            } catch (Exception $e) {
                return false;
            }
        }) ();
    }

    public function run_public_tests($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            $tests = array(
                'loadMarkets' => array(),
                'fetchCurrencies' => array(),
                'fetchTicker' => array( $symbol ),
                'fetchTickers' => array( $symbol ),
                'fetchOHLCV' => array( $symbol ),
                'fetchTrades' => array( $symbol ),
                'fetchOrderBook' => array( $symbol ),
                'fetchL2OrderBook' => array( $symbol ),
                'fetchOrderBooks' => array(),
                'fetchBidsAsks' => array(),
                'fetchStatus' => array(),
                'fetchTime' => array(),
            );
            $market = $exchange->market ($symbol);
            $isSpot = $market['spot'];
            if ($isSpot) {
                $tests['fetchCurrencies'] = array();
            } else {
                $tests['fetchFundingRates'] = array( $symbol );
                $tests['fetchFundingRate'] = array( $symbol );
                $tests['fetchFundingRateHistory'] = array( $symbol );
                $tests['fetchIndexOHLCV'] = array( $symbol );
                $tests['fetchMarkOHLCV'] = array( $symbol );
                $tests['fetchPremiumIndexOHLCV'] = array( $symbol );
            }
            $this->publicTests = $tests;
            $testNames = is_array($tests) ? array_keys($tests) : array();
            $promises = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $testArgs = $tests[$testName];
                $promises[] = $this->test_safe($testName, $exchange, $testArgs, true);
            }
            // todo - not yet ready in other langs too
            // $promises[] = testThrottle ();
            Async\await(Promise\all($promises));
            if ($this->info) {
                dump ($this->add_padding('[INFO:PUBLIC_TESTS_DONE]', 25), $exchange->id);
            }
        }) ();
    }

    public function load_exchange($exchange) {
        return Async\async(function () use ($exchange) {
            Async\await($exchange->load_markets());
            assert (gettype($exchange->markets) === 'array', '.markets is not an object');
            assert (gettype($exchange->symbols) === 'array' && array_keys($exchange->symbols) === array_keys(array_keys($exchange->symbols)), '.symbols is not an array');
            $symbolsLength = count($exchange->symbols);
            $marketKeys = is_array($exchange->markets) ? array_keys($exchange->markets) : array();
            $marketKeysLength = count($marketKeys);
            assert ($symbolsLength > 0, '.symbols count <= 0 (less than or equal to zero)');
            assert ($marketKeysLength > 0, '.markets objects keys length <= 0 (less than or equal to zero)');
            assert ($symbolsLength === $marketKeysLength, 'number of .symbols is not equal to the number of .markets');
            $symbols = array(
                'BTC/CNY',
                'BTC/USD',
                'BTC/USDT',
                'BTC/EUR',
                'BTC/ETH',
                'ETH/BTC',
                'BTC/JPY',
                'ETH/EUR',
                'ETH/JPY',
                'ETH/CNY',
                'ETH/USD',
                'LTC/CNY',
                'DASH/BTC',
                'DOGE/BTC',
                'BTC/AUD',
                'BTC/PLN',
                'USD/SLL',
                'BTC/RUB',
                'BTC/UAH',
                'LTC/BTC',
                'EUR/USD',
            );
            $resultSymbols = array();
            $exchangeSpecificSymbols = $exchange->symbols;
            for ($i = 0; $i < count($exchangeSpecificSymbols); $i++) {
                $symbol = $exchangeSpecificSymbols[$i];
                if ($exchange->in_array($symbol, $symbols)) {
                    $resultSymbols[] = $symbol;
                }
            }
            $resultMsg = '';
            $resultLength = count($resultSymbols);
            $exchangeSymbolsLength = count($exchange->symbols);
            if ($resultLength > 0) {
                if ($exchangeSymbolsLength > $resultLength) {
                    $resultMsg = implode(', ', $resultSymbols) . ' . more...';
                } else {
                    $resultMsg = implode(', ', $resultSymbols);
                }
            }
            dump ('Exchange loaded', $exchangeSymbolsLength, 'symbols', $resultMsg);
        }) ();
    }

    public function get_test_symbol($exchange, $isSpot, $symbols) {
        $symbol = null;
        for ($i = 0; $i < count($symbols); $i++) {
            $s = $symbols[$i];
            $market = $exchange->safe_value($exchange->markets, $s);
            if ($market !== null) {
                $active = $exchange->safe_value($market, 'active');
                if ($active || ($active === null)) {
                    $symbol = $s;
                    break;
                }
            }
        }
        return $symbol;
    }

    public function get_exchange_code($exchange, $codes = null) {
        if ($codes === null) {
            $codes = array( 'BTC', 'ETH', 'XRP', 'LTC', 'BCH', 'EOS', 'BNB', 'BSV', 'USDT' );
        }
        $code = $codes[0];
        for ($i = 0; $i < count($codes); $i++) {
            if (is_array($exchange->currencies) && array_key_exists($codes[$i], $exchange->currencies)) {
                return $codes[$i];
            }
        }
        return $code;
    }

    public function get_markets_from_exchange($exchange, $spot = true) {
        $res = array();
        $markets = $exchange->markets;
        $keys = is_array($markets) ? array_keys($markets) : array();
        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            $market = $markets[$key];
            if ($spot && $market['spot']) {
                $res[$market['symbol']] = $market;
            } elseif (!$spot && !$market['spot']) {
                $res[$market['symbol']] = $market;
            }
        }
        return $res;
    }

    public function get_valid_symbol($exchange, $spot = true) {
        $currentTypeMarkets = $this->get_markets_from_exchange($exchange, $spot);
        $codes = array(
            'BTC',
            'ETH',
            'XRP',
            'LTC',
            'BCH',
            'EOS',
            'BNB',
            'BSV',
            'USDT',
            'ATOM',
            'BAT',
            'BTG',
            'DASH',
            'DOGE',
            'ETC',
            'IOTA',
            'LSK',
            'MKR',
            'NEO',
            'PAX',
            'QTUM',
            'TRX',
            'TUSD',
            'USD',
            'USDC',
            'WAVES',
            'XEM',
            'XMR',
            'ZEC',
            'ZRX',
        );
        $spotSymbols = array(
            'BTC/USD',
            'BTC/USDT',
            'BTC/CNY',
            'BTC/EUR',
            'BTC/ETH',
            'ETH/BTC',
            'ETH/USD',
            'ETH/USDT',
            'BTC/JPY',
            'LTC/BTC',
            'ZRX/WETH',
            'EUR/USD',
        );
        $swapSymbols = array(
            'BTC/USDT:USDT',
            'BTC/USD:USD',
            'ETH/USDT:USDT',
            'ETH/USD:USD',
            'LTC/USDT:USDT',
            'DOGE/USDT:USDT',
            'ADA/USDT:USDT',
            'BTC/USD:BTC',
            'ETH/USD:ETH',
        );
        $targetSymbols = $spot ? $spotSymbols : $swapSymbols;
        $symbol = $this->get_test_symbol($exchange, $spot, $targetSymbols);
        // if symbols wasn't found from above hardcoded list, then try to locate any $symbol which has our target hardcoded 'base' code
        if ($symbol === null) {
            for ($i = 0; $i < count($codes); $i++) {
                $currentCode = $codes[$i];
                $marketsArrayForCurrentCode = $exchange->filter_by($currentTypeMarkets, 'base', $currentCode);
                $indexedMkts = $exchange->index_by($marketsArrayForCurrentCode, 'symbol');
                $symbolsArrayForCurrentCode = is_array($indexedMkts) ? array_keys($indexedMkts) : array();
                $symbolsLength = count($symbolsArrayForCurrentCode);
                if ($symbolsLength) {
                    $symbol = $this->get_test_symbol($exchange, $spot, $symbolsArrayForCurrentCode);
                    break;
                }
            }
        }
        // if there wasn't found any $symbol with our hardcoded 'base' code, then just try to find symbols that are 'active'
        if ($symbol === null) {
            $activeMarkets = $exchange->filter_by($currentTypeMarkets, 'active', true);
            $activeSymbols = array();
            for ($i = 0; $i < count($activeMarkets); $i++) {
                $activeSymbols[] = $activeMarkets[$i]['symbol'];
            }
            $symbol = $this->get_test_symbol($exchange, $spot, $activeSymbols);
        }
        if ($symbol === null) {
            $values = is_array($currentTypeMarkets) ? array_values($currentTypeMarkets) : array();
            $valuesLength = count($values);
            if ($valuesLength > 0) {
                $first = $values[0];
                if ($first !== null) {
                    $symbol = $first['symbol'];
                }
            }
        }
        return $symbol;
    }

    public function test_exchange($exchange, $providedSymbol = null) {
        return Async\async(function () use ($exchange, $providedSymbol) {
            $spotSymbol = null;
            $swapSymbol = null;
            if ($providedSymbol !== null) {
                $market = $exchange->market ($providedSymbol);
                if ($market['spot']) {
                    $spotSymbol = $providedSymbol;
                } else {
                    $swapSymbol = $providedSymbol;
                }
            } else {
                if ($exchange->has['spot']) {
                    $spotSymbol = $this->get_valid_symbol($exchange, true);
                }
                if ($exchange->has['swap']) {
                    $swapSymbol = $this->get_valid_symbol($exchange, false);
                }
            }
            if ($spotSymbol !== null) {
                dump ('Selected SPOT SYMBOL:', $spotSymbol);
            }
            if ($swapSymbol !== null) {
                dump ('Selected SWAP SYMBOL:', $swapSymbol);
            }
            if (!$this->privateTestOnly) {
                if ($exchange->has['spot'] && $spotSymbol !== null) {
                    if ($this->info) {
                        dump ('[INFO:SPOT TESTS]');
                    }
                    $exchange->options['type'] = 'spot';
                    Async\await($this->run_public_tests($exchange, $spotSymbol));
                }
                if ($exchange->has['swap'] && $swapSymbol !== null) {
                    if ($this->info) {
                        dump ('[INFO:SWAP TESTS]');
                    }
                    $exchange->options['type'] = 'swap';
                    Async\await($this->run_public_tests($exchange, $swapSymbol));
                }
            }
            if ($this->privateTest || $this->privateTestOnly) {
                if ($exchange->has['spot'] && $spotSymbol !== null) {
                    $exchange->options['defaultType'] = 'spot';
                    Async\await($this->run_private_tests($exchange, $spotSymbol));
                }
                if ($exchange->has['swap'] && $swapSymbol !== null) {
                    $exchange->options['defaultType'] = 'swap';
                    Async\await($this->run_private_tests($exchange, $swapSymbol));
                }
            }
        }) ();
    }

    public function run_private_tests($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            if (!$exchange->check_required_credentials(false)) {
                dump ('[Skipping private $tests]', 'Keys not found');
                return;
            }
            $code = $this->get_exchange_code($exchange);
            // if ($exchange->extendedTest) {
            //     Async\await(test ('InvalidNonce', $exchange, $symbol));
            //     Async\await(test ('OrderNotFound', $exchange, $symbol));
            //     Async\await(test ('InvalidOrder', $exchange, $symbol));
            //     Async\await(test ('InsufficientFunds', $exchange, $symbol, balance)); // danger zone - won't execute with non-empty balance
            // }
            $tests = array(
                'signIn' => array( $exchange ),
                'fetchBalance' => array( $exchange ),
                'fetchAccounts' => array( $exchange ),
                'fetchTransactionFees' => array( $exchange ),
                'fetchTradingFees' => array( $exchange ),
                'fetchStatus' => array( $exchange ),
                'fetchOrders' => array( $exchange, $symbol ),
                'fetchOpenOrders' => array( $exchange, $symbol ),
                'fetchClosedOrders' => array( $exchange, $symbol ),
                'fetchMyTrades' => array( $exchange, $symbol ),
                'fetchLeverageTiers' => array( $exchange, $symbol ),
                'fetchLedger' => array( $exchange, $code ),
                'fetchTransactions' => array( $exchange, $code ),
                'fetchDeposits' => array( $exchange, $code ),
                'fetchWithdrawals' => array( $exchange, $code ),
                'fetchBorrowRates' => array( $exchange, $code ),
                'fetchBorrowRate' => array( $exchange, $code ),
                'fetchBorrowInterest' => array( $exchange, $code, $symbol ),
                'addMargin' => array( $exchange, $symbol ),
                'reduceMargin' => array( $exchange, $symbol ),
                'setMargin' => array( $exchange, $symbol ),
                'setMarginMode' => array( $exchange, $symbol ),
                'setLeverage' => array( $exchange, $symbol ),
                'cancelAllOrders' => array( $exchange, $symbol ),
                'cancelOrder' => array( $exchange, $symbol ),
                'cancelOrders' => array( $exchange, $symbol ),
                'fetchCanceledOrders' => array( $exchange, $symbol ),
                'fetchClosedOrder' => array( $exchange, $symbol ),
                'fetchOpenOrder' => array( $exchange, $symbol ),
                'fetchOrder' => array( $exchange, $symbol ),
                'fetchOrderTrades' => array( $exchange, $symbol ),
                'fetchPosition' => array( $exchange, $symbol ),
                'fetchDeposit' => array( $exchange, $code ),
                'createDepositAddress' => array( $exchange, $code ),
                'fetchDepositAddress' => array( $exchange, $code ),
                'fetchDepositAddresses' => array( $exchange, $code ),
                'fetchDepositAddressesByNetwork' => array( $exchange, $code ),
                'editOrder' => array( $exchange, $symbol ),
                'fetchBorrowRateHistory' => array( $exchange, $symbol ),
                'fetchBorrowRatesPerSymbol' => array( $exchange, $symbol ),
                'fetchLedgerEntry' => array( $exchange, $code ),
                'fetchWithdrawal' => array( $exchange, $code ),
                'transfer' => array( $exchange, $code ),
                'withdraw' => array( $exchange, $code ),
            );
            $market = $exchange->market ($symbol);
            $isSpot = $market['spot'];
            if ($isSpot) {
                $tests['fetchCurrencies'] = array( $exchange, $symbol );
            } else {
                // derivatives only
                $tests['fetchPositions'] = array( $exchange, array( $symbol ) );
                $tests['fetchPosition'] = array( $exchange, $symbol );
                $tests['fetchPositionRisk'] = array( $exchange, $symbol );
                $tests['setPositionMode'] = array( $exchange, $symbol );
                $tests['setMarginMode'] = array( $exchange, $symbol );
                $tests['fetchOpenInterestHistory'] = array( $exchange, $symbol );
                $tests['fetchFundingRateHistory'] = array( $exchange, $symbol );
                $tests['fetchFundingHistory'] = array( $exchange, $symbol );
            }
            $combinedPublicPrivateTests = $exchange->deep_extend($this->publicTests, $tests);
            $testNames = is_array($combinedPublicPrivateTests) ? array_keys($combinedPublicPrivateTests) : array();
            $promises = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $testArgs = $combinedPublicPrivateTests[$testName];
                $promises[] = $this->test_safe($testName, $exchange, $testArgs, false);
            }
            $results = Async\await(Promise\all($promises));
            $errors = array();
            for ($i = 0; $i < count($testNames); $i++) {
                $testName = $testNames[$i];
                $success = $results[$i];
                if (!$success) {
                    $errors[] = $testName;
                }
            }
            if (strlen($errors) > 0) {
                throw new \Exception('Failed private $tests [' . $market['type'] . '] => ' . implode(', ', $errors));
            } else {
                if ($this->info) {
                    dump ($this->add_padding('[INFO:PRIVATE_TESTS_DONE]', 25), $exchange->id);
                }
            }
        }) ();
    }

    public function start_test($exchange, $symbol) {
        return Async\async(function () use ($exchange, $symbol) {
            // we don't need to test aliases
            if ($exchange->alias) {
                return;
            }
            if ($this->sandbox || get_exchange_prop ($exchange, 'sandbox')) {
                $exchange->set_sandbox_mode(true);
            }
            Async\await($this->load_exchange($exchange));
            Async\await($this->test_exchange($exchange, $symbol));
        }) ();
    }
}

// ***** AUTO-TRANSPILER-END *****
// *******************************
$promise = (new testMainClass())->init($exchangeId, $exchangeSymbol);
Async\await($promise);