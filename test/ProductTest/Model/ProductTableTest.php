<?php
namespace ProductTest\Model;

use PHPUnit_Framework_TestCase;
use Product\Model\Product\Product;
use ProductTest\Bootstrap;

class ProductTableTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Product\Model\Product\ProductTable;
     */
    protected $productTable;

    protected $time;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->productTable = $serviceManager->get('Product\Model\Product\ProductTable');
        $this->time = time();
    }

    public function testProductObject()
    {
        $this->assertEquals('Product\Model\Product\ProductTable', get_class($this->productTable), '"$productTable" must be instance of Product\Model\Product\ProductTable');
    }

    public function testCreateProduct()
    {
        $product = new Product();
        $product->name = 'Test Product';
        $product->category = 'Toys';
        $product->date_created = $this->time;
        $this->productTable->saveProduct($product);
        $id = $this->productTable->getTableGateway()->lastInsertValue;
        $this->assertGreaterThan(0, $id, 'creating product failed');
        return $id;
    }

    /**
     * @depends testCreateProduct
     */
    public function testReadProduct($id)
    {
        $product = $this->productTable->getProduct($id);
        $this->assertEquals('Product\Model\Product\Product', get_class($product), 'result must be instance of Product\Model\Product\Product');
        $this->assertEquals('Test Product', $product->name, '"name" must be Test Product');
        $this->assertEquals('Toys', $product->category, '"category" must be Toys');
        $this->assertEquals($this->time, $product->date_created, '"created_time" must be '.$this->time);
        return $product;
    }

    /**
     * @depends testReadProduct
     */
    public function testUpdateProduct(Product $product)
    {
        $newTime = time();
        $product->name = 'Plasma HD Smart TV';
        $product->category = 'Electronics';
        $product->date_created = $newTime;
        $this->productTable->saveProduct($product);
        $product = $this->productTable->getProduct($product->id);
        $this->assertEquals('Product\Model\Product\Product', get_class($product), 'result must be instance of Product\Model\Product\Product');
        $this->assertEquals('Plasma HD Smart TV', $product->name, '"name" must be Plasma HD Smart TV');
        $this->assertEquals('Electronics', $product->category, '"category" must be Electronics');
        $this->assertEquals($newTime, $product->date_created, '"date_created" must be '.$newTime);
        return $product;
    }

    /**
     * @depends testUpdateProduct
     */
    public function testFetchAll(Product $product)
    {
        $products = $this->productTable->fetchAll();
        $this->assertGreaterThan(0, $products->count(), 'fetch all return 0 result');
        $this->assertEquals('Product\Model\Product\Product', get_class($products->current()), 'result must be instance of Product\Model\Product\Product');
        return $product;
    }

    /**
     * @depends testFetchAll
     */
    public function testSearch(Product $product)
    {
        $products = $this->productTable->search('Plasma');
        $this->assertGreaterThan(0, $products->count(), 'fetch all return 0 result');
        $this->assertEquals('Product\Model\Product\Product', get_class($products->current()), 'result must be instance of Product\Model\Product\Product');
        $this->assertEquals('Plasma HD Smart TV', $products->current()->name, 'product with name Plasma HD Smart TV not found');
        return $product;
    }

    /**
     * @depends testSearch
     */
    public function testDeleteProduct(Product $product)
    {
        $this->productTable->deleteProduct($product->id);
        $this->assertEquals(null, $this->productTable->getProduct($product->id));
    }
}