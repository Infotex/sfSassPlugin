<?php
/**
 * Simple test to verify phpsass works with PHP 8.x
 */

require_once __DIR__ . '/lib/vendor/phpsass/SassParser.php';

echo "Testing phpsass with PHP " . PHP_VERSION . "\n";

// Test 1: Basic SCSS
$scss1 = '.test { color: red; }';
try {
    $parser = new SassParser(['style' => 'compressed', 'cache' => false, 'syntax' => 'scss']);
    $result = $parser->toCss($scss1, false);
    echo "✓ Test 1 passed: Basic SCSS compilation works\n";
} catch (Exception $e) {
    echo "✗ Test 1 failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 2: SCSS with variables
$scss2 = '$color: blue; body { color: $color; }';
try {
    $parser = new SassParser(['style' => 'compressed', 'cache' => false, 'syntax' => 'scss']);
    $result = $parser->toCss($scss2, false);
    if (strpos($result, 'blue') !== false) {
        echo "✓ Test 2 passed: SCSS variables work\n";
    } else {
        echo "✗ Test 2 failed: Variables not resolved\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "✗ Test 2 failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Test 3: Nested selectors
$scss3 = '.parent { .child { color: green; } }';
try {
    $parser = new SassParser(['style' => 'compressed', 'cache' => false, 'syntax' => 'scss']);
    $result = $parser->toCss($scss3, false);
    if (strpos($result, '.parent .child') !== false) {
        echo "✓ Test 3 passed: Nested selectors work\n";
    } else {
        echo "✗ Test 3 failed: Nesting not working\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "✗ Test 3 failed: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✓ All tests passed! phpsass is working with PHP " . PHP_VERSION . "\n";
exit(0);
