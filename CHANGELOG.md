# Changelog

All notable changes to the "jijunair/laravel-referral" package will be documented in this file.

## [2.0.0] - 2025-12-27

### Changed
- Updated to support Laravel 12.x
- Updated PHP version requirement to PHP ^8.2
- Updated migration file to use anonymous class syntax with return type declarations
- Updated all source files to include proper return type declarations and type hints
- Replaced outdated migration file (`2023_05_28_135232_create_referrals_table.php`) with stub file (`create_referrals_table.php.stub`)
- Updated test file to use Laravel 12 factory syntax
- Added proper type hints for parameters and return values across all classes
- Removed redundant PHPDoc `@param` and `@return` tags where native type hints are present

### Fixed
- Fixed outdated migration file name and class syntax
- Fixed deprecated factory helper usage in tests

## [1.0.0] - 2023-07-14

### Added
- Initial release of the "jijunair/laravel-referral" package.

[1.0.0]: https://github.com/jijunair/laravel-referral/releases/tag/v1.0.0
