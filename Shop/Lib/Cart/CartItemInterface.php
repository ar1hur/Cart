<?php

namespace Shop\Lib\Cart;

interface CartItemInterface
{
	/**
	 * Needs an unique id getter foreach product
	 * @return string|integer
	 */
	public function getId();
}