[![Build Status](https://travis-ci.org/ar1hur/Cart.png?branch=master)](https://travis-ci.org/ar1hur/Cart)

Cart
====
Playing around with my OOP implementation of a shopping cart with an observable interface...

```php
$product1 = new Product(1, 'xbox', 299.90);
$product2 = new Product(2, 'iphone', 598.98);

$cart = Cart::getInstance();
$cart->attach(new CartObserver);

// add items
$cart->add($product1);
$cart->add($product2, 2); // adding 2 (quantity) of products2

// get items or a specific item
$cart->getItems();
$cart->getItem(1);

// get quantity and total
$cart->getQuantity(); // 3
$cart->getTotal(); // 1497.86
```