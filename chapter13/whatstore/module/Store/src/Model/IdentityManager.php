<?php
namespace Store\Model;

use Generic\Model\IdentityManager as GenericIdentityManager;

class IdentityManager extends GenericIdentityManager
{
    protected function doCustomTasks(): void
    {
        Customer::setCustomer($this->adapter->getResultRowObject(null,'password'));
    }
}