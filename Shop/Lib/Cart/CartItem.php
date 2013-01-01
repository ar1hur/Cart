<?php

	namespace Shop\Lib\Cart;

	use Shop\Lib\Product;

	class CartItem
	{
		protected $id;
		protected $quantity;
		protected $product;

		public function __construct(Product $product, $quantity) 
		{
			$this->id = $product->getId();
			$this->product = $product;
			$this->quantity = $quantity;
		}


		public function getQuantity() 
		{
			return $this->quantity;
		}

		public function setQuantity($quantity) 
		{
			$this->quantity = $quantity;
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