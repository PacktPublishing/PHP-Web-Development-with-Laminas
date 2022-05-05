<?php

declare(strict_types=1);

namespace StoreTest\Controller;

use Store\Controller\IndexController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class OrderAPIControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/storeapi/orderapi/0', 'POST');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('store');
        $this->assertControllerName('orderapi'); // as specified in router's controller name alias
        $this->assertControllerClass('OrderAPIController');
        $this->assertMatchedRouteName('storeapi');
    }
}
