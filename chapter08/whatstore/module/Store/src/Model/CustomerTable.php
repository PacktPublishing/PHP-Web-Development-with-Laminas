<?php
declare(strict_types = 1);
namespace Store\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;

class CustomerTable extends AbstractTable
{

    protected string $keyName = 'IDN';

    protected string $modelName = 'Store\Model\Customer';
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        $customer = $this->getByField('IDN', $model->$keyName);
        try {
            if (empty($customer->$keyName)) {
                $this->tableGateway->insert($set);
            } else {
                $this->tableGateway->update($set, [
                    $keyName => $set[$keyName]
                ]);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
}