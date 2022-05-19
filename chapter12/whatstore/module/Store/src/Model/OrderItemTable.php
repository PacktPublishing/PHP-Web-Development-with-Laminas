<?php
declare(strict_types = 1);
namespace Store\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;

class OrderItemTable extends AbstractTable
{

    protected string $keyName = 'code_order,code_product';

    protected string $modelName = 'Store\Model\OrderItem';
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        try {
            $this->tableGateway->insert($set);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
}