<?php
namespace Product\Model\Product;

class Product
{
    public $id;

    public $name;

    public $category;

    public $date_created;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->category  = (isset($data['category'])) ? $data['category'] : null;
        $this->date_created = (isset($data['date_created'])) ? $data['date_created'] : null;
    }
}