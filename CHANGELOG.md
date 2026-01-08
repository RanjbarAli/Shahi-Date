# Changelog

All notable changes to `Shahi Date` will be documented in this file.

## [Unreleased]

## [1.0.0] - 2025-01-08

### Added
- Initial release
- Convert Gregorian dates to Imperial Persian (Shahanshahi) calendar
- Convert Imperial Persian to Gregorian dates
- Full Laravel integration with Service Provider and Facade
- Helper function `shahi()` for easy access
- Carbon macro `toShahi()` for seamless Carbon integration
- Comprehensive date formatting methods
- Persian month and day names
- Date arithmetic (add/subtract days, months, years, hours, minutes, seconds)
- Date boundaries (start/end of day, week, month, year, quarter)
- Date comparison methods (gt, gte, lt, lte, eq, ne, between)
- Date difference calculations (days, hours, minutes, months, years)
- Human-readable difference formatting in Persian
- Leap year support and validation
- Laravel validation rules:
  - `shahi_date` - Validate date format
  - `shahi_date_after` - Date must be after specified date
  - `shahi_date_after_equal` - Date must be after or equal to specified date
  - `shahi_date_before` - Date must be before specified date
  - `shahi_date_before_equal` - Date must be before or equal to specified date
  - `shahi_date_equals` - Date must equal specified date
  - `shahi_date_between` - Date must be between two dates
- Support for keywords: `today`, `yesterday`, `tomorrow`
- Field comparison in validation
- Complete test suite with 100+ tests
- Support for Laravel 9.x, 10.x, 11.x, 12.x
- Support for PHP 8.0, 8.1, 8.2, 8.3
- Comprehensive documentation in English and Persian
- GitHub Actions CI/CD integration

### Features
- Object-oriented API with fluent interface
- Immutable operations with `copy()` method
- JSON serialization support
- Array conversion with `toArray()`
- DateTime and Carbon interoperability
- Timezone support
- Multiple date format support (slash and dash)
- Persian language support for all outputs

[Unreleased]: https://github.com/RanjbarAli/Shahi-Date/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/RanjbarAli/Shahi-Date/releases/tag/v1.0.0
