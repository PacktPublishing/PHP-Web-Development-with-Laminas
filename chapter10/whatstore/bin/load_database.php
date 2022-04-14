<?php
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\ArrayUtils;
use Inventory\Model\Employee;
use Laminas\Db\Adapter\AdapterInterface;

require __DIR__ . '/../vendor/autoload.php';

function getConfig(): array
{
    $config = require __DIR__ . '/../config/autoload/global.php';
    
    if (file_exists(__DIR__ . '/../config/autoload/local.php')){
        $override = require __DIR__ . '/../config/autoload/local.php';
        $config = ArrayUtils::merge($config, $override);
    }
    return $config;
}

function recreateDatabase(AdapterInterface $adapter): void
{
    echo "Dropping database...\n";
    $adapter->query('DROP DATABASE IF EXISTS whatstore', Adapter::QUERY_MODE_EXECUTE);
    $sqlscript = file_get_contents(__DIR__ . '/whatstore.sql');
    echo "Creating database and tables...\n";
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    echo "Whatstore database has been created.\n";    
}

function addUserAndRole($adapter): void
{
    $password = Employee::encrypt('moonknight');
    $sqlscript = <<<SQL
INSERT INTO `employees`(`ID`, `name`, `nickname`, `password`) VALUES (NULL,'STEVEN GRANT','MARK SPEKTOR','$password');
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    $sqlscript = <<<SQL
INSERT INTO `roles`(`code`, `name`) VALUES (NULL,'ADMIN');
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    $sqlscript = <<<SQL
    INSERT INTO `employee_roles`(`code`, `code_role`, `ID_employee`) VALUES (NULL,(SELECT code FROM `roles` WHERE name = 'ADMIN'),(SELECT ID FROM `employees` WHERE name = 'STEVEN GRANT'));
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    echo "A user and a role were created.\n";
}

function getResources(array $controllers): String
{
    $actionMethods = ['getMethodFromAction','notFoundAction'];
    $httpMethods = ['create','update','get','delete'];
    $restMethods = [
        'create' => 'POST',
        'update' => 'PUT',
        'get' => 'GET',
        'delete' => 'DELETE'
    ];
    
    $resources = '';
    foreach ($controllers as $controller){
        $methods = get_class_methods($controller);
        foreach($methods as $method){
            $alias = str_replace('Inventory\Controller\\','',$controller);
            $alias = strtolower(str_replace('Controller','',$alias));
            if (strpos($method,'Action') !== false && !in_array($method, $actionMethods)){
                $method = str_replace('Action', '', $method);
                $resources .= "(NULL,'$alias.$method','GET'),";
                $resources .= "(NULL,'$alias.$method','POST'),";
            }
            if (in_array($method, $httpMethods)){
                $resources .= "(NULL,'$alias.{$method}', '{$restMethods[$method]}'),";
            }
        }
    }
    
    return substr($resources, 0,strlen($resources)-1);    
}

function addResources($adapter): void
{
    $dir = scandir(realpath(__DIR__ . '/../module/Inventory/src/Controller'));
    
    $controllers = [];
    
    foreach($dir as $file){
        if (strpos($file,'Controller.php') !== false){
            $controllers[] = 'Inventory\Controller\\' . str_replace('.php','',$file);
        }
    }
    
    $resources = getResources($controllers);
    
    $sqlscript = <<<SQL
INSERT INTO `resources`(`code`, `name`, `method`) VALUES $resources;
SQL;
    
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    echo "Resources were created.\n";
}

function grantPermissionstoRole(AdapterInterface $adapter): void
{
    $statement = $adapter->query('SELECT code FROM `resources`');
    
    $results = $statement->execute();
    
    foreach($results as $row){
        $sqlscript = <<<SQL
    INSERT INTO `resources_role`(`code`, `code_role`, `code_resource`) VALUES (NULL,(SELECT code FROM `roles` WHERE name = 'ADMIN'),{$row['code']});
SQL;
        $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);        
    }
    
    echo "Permissions were granted.\n";
}

// main program

$config = getConfig();
$db = $config['db'];
unset($db['database']); // remove database key because it causes error in connection when database does not exist
$adapter = new Adapter($db);

try {
    recreateDatabase($adapter);
    $db = $config['db'];
    $adapter = new Adapter($db);
    addUserAndRole($adapter);
    addResources($adapter);
    grantPermissionsToRole($adapter);
} catch (Exception $e) {
    echo 'Fail to recreate the database.' . $e->getMessage() . "\n";
}