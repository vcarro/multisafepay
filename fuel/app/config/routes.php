<?php
return array(
	'_root_'  => 'order/index',  // The default route
	'_404_'   => 'order/404',    // The main 404 route
	
	'order2(/:data)?' => array('order/parser', 'name' => 'order2'),
);
