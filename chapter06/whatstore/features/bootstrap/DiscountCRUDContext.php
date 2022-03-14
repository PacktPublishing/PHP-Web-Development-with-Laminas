<?php

use Behat\Behat\Tester\Exception\PendingException;
use Generic\Context\AbstractContext;
use Inventory\Model\Discount;
use Inventory\Model\DiscountTable;
use PHPUnit\Framework\Assert;

class DiscountCRUDContext extends AbstractContext
{
    private ?Discount $discount;
    private ?DiscountTable $discountTable;
    private string $name = '';
    
    public function __construct()
    {
        $this->discount = new Discount();
        $this->discountTable = $this->getApplication()->getServiceManager()->get('DiscountTable');
    }

    /**
     * @Given there is a discount called :arg1 with operator :arg2 and factor :arg3
     */
    public function thereIsADiscountCalledWithOperatorAndFactor($arg1,$arg2,$arg3)
    {
        $this->discount = new Discount();
        $this->discount->name = $arg1;
        $this->discount->operator = $arg2;
        $this->discount->factor = $arg3;
        $this->discountTable->save($this->discount);
        
        $discount = $this->discountTable->getByField('name',$arg1);
        
        Assert::assertEquals($arg1, $this->discount->name);
        
        $this->name = $arg1;
    }

    /**
     * @When I change the name of discount to :arg1 and the operator to :arg2 and the factor to :arg3
     */
    public function iChangeTheNameOfDiscountToAndTheOperatorToAndTheFactorTo($arg1, $arg2, $arg3)
    {
        $this->discount = $this->discountTable->getByField('name', $this->name);
        $this->discount->name = $arg1;
        $this->discount->operator = $arg2;
        $this->discount->factor = $arg3;
        $this->discountTable->save($this->discount);
        
        $this->name = $arg1;
    }

    /**
     * @Then I have a discount with the operator equals to :arg1
     */
    public function iHaveADiscountWithTheOperatorEqualsTo($arg1)
    {
        $this->discount = $this->discountTable->getByField('name',$this->name);
        
        Assert::assertEquals($arg1, $this->discount->operator);
    }

    /**
     * @Then I have a discount with the factor equal to :arg1
     */
    public function iHaveADiscountWithTheFactorEqualTo($arg1)
    {
        Assert::assertEquals($arg1, $this->discount->factor);
    }
    
    public function __destruct()
    {
        $this->discount = $this->discountTable->getByField('name',$this->name);
        $this->discountTable->delete($this->discount->code);
    }
}
