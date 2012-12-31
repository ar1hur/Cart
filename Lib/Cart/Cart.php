<?php

	namespace Lib\Cart;

	use Lib\Session;
	use Lib\Product;

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
		 * @param Product $product
		 * @param integer $qty
		 * @return Cart
		 */
		public function add(Product $product, $qty=1) 
		{
			if( isset($this->session->items[$product->getId()]) ) {
				$qty += $this->session->items[$product->getId()]->getQty();
				$this->session->items[$product->getId()]->setQty($qty);
			}
			else {
				$this->session->items[$product->getId()] = new CartItem($product, $qty);
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
				$qty = $this->session->items[$productId]->getQty();
				if( $qty > 1 ) {
					$qty--;
					$this->session->items[$productId]->setQty($qty);
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
		 * Get total / amount
		 * @return float
		 */
		public function getTotal()
		{
			$total = 0.00;
			foreach($this->session->items as $item) {
				$total +=  $item->getProduct()->getPrice() * $item->getQty();
			}
			return $total;
		}


		/**
		 * Get quantity of whole cart
		 * @return integer
		 */
		public function getQuantity()
		{
			$qty = 0;
			foreach($this->session->items as $item) {
				$qty +=  $item->getQty();
			}
			return $qty;
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
