# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2021-10-18
### Changed
- The location of the Horizon assets has been changed. The Horizon assets are published into the plugin directory itself. Please note that you need to re-publish the assets when you're deploying your October CMS website or application using the `php artisan vendor:publish --tag horizon-assets --force` command otherwise the Horizon Dashboard will not be available.
- The `horizon:install` command can now be used to (re-)publish the Horizon Assets required for the Horizon Dashboard. 
- Renamed `PushExampleJobs` to `PushExampleJobsCommand`.

### Removed
- Removed the dependency of the October CMS module (for headless applications).

## [1.0.0] - 2021-06-22

- First release of `vdlp/oc-horizon-plugin`.
