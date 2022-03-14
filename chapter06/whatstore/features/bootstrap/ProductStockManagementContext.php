<?php

use Behat\Behat\Tester\Exception\PendingException;
use Generic\Context\AbstractContext;
use Inventory\Model\Product;
use Inventory\Model\ProductTable;
use Inventory\Model\Discount;
use Inventory\Model\DiscountTable;
use Inventory\Model\Inventory;
use Inventory\Model\InventoryTable;
use PHPUnit\Framework\Assert;

class ProductStockManagementContext extends AbstractContext
{
    private ?Product $product = null;
    private ?ProductTable $productTable = null;
    private ?Discount $discount = null;
    private ?DiscountTable $discountTable = null;
    private ?Inventory $inventory = null;
    private ?InventoryTable $inventoryTable = null;
    private int $amount = 0;
    
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->product = new Product();
        $this->discount = new Discount();
        $this->inventory = new Inventory();
        $this->productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $this->discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
        $this->inventoryTable = $this->getApplication()->getServiceManager()->get('InventoryTable');
    } 

    /**
     * @Given there is a registered product called :arg1, which costs $:arg2
     */
    public function thereIsARegisteredProductCalledWhichCosts($arg1, $arg2)
    {
        $data = [
            'name' => 'No discount',
            'operator' => '+',
            'factor' => '0'
        ];
        
        $this->discount->exchangeArray($data);
        $this->discountTable->save($this->discount);
        $discount = $this->discountTable->getByField('name','No discount');
        
        $data = [
            'name'  => $arg1,
            'price' => $arg2,
            'code_discount' => $discount->code
        ];
        $this->product->exchangeArray($data);        
        $this->productTable->save($this->product);        
        $product = $this->productTable->getByField('name',$arg1);
        
        $data = [
            'code_product' => $product->code,
            'amount'    => 0,
            'maximum'   => 9999,
            'minimum'   => 0,
            'reserved'  => 0            
        ];
        
        $this->inventory->exchangeArray($data);
        $this->inventoryTable->save($this->inventory);
    }

    /**
     * @When I add :arg1 units in stock
     */
    public function iAddUnitsInStock($arg1)
    {
        $this->product = $this->productTable->getByField('name',$this->product->name);
        
        $this->inventoryTable->addItems($this->product->code, $arg1);
        
        $this->amount = $arg1;
    }

    /**
     * @Then I should have :arg2 :arg1 in the table inventory
     */
    public function iShouldHaveInTheTableInventory($arg1, $arg2)
    {
        $inventory = $this->inventoryTable->getByField('code_product', $this->product->code);
        
        Assert::assertEquals($this->amount, $inventory->amount);
    }
    
    public function __destruct()
    {
        $this->inventoryTable->delete($this->product->code);
        $this->productTable->delete($this->product->code);
        $this->discountTable->delete($this->product->discount->code);
    }

}
