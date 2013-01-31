<?php

namespace Shop\Test\Lib\Cart;

use Shop\Lib\Cart\Cart;
use Shop\Lib\Product;

class CartTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * It should add 2x2 products on different ways
	 * @return Cart
	 */
	public function testAddItems()
	{
		$product1 = new Product(1, 'xbox', 299.90);
		$product2 = new Product(2, 'iphone', 598.98);

		$cart = Cart::getInstance();
		$cart->add($product1);
		$cart->add($product2, 2);
		$cart->add($product1);

		$this->assertEquals(4, $cart->getQuantity());
		$this->assertCount(2, $cart->getItems());
		$this->assertEquals(2, $cart->getItem(1)->getQuantity());

		return $cart;
	}


	/**
	 * @depends testAddItems
	 * It should sum all prices
	 */
	public function testSumTotalOfPrices($cart)
	{
		$this->assertEquals(1797.76, $cart->getTotal());
	}


	/**
	 * @depends testAddItems
	 * It should remove a product by subtraction its quantity
	 * @param  Cart $cart
	 */
	public function testRemoveItems($cart)
	{
		$productId = 2;
		$cart->remove($productId);

		$this->assertEquals(3, $cart->getQuantity());
		$this->assertCount(2, $cart->getItems());
		$this->assertEquals(1, $cart->getItem($productId)->getQuantity());
		$this->assertEquals(1198.78, $cart->getTotal());
	}


	/**
	 * @depends testAddItems
	 * It should delete a product completely from cart
	 * @param  Cart $cart
	 */
	public function testDeleteItem($cart)
	{
		$product2 = new Product(2, 'iphone', 598.98);
		$cart->add($product2);

		$productId = 1;
		$cart->delete($productId);
		
		$this->assertEquals(2, $cart->getQuantity());
		$this->assertFalse($cart->getItem($productId));
	}
}
