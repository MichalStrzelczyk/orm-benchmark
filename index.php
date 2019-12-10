<?php
error_reporting(E_ALL);
define('BASE_PATH', realpath('./'));

require_once 'vendor/autoload.php';

$di = new \Phalcon\Di\FactoryDefault\Cli();
$di->setShared(
    'db',
    function () {
        $config = [
            'schema' => 'public',
            'host' => '172.20.0.3',
            'dbname' => 'postgres',
            'port' => 5432,
            'username' => 'postgres',
            'password' => '******',
        ];

        $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

        return $connection;
    }
);

$di->setShared(
    'maleficarumRepo',
    function () {
        $shard = new \Maleficarum\Storage\Shard\Postgresql\Connection(
            '172.20.0.3',
            5432,
            'postgres',
            'postgres',
            '***************'
        );

        $storageManager = new \Maleficarum\Storage\Manager();
        $storageManager->attachShard($shard,'Postgresql','test');
        $repository = new \Repository\Voucher\Postgresql\Entity();
        $repository->setStorage($storageManager);
        $repository->setShardSelector(function($model){
           return 'test';
        });

        return $repository;
    }
);

$di->setShared(
    'doctrine',
    function () {

        $paths = [BASE_PATH . '/src/Data/Voucher'];
        $isDevMode = false;
        $config =  \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $dbParams = array(
            'driver'   => 'pdo_pgsql',
            'user'     => 'postgres',
            'password' => '*********',
            'dbname'   => 'postgres',
            'host'   => '172.20.0.3',
            'porrt'   => 5432,
        );

        $entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config);

        return $entityManager;
    }
);

$di->setShared(
    'pdo',
    function () {
        return new \PDO('pgsql:dbname=postgres;port=5432;host=172.20.0.3;','postgres','*******');
    }
);

$di->setShared(
    'dispatcher',
    function () {
        $dispatcher = new \Phalcon\Cli\Dispatcher();
        $dispatcher->setDefaultNamespace("Task");

        return $dispatcher;
    }
);

$console = new  Phalcon\Cli\Console();
$console->setDI($di);

$arguments = [];
foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    // Do Phalcon related stuff here
    // ..
    fwrite(STDERR, $e->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(1);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
