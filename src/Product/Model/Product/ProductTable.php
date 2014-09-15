<?php
namespace Product\Model\Product;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class ProductTable
{
    const OFFSET_DEFAULT = 0;
    const LIMIT_DEFAULT = 30;

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($offset = self::OFFSET_DEFAULT, $limit = self::LIMIT_DEFAULT)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($offset, $limit) {
            $select
                ->offset($offset)
                ->limit($limit);
        });
        return $resultSet;
    }

    public function search($string, $offset = self::OFFSET_DEFAULT, $limit = self::LIMIT_DEFAULT)
    {
        $resultSet = $this->tableGateway->select(function(Select $select) use ($string, $offset, $limit) {
            $select->where
                ->like('name', '%'.$string.'%')
                ->OR
                ->like('category', '%'.$string.'%');
            $select
                ->offset($offset)
                ->limit($limit);
        });
        return $resultSet;
    }

    /**
     * @param $id
     * @return \Product\Model\Product\Product|null
     * @throws \Exception
     */
    public function getProduct($id)
    {
        $id  = (int) $id;
        $rowSet = $this->tableGateway->select(array('id' => $id));
        $row = $rowSet->current();
        if (!$row) {
            return null;
        }
        return $row;
    }

    public function saveProduct(Product $product)
    {
        $data = array(
            'name' => $product->name,
            'category'  => $product->category,
            'date_created' => $product->date_created,
        );

        $id = (int)$product->id;
        if ($id == 0) {
            return $this->tableGateway->insert($data);
        } else {
            if ($this->getProduct($id)) {
                return $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}