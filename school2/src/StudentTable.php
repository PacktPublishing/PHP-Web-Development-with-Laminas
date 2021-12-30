<?php
declare(strict_types = 1);
namespace School;

use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;
use Laminas\Db\ResultSet\ResultSet;

class StudentTable extends AbstractTable
{

    protected string $keyName = 'id';

    protected string $modelName = 'School\Student';

    private static ?StudentTable $instance = null;

    private function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public static function getInstance(): StudentTable
    {
        if (null == self::$instance) {
            $adapter = self::getAdapter();
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Student());
            $tableGateway = new TableGateway('students', $adapter, null, $resultSetPrototype);
            self::$instance = new StudentTable($tableGateway);
        }
        return self::$instance;
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