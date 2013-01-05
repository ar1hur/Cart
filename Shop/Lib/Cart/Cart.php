<?php

namespace Shop\Lib\Cart;

use Shop\Lib\Session;
use Shop\Lib\Product;

class Cart implements \SplSubject
{
	static private $instance;
	protected $session;
	private function __clone() {}


	/**
	 * Saves cart into session with its own namespace
	 */
	protected function __construct() 
	{
		$session = Session::getInstance();
		$session->cart = $this;
		$this->session = $session->cart;

		$this->session->items = array();
		$this->session->observers = array();
	}


	/**
	 * Singleton
	 * @return Cart
	 */
	static public function getInstance() 
	{
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}

		return self::$instance;
	}


	/**
	 * Adds an item / product to the cart or increases quantity if item already exists
	 * @param CartItemInterface 	$product
	 * @param integer 				$quantity
	 * @return Cart
	 */
	public function add(CartItemInterface $product, $quantity=1) 
	{
		if( isset($this->session->items[$product->getId()]) ) {
			$quantity += $this->session->items[$product->getId()]->getQuantity();
			$this->session->items[$product->getId()]->setQuantity($quantity);
		}
		else {
			$this->session->items[$product->getId()] = new CartItem($product, $quantity);
		}

		$this->notify();
		return $this;
	}


	/**
	 * Removes an item from cart by subtraction of its quantity
	 * @param  string $productId
	 * @return Cart
	 */
	public function remove($productId) 
	{
		if( isset($this->session->items[$productId]) ) {
			$quantity = $this->session->items[$productId]->getQuantity();
			if( $quantity > 1 ) {
				$quantity--;
				$this->session->items[$productId]->setQuantity($quantity);
			}
			else {
				$this->delete($productId);
			}
		}

		return $this;
	}


	/**
	 * Deletes an item completely from cart
	 * @param  string $productId
	 * @return Cart
	 */
	public function delete($productId)
	{
		unset($this->session->items[$productId]);
		return $this;
	}


	/**
	 * Get all items
	 * @return array
	 */
	public function getItems()
	{
		return $this->session->items;
	}


	/**
	 * Get a specific item
	 * @param  string $id
	 * @return CartItem|false
	 */
	public function getItem($id)
	{
		if( isset( $this->session->items[$id] ) ) {
			return $this->session->items[$id];
		}
		return false;
	}


	/**
	 * Get total / amount
	 * @return float
	 */
	public function getTotal()
	{
		$total = 0.00;
		foreach($this->session->items as $item) {
			$total +=  $item->getProduct()->getPrice() * $item->getQuantity();
		}
		return $total;
	}


	/**
	 * Get quantity of whole cart
	 * @return integer
	 */
	public function getQuantity()
	{
		$quantity = 0;
		foreach($this->session->items as $item) {
			$quantity +=  $item->getQuantity();
		}
		return $quantity;
	}


	public function attach(\SplObserver $observer)
	{
		$this->session->observers[] = $observer;
	}


	public function detach(\SplObserver $observer)
	{
		$this->session->observers = array_diff($this->observers, array($observer));
	}


	public function notify() 
	{
		foreach( $this->session->observers as $observer ) {
			$observer->update($this);
		}
	}
}
