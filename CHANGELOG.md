# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.1.1] - 2023-02-06

### Changed
- Updated Horizon Dashboard Layout (new UI)

## [3.1.0] - 2022-09-23

### Added
- Add migration for Job Batch table.

## [3.0.0] - 2022-04-16

- Upgrade to Horizon 5.0 (requires October CMS 3.0)
- Checkout the README.md file for installation and configuration instructions.

### Added
- Add GitHub WorkFlow configuration.

### Changed
- Changed minimum PHP requirement to PHP 8.0.2
- Changed minimum October CMS version requirement to 3.0
- Use `horizon:install` instead of `horizon:assets` to publish the required assets for the Horizon Dashboard.
- Compare changes in the `config/horizon.php` file with `vendor/laravel/horizon/config/horizon.php`.

## [2.0.2] - 2022-03-08

### Changed
- Version constraint of "composer/installers" to "^1.0 || ^2.0"

### Added
- .gitattributes file
- Version constraint for "october/system"

## [2.0.1] - 2022-02-09

### Changed
- Plugin documentation.
- Remove code comments.

## [2.0.0] - 2021-11-05

### Added
- PHP 7.4 and PHP 8.0 support.

### Changed
- The location of the Horizon assets has been changed. The Horizon assets are published into the plugin directory itself (`plugins/vdlp/horizon/assets`). Please note that you need to re-publish the assets when you are deploying your October CMS website or application using the `php artisan horizon:assets` command otherwise the Horizon Dashboard will not be available.
- The `horizon:assets` command can now be used to (re-)publish the Horizon Assets required for the Horizon Dashboard. 
- Renamed `PushExampleJobs` to `PushExampleJobsCommand`.

### Removed
- Removed the dependency of the October CMS module (for headless applications).
- Support for PHP 7.1

## [1.0.0] - 2021-06-22

- First release of `vdlp/oc-horizon-plugin`.
