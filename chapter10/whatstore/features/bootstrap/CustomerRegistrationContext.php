<?php
use Behat\Behat\Tester\Exception\PendingException;
use Generic\Context\AbstractContext;
use Store\Model\Customer;
use Store\Model\CustomerTable;
use PHPUnit\Framework\Assert;

class CustomerRegistrationContext extends AbstractContext
{
    private ?Customer $customer = null;
    private ?CustomerTable $customerTable = null;
    
    public function __construct()
    {
        $this->customer = new Customer();
        $this->customerTable = $this->getApplication()->getServiceManager()->get('CustomerTable');
    }

    /**
     * @Given a customer called :arg1 with IDN :arg2 and with e-mail :arg3
     */
    public function aCustomerCalledWithIdnAndWithEMail($arg1, $arg2, $arg3)
    {
        $data = [
            'IDN' => $arg2,
            'name' => $arg1,
            'email' => $arg3,
            'password' => '1234'
        ];
        $this->customer->exchangeArray($data);
    }

    /**
     * @When I add this customer
     */
    public function iAddThisCustomer()
    {
        $this->customerTable->save($this->customer);
    }

    /**
     * @Then I have a customer called :arg1 in the table customers
     */
    public function iHaveACustomerCalledInTheTableCustomers($arg1)
    {
        $customer = $this->customerTable->getByField('name', $arg1);
        
        Assert::assertEquals($arg1,$customer->name);
    }
    
    public function __destruct()
    {
        $customer = $this->customerTable->getByField('name', $this->customer->name);
        $this->customerTable->delete($customer->IDN);
    }
}
