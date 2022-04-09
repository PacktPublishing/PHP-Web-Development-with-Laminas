<?php
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\ArrayUtils;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/autoload/global.php';

if (file_exists(__DIR__ . '/../config/autoload/local.php')){
    $override = require __DIR__ . '/../config/autoload/local.php';
    $config = ArrayUtils::merge($config, $override);
}

$db = $config['db'];
unset($db['database']); // remove database key because it causes error in connection when database does not exist
$adapter = new Adapter($db);

try {
    echo "Dropping database...\n";
    $adapter->query('DROP DATABASE IF EXISTS whatstore', Adapter::QUERY_MODE_EXECUTE);
    $sqlscript = file_get_contents(__DIR__ . '/whatstore.sql');
    echo "Creating database and tables...\n";
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    echo "Database whatstore created.\n";
} catch (Exception $e) {
    echo 'Fail to recreate the database.' . $e->getMessage() . "\n";
}