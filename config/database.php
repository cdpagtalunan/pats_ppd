<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false, // to allow old version of mysql aggregate functions, commented by -JD
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_cn_ppts' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_PPTS', '127.0.0.1'),
            'port' => env('DB_PORT_PPTS', '3306'),
            'database' => env('DB_DATABASE_PPTS', 'forge'),
            'username' => env('DB_USERNAME_PPTS', 'forge'),
            'password' => env('DB_PASSWORD_PPTS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false, // to allow old version of mysql aggregate functions, commented by -JD
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_rapid_eedms' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_RAPID_EEDMS', '192.168.3.235'),
            'port' => env('DB_PORT_RAPID_EEDMS', '3306'),
            'database' => env('DB_DATABASE_RAPID_EEDMS', 'forge'),
            'username' => env('DB_USERNAME_RAPID_EEDMS', 'forge'),
            'password' => env('DB_PASSWORD_RAPID_EEDMS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_rapid_pps' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_RAPID_PPS', '192.168.3.235'),
            'port' => env('DB_PORT_RAPID_PPS', '3306'),
            'database' => env('DB_DATABASE_RAPID_PPS', 'forge'),
            'username' => env('DB_USERNAME_RAPID_PPS', 'forge'),
            'password' => env('DB_PASSWORD_RAPID_PPS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        // 'mysql_rapid_pps_test' => [
        //     'driver' => 'mysql',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_HOST_RAPID_PPS_TEST', '192.168.3.235'),
        //     'port' => env('DB_PORT_RAPID_PPS_TEST', '3306'),
        //     'database' => env('DB_DATABASE_RAPID_PPS_TEST', 'forge'),
        //     'username' => env('DB_USERNAME_RAPID_PPS_TEST', 'forge'),
        //     'password' => env('DB_PASSWORD_RAPID_PPS_TEST', ''),
        //     'unix_socket' => env('DB_SOCKET', ''),
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'strict' => true,
        //     'engine' => null,
        //     'options' => extension_loaded('pdo_mysql') ? array_filter([
        //         PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        //     ]) : [],
        // ],

        'mysql_rapid_stamping_dmcms' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_RAPID_STAMPING_DMCMS', '192.168.3.235'),
            'port' => env('DB_PORT_RAPID_STAMPING_DMCMS', '3306'),
            'database' => env('DB_DATABASE_RAPID_STAMPING_DMCMS', 'forge'),
            'username' => env('DB_USERNAME_RAPID_STAMPING_DMCMS', 'forge'),
            'password' => env('DB_PASSWORD_RAPID_STAMPING_DMCMS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_rapid_acdcs' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_RAPID_ACDCS', '192.168.3.235'),
            'port' => env('DB_PORT_RAPID_ACDCS', '3306'),
            'database' => env('DB_DATABASE_RAPID_ACDCS', 'forge'),
            'username' => env('DB_USERNAME_RAPID_ACDCS', 'forge'),
            'password' => env('DB_PASSWORD_RAPID_ACDCS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_subsystem' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SUBSYSTEM', '192.168.3.246'),
            'port' => env('DB_PORT_SUBSYSTEM', '3306'),
            'database' => env('DB_DATABASE_SUBSYSTEM', 'forge'),
            'username' => env('DB_USERNAME_SUBSYSTEM', 'forge'),
            'password' => env('DB_PASSWORD_SUBSYSTEM', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_systemone_hris' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SYSTEMONE_HRIS', '192.168.3.240'),
            'port' => env('DB_PORT_SYSTEMONE_HRIS', '3306'),
            'database' => env('DB_DATABASE_SYSTEMONE_HRIS', 'forge'),
            'username' => env('DB_USERNAME_SYSTEMONE_HRIS', 'forge'),
            'password' => env('DB_PASSWORD_SYSTEMONE_HRIS', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'mysql_systemone_subcon' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_SYSTEMONE_SUBCON', '192.168.3.240'),
            'port' => env('DB_PORT_SYSTEMONE_SUBCON', '3306'),
            'database' => env('DB_DATABASE_SYSTEMONE_SUBCON', 'forge'),
            'username' => env('DB_USERNAME_SYSTEMONE_SUBCON', 'forge'),
            'password' => env('DB_PASSWORD_SYSTEMONE_SUBCON', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'rapidx' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE_RAPIDX', 'forge'),
            'username' => env('DB_USERNAME_RAPIDX', 'forge'),
            'password' => env('DB_PASSWORD_RAPIDX', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        'sqlsrv_1' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST_YPICS', '192.168.3.251\MSSQLSERVER'),
            'port' => env('DB_PORT_YPICS', '1433'),
            'database' => env('DB_DATABASE_YPICS', 'forge'),
            'username' => env('DB_USERNAME_YPICS', 'forge'),
            'password' => env('DB_PASSWORD_YPICS', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

        // 'mssql' => [
        //     'driver' => 'mssql',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_HOST_RAPID_PPS', '192.168.3.251'),
        //     'port' => env('DB_PORT_RAPID_PPS', '3306'),
        //     'database' => env('DB_DATABASE_RAPID_PPS', 'forge'),
        //     'username' => env('DB_USERNAME_RAPID_PPS', 'forge'),
        //     'password' => env('DB_PASSWORD_RAPID_PPS', ''),
        //     'unix_socket' => env('DB_SOCKET', ''),
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'strict' => true,
        //     'engine' => null,
        //     'options' => extension_loaded('pdo_sqlsrv') ? array_filter([
        //         PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        //     ]) : [],
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
