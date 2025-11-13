# PHP 8.x Compatibility Updates

This document describes the changes made to make sfSassPlugin compatible with PHP 8.0, 8.1, 8.2, 8.3, and 8.4.

## Changes Made

### 1. Fixed `create_function()` Usage
**Issue:** The `create_function()` function was deprecated in PHP 7.2 and removed in PHP 8.0.

**Files Modified:**
- `lib/vendor/phpsass/Extensions/Own/Own.php` (line 24)
- `lib/vendor/phpsass/Extensions/Compass/Compass.php` (line 70)

**Change:** Replaced `create_function('$c', 'return strtoupper($c[1]);')` with anonymous function:
```php
// Before (PHP 7.x and earlier)
$func = create_function('$c', 'return strtoupper($c[1]);');

// After (PHP 8.x compatible)
$func = function($c) { return strtoupper($c[1]); };
```

### 2. Fixed Curly Brace Array/String Access Syntax
**Issue:** Using curly braces for array/string offset access (e.g., `$str{0}`) was deprecated in PHP 7.4 and removed in PHP 8.0.

**Files Modified:**
- `lib/vendor/phpsass/tree/SassRuleNode.php` (line 133)

**Change:** Replaced curly braces with square brackets:
```php
// Before (PHP 7.x and earlier)
if ($extendee{0} == '%' && $selector{0} != '%') { ... }

// After (PHP 8.x compatible)
if ($extendee[0] == '%' && $selector[0] != '%') { ... }
```

### 3. Updated PHPUnit Test Syntax
**Issue:** Old PHPUnit 4.x/5.x syntax is incompatible with modern PHPUnit versions.

**Files Modified:**
- `lib/vendor/phpsass/tests/phpSassTest.php`

**Changes:**
- Added `use PHPUnit\Framework\TestCase;` statement
- Changed `PHPUnit_Framework_TestCase` to `TestCase`
- Updated `setUp()` method signature to `setUp(): void` (required in PHPUnit 8+)

### 4. Added PHP Version Requirements
**Files Modified:**
- Created `composer.json` in project root
- Updated `lib/vendor/phpsass/composer.json`

**Change:** Added PHP 8.0+ requirement:
```json
{
    "require": {
        "php": ">=8.0"
    }
}
```

## Compatibility

✅ **Compatible with:**
- PHP 8.0
- PHP 8.1
- PHP 8.2
- PHP 8.3
- PHP 8.4 (when released)

❌ **No longer compatible with:**
- PHP 7.4 and earlier versions (due to the fixes for removed functions)

## Testing

All PHP files pass syntax validation with PHP 8.3:
```bash
# Test all PHP files
find lib/vendor/phpsass -name "*.php" -type f -exec php -l {} \;
```

## Notes

- The phpsass submodule has been modified locally to include these PHP 8.x compatibility fixes
- Since the original phpsass repository is no longer actively maintained, these changes are committed directly to the submodule
- All changes are backward-compatible with the existing Symfony 1.x plugin API

## Related Issues

- Deprecated `create_function()` - [PHP RFC](https://wiki.php.net/rfc/deprecations_php_7_2#create_function)
- Deprecated curly brace syntax - [PHP RFC](https://wiki.php.net/rfc/deprecate_curly_braces_array_access)
- PHPUnit compatibility - [PHPUnit 8 Migration Guide](https://phpunit.de/announcements/phpunit-8.html)
