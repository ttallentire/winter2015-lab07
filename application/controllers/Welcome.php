<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
        $this->load->helper('directory');
        $this->load->model('order');
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
        $map = directory_map('./data/');
        $orders =  array();
        
	foreach($map as $file)
        {
            if (substr($file, strlen($file) - 4) == ".xml" && $file != "menu.xml")
            {
                $this->order->makeOrder($file);
                $orders[$file] = array('filename' => $file,
                    'order_title' => (substr($file, 0, strlen($file) - 4)), 
                    'name' => $this->order->getOrder($file)['customer']);
            }
        }
        
	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
        $this->data['orders'] = $orders;
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
	$order = $this->order->getOrder($filename);
        print "<h2>".$order['customer']."</h2>";
        
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
        
        
	$this->render();
    }
}
