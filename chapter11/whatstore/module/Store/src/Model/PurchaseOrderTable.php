<?php
declare(strict_types = 1);
namespace Store\Model;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSet;
use Generic\Model\AbstractTable;
use Generic\Model\AbstractModel;

class PurchaseOrderTable extends AbstractTable
{

    protected string $keyName = 'code';

    protected string $modelName = 'Store\Model\PurchaseOrder';
    
    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        try {
            $set['date'] = date('Y-m-d');
            $this->tableGateway->insert($set);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }
    
    public function getLastCreatedCode(): int
    {
        return (int) $this->tableGateway->getLastInsertValue();
    }
}