# memoize

master: [![Build Status](https://travis-ci.org/kanellov/memoize.svg?branch=master)](https://travis-ci.org/kanellov/memoize)
develop: [![Build Status](https://travis-ci.org/kanellov/memoize.svg?branch=develop)](https://travis-ci.org/kanellov/memoize)

A simple memoization function

## Installation

Install composer in your project:

    curl -s https://getcomposer.org/installer | php

Create a composer.json file in your project root:

    {
        "require": {
            "kanellov/memoize": "dev-master"
        }
    }

Install via composer:

    php composer.phar install

Add this line to your application’s index.php file:

    <?php
    require 'vendor/autoload.php';

## System Requirements

You need PHP >= 5.3.0.

## Example

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

    /*
    heavyCalc(1, 2): 0.016629219055176
    Memoized heavyCalc(1, 2): 0.001600980758667
    */

