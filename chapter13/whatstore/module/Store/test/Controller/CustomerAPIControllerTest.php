<?php

declare(strict_types=1);

namespace StoreTest\Controller;

use Store\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\Db\Adapter\Adapter;

class CustomerAPIControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testCreate(): void
    {
        $_POST = [
            'IDN' => 1955,
            'name' => 'Jonn Jonzz',
            'password' => 'hronmeer',
            'jonn@mars.com'
        ];
        $this->dispatch('/storeapi/customerapi', 'POST',$_POST);
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('customerapi'); // as specified in router's controller name alias
        $this->assertControllerClass('CustomerAPIController');
        $this->assertMatchedRouteName('storeapi');
        
        $adapter = $this->getApplication()->getServiceManager()->get('DbAdapter');
        $adapter->query("DELETE FROM `customers` WHERE name = 'JONN JONZZ'", Adapter::QUERY_MODE_EXECUTE);
    }
}
