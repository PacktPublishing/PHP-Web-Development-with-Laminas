<?php
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Inventory\Model\Product;
use Inventory\Model\ProductTable;
use Inventory\Model\Discount;
use Inventory\Model\DiscountTable;
use PHPUnit\Framework\Assert;
use Generic\Context\AbstractContext;

/**
 * Defines application features from the specific context.
 */
class ProductUpdatingContext extends AbstractContext
{
    private ?Product $product = null;
    private ?ProductTable $productTable = null;
    private ?Discount $discount = null;
    private ?DiscountTable $discountTable = null;
    
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
        $this->productTable = $this->getApplication()->getServiceManager()->get('ProductTable');
        $this->discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
    }
    
    /**
     * @Given I have a product called :arg1, which costs $:arg2
     */
    public function iHaveAProductCalledWhichCosts($arg1, $arg2)
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
    }
    
    /**
     * @When I change the name of product to :arg1
     */
    public function iChangeTheNameOfProductTo($arg1)
    {
        $product = $this->productTable->getByField('name',$this->product->name);
        $product->name = $arg1;
        $this->productTable->save($product);
    }    

    /**
     * @Then there is a product in the table products called :arg1
     */
    public function thereIsAProductInTheTableProductsCalled($arg1)
    {
        $this->product = $this->productTable->getByField('name',$arg1);
        
        Assert::assertEquals($arg1, $this->product->name);
    }

    public function __destruct()
    {
        $product = $this->productTable->getByField('name',$this->product->name);
        $this->productTable->delete($product->code);
        $discount = $this->discountTable->getByField('name','No discount');
        $this->discountTable->delete($discount->code);
        $product = $this->productTable->getByField('name',$product->name);
        Assert::assertEmpty($product->name);            
    }
}
