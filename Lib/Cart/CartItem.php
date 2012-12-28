<?php

	namespace Lib\Cart;

	use Lib\Product;

	class CartItem
	{
		protected $id;
		protected $qty;
		protected $product;

		public function __construct(Product $product, $qty) 
		{
			$this->id = $product->getId();
			$this->product = $product;
			$this->qty = $qty;
		}


		public function getQty() 
		{
			return $this->qty;
		}

		public function setQty($qty) 
		{
			$this->qty = $qty;
			return $this;
		}


		public function getProduct()
		{
			return $this->product;
		}
		

		public function getId() 
		{
			return $this->id;
		}
	}