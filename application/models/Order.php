<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model {

    protected $xml = null;
    protected $order = array();

    // Constructor
    public function __construct() {
        parent::__construct();
    }
    
    function makeOrder($path) {
        $this->xml = simplexml_load_file(DATAPATH . $path);
        
        $type = (string)$this->xml->order['type'];
        $customer = (string)$this->xml->customer;
        $burgers = array();
        
        // build the list of burgers - approach 1
        foreach ($this->xml->burger as $burger) {
            $burgers[] = array('patty' => (string) $burger->patty['type'], 
                'cheeses' => array('top' => (string) $burger->cheeses['top'], 'bottom' => (string) $burger->cheeses['bottom']),
                'toppings' => array((string) $burger->topping['type']), 'sauces' => array((string)$burger->sauce['type']));
        }
        
        $this->order[$path] = array('type' => $type, 'customer' => $customer,
            'burgers' => $burgers);         
    }
    
    function orders() {
        return $this->order;
    }
    
    function getOrder($path) {
        if (isset($this->order[$path])) {
            return $this->order[$path];
       } else {
            return null;
       }
    }
}
