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
        $this->load->model("menu");
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
                $orders[$file] = array('filename' => (string)$file,
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
        $burgerno = 1;
        $btotal = 0;
        $total = 0;
        $burgers = array();
        
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
        
        // Order heading
        $this->data['order'] = (substr($filename, 0, strlen($filename) - 4));
        $this->data['name'] = $order['customer'];
        $this->data['type'] = $order['type'];
        
        foreach($order['burgers'] as $burger) {
            $cheeses = array();
            $toppings = array();
            $sauces = array();
            // Patty
            $btotal += $this->menu->getPatty($burger['patty'])->price;
            // Cheese
            if (!isset($burger['cheeses']['top'])) {
                $cheeses['top'] = (string)"None";
            } else {
                $temp = $this->menu->getCheese($burger['cheeses']['top']);
                $cheeses['top'] = $temp->name;
                $btotal += $this->menu->getCheese($burger['cheeses']['top'])->price;
            }
            if (!isset($burger['cheeses']['bottom'])) {
                $cheeses['bottom'] = (string)"None";
            } else {
                $temp = $this->menu->getCheese($burger['cheeses']['bottom']);
                $cheeses['bottom'] = $temp->name;
                $btotal += $this->menu->getCheese($burger['cheeses']['top'])->price;
            }
            
            // Toppings
            foreach ($burger['toppings'] as $topping) {
                $toppings[] = array('topping' => $this->menu->getTopping($topping)->name);
                $btotal += $this->menu->getTopping($topping)->price;
            }
            
            // Sauces
            foreach ($burger['sauces'] as $sauce) {
                $sauces[] = array('sauce' => $this->menu->getSauce($sauce)->name);
                $btotal += $this->menu->getSauce($sauce)->price;
            }
            // Burger total
            $total += $btotal;
            
            $burgers[] = array('burgerno' => $burgerno++, 'base' => $this->menu->getPatty($burger['patty'])->name, 
                'top' => $cheeses['top'], 'bottom' => $cheeses['bottom'], 'toppings' => $toppings, 'sauces' => $sauces, 
                'btotal' => $btotal);
        }
        $this->data['burgers'] = $burgers;
        // Order total
        $this->data['total'] = $total;
	$this->render();
    }
}
