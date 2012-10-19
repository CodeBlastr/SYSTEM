<?php
$cart_count = 0;
{$cart_count = $this->Session->read('OrdersCartCount');} 

echo  $cart_count ; ?>