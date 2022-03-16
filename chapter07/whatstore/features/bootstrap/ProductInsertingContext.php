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
class ProductInsertingContext extends AbstractContext
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
     * @Given there is a product called :arg1, which costs $:arg2
     */
    public function thereIsAProductCalledWhichCosts($arg1, $arg2)
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
    }

    /**
     * @When I add this product to the registration
     */
    public function iAddThisProductToTheRegistration()
    {
        $this->productTable->save($this->product);
    }

    /**
     * @Then I should have a product called :arg1 in the table products
     */
    public function iShouldHaveAProductCalledInTheTableProducts($arg1)
    {
        $this->product = $this->productTable->getByField('name',$arg1);
        
        Assert::assertEquals($arg1, $this->product->name);
    }

    /**
     * @Then the overall product price should be $:arg1
     */
    public function theOverallProductPriceShouldBe($arg1)
    {
        $product = $this->productTable->getByField('name',$this->product->name);
        
        Assert::assertEquals($arg1, $product->price);
    }
    
    public function __destruct()
    {
        $product = $this->productTable->getByField('name',$this->product->name);
        $this->productTable->delete($product->code);
        $discount = $this->discountTable->getByField('name','No discount');
        $this->discountTable->delete($discount->code);
    }
    
}
