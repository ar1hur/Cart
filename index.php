<?php
    namespace Shop\Lib;
	
    use Shop\Lib\Cart\Cart;
	use Shop\Lib\Cart\CartObserver;

    require_once 'bootstrap.php';

	$session = Session::getInstance();	
	$session->test = "test";
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <title>Cart</title>
    
    <script src="js/socket.io.js"></script>
    <script src="js/client.js"></script>
  </head>
  <body>
	<?php
		$product1 = new Product(1, 'xbox', 299.90);
		$product2 = new Product(2, 'iphone', 598.98);

		
		$cart = Cart::getInstance();
		$cart->attach(new CartObserver);

		$cart->add($product1);
		$cart->add($product2, 2); // adding 2 (quantity) of products2
		$cart->add($product1);

		echo "<pre>";
		echo session_id()."<br/>";
		print_r( $cart );
		echo "<hr/>";
		$session->someOtherValue = "test";
		unset($session->test);
		print_r($_SESSION);
		$session->destroy();
	?>

  </body>
</html>