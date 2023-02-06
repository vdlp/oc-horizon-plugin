# Vdlp.Horizon

Provides a seamless integration of [Laravel Horizon 5.0](https://laravel.com/docs/9.x/horizon) inside October CMS.

![Laravel Horizon Logo](https://plugins.vdlp.nl/octobercms/oc-horizon-plugin/logo.png)

Queues, With X-Ray Vision. Supercharge your queues with a beautiful dashboard and code-driven configuration.

![Laravel Horizon Dashboard](https://plugins.vdlp.nl/octobercms/oc-horizon-plugin/dashboard.png)

### A match made in heaven

Horizon is developed by the core developers of the Laravel framework and provides a robust queue monitoring solution for Laravel's Redis queue. Horizon allows you to easily monitor key metrics of your queue system such as job throughput, runtime, and job failures.

### Open Source

Horizon is 100% open source, so you're free to dig through the source to see exactly how it works. See something that needs to be improved? Just send us a pull request on GitHub.

## Requirements

* October CMS 3.0
* PHP 8.0.2 or higher
* PHP extensions: `ext-pcntl`, `ext-posix` and `ext-redis`.
* Supervisor, see [Laravel 9.x supervisor configuration](https://laravel.com/docs/9.x/queues#supervisor-configuration).

## Installation

```
composer require vdlp/oc-horizon-plugin
```

### Turn off auto discovery for `laravel/horizon` (important)

Because this plugin has it's own `HorizonServiceProvider` which extends from the `Laravel\Horizon\HorizonServiceProvider`
we need to prevent the `Laravel\Horizon\HorizonServiceProvider` from being loaded due to Laravels' auto package discovery.

You should add the `dont-discover` option to your projects `composer.json` file (which is located in the root path of your project).

```
"extra": {
    "laravel": {
        "dont-discover": [
            "laravel/horizon"
        ]
    }
}
```

> IMPORTANT: After adding these lines, make sure you execute `composer update` to apply the changes. You also need to remove the file `storage/framework/packages.php` file. No worries. This file will be re-generated once you access your project.

> IMPORTANT: Make sure the `composer.json` is deployed to your hosting site. This will be parsed by te framework to determine which service providers should be ignored.

## Assets & Configuration

```
php artisan horizon:install
```

## Update Horizon Assets

To update the Horizon Assets you can use the following command:

```
php artisan horizon:publish
```

> IMPORTANT: Add the above command to your deployment logic or composer update scripts. This way the assets will always be up to date on your staging or production environment.

* Configure Laravel Horizon settings file at `config/horizon.php`, please make sure `use` contains `horizon` (see the configuration snippet below).

```
    /*
    |--------------------------------------------------------------------------
    | Horizon Redis Connection
    |--------------------------------------------------------------------------
    |
    | This is the name of the Redis connection where Horizon will store the
    | meta information required for it to function. It includes the list
    | of supervisors, failed jobs, job metrics, and other information.
    |
    */

    'use' => 'horizon',
```

* Add connection to `config/queue.php`:

```
    'redis' => [

        'driver' => 'redis',
        'connection' => 'horizon', // References: databases.redis.horizon
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => env('QUEUE_RETRY_AFTER', 90),
        'block_for' => null,

    ],
```

* Add Redis database configuration for Horizon specifically to `config/databases.php`:

```
    'redis' => [

        'cluster' => false,
        'client' => 'phpredis',

        'default' => [
            // ..
        ],

        'horizon' => [
            'host' => env('HORIZON_REDIS_HOST', '127.0.0.1'),
            'password' => env('HORIZON_REDIS_PASSWORD'),
            'port' => env('HORIZON_REDIS_PORT', 6379),
            'database' => env('HORIZON_REDIS_DATABASE', '1'),
        ]

    ],
```

* Modify the queue connection `QUEUE_CONNECTION` (which can be found in `config/queue.php`) to `redis` as such:

```
    /*
    |--------------------------------------------------------------------------
    | Default Queue Driver
    |--------------------------------------------------------------------------
    |
    | The Laravel queue API supports a variety of back-ends via an unified
    | API, giving you convenient access to each back-end using the same
    | syntax for each one. Here you may set the default queue driver.
    |
    | Supported: "null", "sync", "database", "beanstalkd",
    |            "sqs", "iron", "redis"
    |
    */

    'default' => env('QUEUE_CONNECTION', 'redis'),
```

* `.env` should at least have the following `QUEUE_` and `HORIZON_` variables:

```
#
# Queue
#
QUEUE_CONNECTION = "redis"
QUEUE_RETRY_AFTER = 90

#
# Horizon
#
HORIZON_PREFIX = "myproject-local:"

HORIZON_REDIS_HOST = "127.0.0.1"
HORIZON_REDIS_PASSWORD = null
HORIZON_REDIS_PORT = 6379
HORIZON_REDIS_DATABASE = "1"

```

It's recommended to add your Queue Worker Configuration `config.horizon.environments` to the `.env` file as well.

## Server configuration

* Add the following to the `supervisord` configuration on the server. The complete `supervisord` configuration can be found [on the supervisor website](http://supervisord.org/index.html).
* See [Configuring Supervisor](https://laravel.com/docs/9.x/queues#configuring-supervisor) (Official Laravel Documentation).
```
[program:<queue-name>-queue]
process_name=%(program_name)s_%(process_num)02d
directory=/<myproject-directory>
command=/<path-to-php>/php /<myproject-directory>/artisan horizon
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=<user>
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/supervisord/<queue-name>-queue.log
stopwaitsecs=90
```

* Add the following to the cronjob configuration on the server. This will make sure the [Horizon metrics](https://laravel.com/docs/9.x/horizon#metrics) are created periodically.

```
* * * * * /<path-to-php>/php /<myproject-directory>/artisan schedule:run > /dev/null
```

## Creating Job classes

Follow the instructions at [Laravel 9.x generating job classes](https://laravel.com/docs/9.x/queues#generating-job-classes) on how to make Job classes.

> Please note that the use of the `php artisan make:job` command is not supported in October CMS. October CMS is using a different application structure in comparison to a generic Laravel project.

This plugin also contains an example job file: `Vdlp\Horizon\Example`.
This example file does not use the `SerializesModels` and `InteractsWithQueue` trait.

## Testing

1. Log-in to the backend.
2. Put application in debug mode using the `.env` file: `APP_DEBUG=true` or by changing the `debug` key in the `config/app.php` file.
3. Run Horizon using this command: `php artisan horizon`.
4. Now run this command to push some `Vdlp\Horizon\Example` jobs to the queue:

```
php artisan vdlp:horizon:push-example-jobs
```

5. Check the Horizon dashboard at `/backend/vdlp/horizon/dashboard` or at `/horizon`.
6. Each `Vdlp\Horizon\Example` job should log a random string to the application log (level = `debug`).

## Documentation

Please go to the Laravel website for detailed documentation about Laravel Horizon.

[Horizon for Laravel 9.x](https://laravel.com/docs/9.x/horizon)

## Questions

If you have any question about how to use this plugin, please don't hesitate to contact us at [octobercms@vdlp.nl](mailto:octobercms@vdlp.nl). We're
happy to help you. You can also visit the support forum and drop your questions/issues there.
