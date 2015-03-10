<?php
require __DIR__ . '/../vendor/autoload.php';

use FUnit as fu;

fu::test("Test throws Exception on not callable argumet", function () {
    try {
        $memoized = Knlv\memoize('test string');
    } catch (Exception $e) {
        fu::ok($e instanceof InvalidArgumentException, 'Throws InvalidArgumentException on invalid argument');
    }
});

fu::test("Test memoize works", function () {

    $counter = 0;
    $function = function ($arg) use (&$counter) {
        return $arg . ($counter += 1);
    };
    fu::equal('test1', $function('test'), 'Call with no memoization increments external counter');
    fu::equal('test2', $function('test'), 'Call with no memoization increments external counter');
    $memoized = Knlv\memoize($function);
    fu::equal('test3', $memoized('test'), '1st call memoized function  increments external counter');
    fu::equal('test3', $memoized('test'), '2nd Call memoized function returns cached value');
    fu::equal(3, $counter, 'Assert counter not changed after 2nd memoized function call');
});

fu::test("Test memoize use separate cache foreach function", function () {
    $function1 = function ($arg) {
        return $arg . $arg;
    };
    $function2 = function ($arg) {
        return $arg;
    };

    fu::equal('testtest', $function1('test'), 'Assert not memoized function 1 works');
    fu::equal('test', $function2('test'), 'Assert not memoized function 2 works');

    $memoized1 = Knlv\memoize($function1);
    $memoized2 = Knlv\memoize($function2);

    fu::equal('testtest', $function1('test'), 'Assert memoized function 1 works 1st call');
    fu::equal('testtest', $function1('test'), 'Assert memoized function 1 works 2nd call');
    fu::equal('test', $function2('test'), 'Assert memoized function 2 works 1st call');
    fu::equal('test', $function2('test'), 'Assert memoized function 2 works 2nd call');
});
