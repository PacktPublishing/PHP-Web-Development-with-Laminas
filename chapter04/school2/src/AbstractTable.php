<?php
declare(strict_types = 1);
namespace School;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGatewayInterface;

abstract class AbstractTable
{

    protected TableGatewayInterface $tableGateway;

    protected string $keyName;

    protected string $modelName;

    public function getByField(string $field, $value): AbstractModel
    {
        $where = [
            $field => $value
        ];
        $rowSet = $this->tableGateway->select($where);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }

    public function getAll(): iterable
    {
        return $this->tableGateway->select(null);
    }

    public function save(AbstractModel $model): bool
    {
        $set = $model->toArray();
        $keyName = $this->keyName;
        try {
            if (empty($model->$keyName)) {
                unset($set[$keyName]);
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

    public function delete($value): bool
    {
        try {
            $this->tableGateway->delete([
                $this->keyName => $value
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    protected static function getAdapter(): AdapterInterface
    {
        $config = require (realpath(__DIR__ . '/../config') . '/config.php');
        $adapter = new Adapter($config['db']);
        return $adapter;
    }
}