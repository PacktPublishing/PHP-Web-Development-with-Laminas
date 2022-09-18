<?php
use Laminas\Db\Adapter\Adapter;
use Laminas\Stdlib\ArrayUtils;
use Inventory\Model\Employee;
use Laminas\Db\Adapter\AdapterInterface;
use Store\Model\Customer;
use Generic\Filter\Encrypt;

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
    $filter = new Encrypt();
    $password = $filter->filter('moonknight');
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
    
    echo "An user and a role were created.\n";
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

function addCustomer(AdapterInterface $adapter): void
{
    $filter = new Encrypt();
    $password = $filter->filter('mypass123@');
    $sqlscript = <<<SQL
INSERT INTO `customers`(`IDN`, `name`, `password`, `email`) VALUES (2814,'DUDE','$password','dude@acme.com');
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    echo "A customer was created.\n";
}

function addDiscount(AdapterInterface $adapter): void
{
    $sqlscript = <<<SQL
INSERT INTO `discounts`(`name`, `operator`, `factor`) VALUES ('NO DISCOUNT','-',0);
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    echo "A discount was created.\n";
}

function addProducts(AdapterInterface $adapter): void
{
    $discount = $adapter->query('SELECT * FROM `discounts` WHERE `name` = ?', ['NO DISCOUNT'])->current();
    
    $sqlscript = <<<SQL
INSERT INTO `products`(`name`, `price`, `code_discount`) VALUES 
('ENCHANTED HAMMER',9,{$discount->code}),
('POWER RING',2814,{$discount->code}),
('UTILITY BELT',39,{$discount->code}),
('VIBRANIUM SHIELD','1941',{$discount->code}),
('LASSO OF TRUTH','1942',{$discount->code}),
('FLUX CAPACITOR','1955',{$discount->code}),
('TOWEL','42',{$discount->code}),
('LIGHT SABER','1977',{$discount->code}),
('GLAIVE','1983',{$discount->code});
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    $sqlscript = <<<SQL
INSERT INTO `inventory`(`code_product`, `amount`, `maximum`, `minimum`, `reserved`) VALUES
((SELECT code from `products` WHERE name = 'ENCHANTED HAMMER'),2,2,1,0),
((SELECT code from `products` WHERE name = 'POWER RING'),7200,7200,1,0),
((SELECT code from `products` WHERE name = 'UTILITY BELT'),1000,5000,1,0),
((SELECT code from `products` WHERE name = 'VIBRANIUM SHIELD'),1,1,1,0),
((SELECT code from `products` WHERE name = 'LASSO OF TRUTH'),3,3000,1,0),
((SELECT code from `products` WHERE name = 'FLUX CAPACITOR'),3,9999,1,0),
((SELECT code from `products` WHERE name = 'TOWEL'),42,1001,1,0),
((SELECT code from `products` WHERE name = 'LIGHT SABER'),500,10000,1,0),
((SELECT code from `products` WHERE name = 'GLAIVE'),1,1,1,0);
SQL;
    $adapter->query($sqlscript, Adapter::QUERY_MODE_EXECUTE);
    
    echo "Products were created.\n";
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
    addCustomer($adapter);
    addDiscount($adapter);
    addProducts($adapter);
} catch (Exception $e) {
    echo 'Fail to recreate the database.' . $e->getMessage() . "\n";
}