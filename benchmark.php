<?php
require 'vendor/autoload.php';

function benchmark($name, $runs, $function)
{
    $start = microtime(true);
    while ($runs--) {
        $function();
    }
    $end = microtime(true);

    return sprintf('%s: %s', $name, ($end - $start)) . PHP_EOL;
}

function heavyCalc($varA, $varB)
{
    usleep(100);
    return $varA + $varB;
}

$memoized = Knlv\memoize('heavyCalc');

echo benchmark('heavyCalc(1, 2)', 100, function() {
    heavyCalc(1, 2);
});

echo benchmark('Memoized heavyCalc(1, 2)', 100, function () use (&$memoized) {
    $memoized(1, 2);
});
