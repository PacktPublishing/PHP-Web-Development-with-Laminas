<?php
declare(strict_types = 1);
namespace School\Model;

use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGatewayInterface;

class StudentTable extends AbstractTable
{

    protected string $keyName = 'id';

    protected string $modelName = 'School\Model\Student';

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getByField(string $field, $value): AbstractModel
    {
        $where = [
            'students.' . $field => $value
        ];
        $select = new Select($this->tableGateway->getTable());
        $select->join('classes', 'classes.code = students.class_code', [
            'class_name' => 'name'
        ]);
        $select->where($where);
        $rowSet = $this->tableGateway->selectWith($select);
        if ($rowSet->count() == 0) {
            $modelName = $this->modelName;
            return new $modelName();
        }
        return $rowSet->current();
    }

    public function getAll(): iterable
    {
        $select = new Select($this->tableGateway->getTable());
        $select->join('classes', 'classes.code = students.class_code', [
            'class_name' => 'name'
        ]);
        $rowSet = $this->tableGateway->selectWith($select);
        return $rowSet;
    }
}