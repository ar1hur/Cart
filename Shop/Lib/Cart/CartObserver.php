<?php

namespace Shop\Lib\Cart;

class CartObserver implements \SplObserver
{
	public function update(\SplSubject $cart)
	{
		echo "TOTAL = ".$cart->getTotal(). " EUR<br/>";
		echo "cart has ".$cart->getQuantity()." items now!<br/>";
	}
}