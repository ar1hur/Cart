<?php

namespace Shop\Lib;

use Shop\Lib\Cart\CartItemInterface;

class Product implements CartItemInterface
{
	protected $id;
	protected $name;
	protected $price;

	public function __construct($id, $name, $price=0.00) {
		$this->id = $id;
		$this->name = $name;
		$this->price = $price;
	}

	public function getId() {
		return $this->id;
	}


	public function setId($id) {
		$this->id = $id;
	}


	public function getName() {
		return $this->name;
	}


	public function setName($name) {
		$this->name = $name;
	}


	public function getPrice() {
		return $this->price;
	}


	public function setPrice($price) {
		$this->price = $price;
	}

}
