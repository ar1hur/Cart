<?php

	namespace Lib\Cart;

	use Lib\Product;

	class Cart implements \SplSubject
	{
		static private $instance;
		protected $items = array();
		protected $observers = array();


		private function __clone() {}
		private function __construct() {}


		static public function getInstance() 
		{
			if( !self::$instance instanceof self ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

	
		public function add(Product $product, $qty=1) 
		{
			if( isset($this->items[$product->getId()]) ) {
				$qty += $this->items[$product->getId()]->getQty();
				$this->items[$product->getId()]->setQty($qty);
			}
			else {
				$this->items[$product->getId()] = new CartItem($product, $qty);
			}

			$this->notify();
			return $this;
		}


		public function remove($productId) 
		{
			if( isset($this->items[$productId]) ) {
				$qty = $this->items[$productId]->getQty();
				if( $qty > 1 ) {
					$qty--;
					$this->items[$productId]->setQty($qty);
				}
				else {
					$this->delete($productId);
				}
			}

			return $this;
		}


		public function delete($productId)
		{
			unset($this->items[$productId]);
			return $this;
		}


		public function getItems()
		{
			return $this->items;
		}


		public function getTotal()
		{
			$total = 0.00;
			foreach($this->items as $item) {
				$total +=  $item->getProduct()->getPrice() * $item->getQty();
			}
			return $total;
		}


		public function getQuantity()
		{
			$qty = 0;
			foreach($this->items as $item) {
				$qty +=  $item->getQty();
			}
			return $qty;
		}


		public function attach(\SplObserver $observer)
		{
			$this->observers[] = $observer;
		}


		public function detach(\SplObserver $observer)
		{
			$this->observers = array_diff($this->observers, array($observer));
		}


		public function notify() 
		{
			foreach( $this->observers as $observer ) {
				$observer->update($this);
			}
		}
	}
