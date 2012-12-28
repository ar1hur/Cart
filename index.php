<?php

	namespace Shop;

	use Lib\Product;
	use Lib\Cart\Cart;
	use Lib\Cart\CartObserver;

	require_once 'Autoloader.php';
	\Autoloader::registerAutoload();

	$product1 = new Product(1, 'xbox', 299.90);
	$product2 = new Product(2, 'iphone', 598.98);

	$cart = Cart::getInstance();
	$cart->attach(new CartObserver);

	$cart->add($product1);
	$cart->add($product2, 2);
	$cart->add($product1);

	echo "<pre>";
	print_r( $cart );
	#echo "TOTAL=".$cart->getTotal();