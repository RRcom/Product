<?php
namespace ProductTest\Model;

use Product\Model\Product\Product;
use PHPUnit_Framework_TestCase;

class ProductTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Product\Model\Product\Product;
     */
    protected $product;

    protected function setUp()
    {
        $this->product = new Product();
    }

    public function testProductInitialState()
    {
        $this->assertNull($this->product->id, '"id" should initially be null');
        $this->assertNull($this->product->category, '"category" should initially be null');
        $this->assertNull($this->product->name, '"name" should initially be null');
        $this->assertNull($this->product->date_created, '"date_created" should initially be null');
    }

    public function testProductExchangeArray()
    {
        $time = time();
        $data = array(
            'id' => 123,
            'category' => 'toys',
            'name' => 'zyma',
            'date_created' => $time,

        );
        $this->product->exchangeArray($data);
        $this->assertEquals(123, $this->product->id, '"id" should be 123');
        $this->assertEquals('toys', $this->product->category, '"category" should be toys');
        $this->assertEquals('zyma', $this->product->name, '"name" should be zyma');
        $this->assertEquals($time, $this->product->date_created, '"name" should be '.$time);
    }
}