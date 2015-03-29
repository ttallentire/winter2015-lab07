<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model {

    var $xml = null;
    var $orders = array();

    // Constructor
    public function __construct() {
        parent::__construct();
    }
    
    function makeOrder($path) {
        $this->xml = simplexml_load_file(DATAPATH . $path);
        $type = (string)$this->xml['type'];
        $customer = (string)$this->xml->customer;
        $burgers = array();
        
        // build the list of burgers - approach 1
        foreach ($this->xml->burger as $burger) {
            $toppings = array();
            $sauces = array();
            foreach($burger->topping as $topping) {
                $toppings[] = (string)$topping['type'];
            }
            foreach($burger->sauce as $sauce) {
                $sauces[] = (string)$sauce['type'];
            }
            $burgers[] = array('patty' => (string) $burger->patty['type'], 
                'cheeses' => array('top' => (string) $burger->cheeses['top'], 'bottom' => (string) $burger->cheeses['bottom']),
                'toppings' => $toppings, 'sauces' => $sauces);
        }
        
        $this->orders[$path] = array('type' => $type, 'customer' => $customer,
            'burgers' => $burgers);
    }
    
    function orders() {
        return $this->orders;
    }
    
    function getOrder($path) {
        $this->makeOrder($path);
        return $this->orders[$path];
    }
}
