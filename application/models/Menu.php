<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patty_names = array();
    protected $cheese_names = array();
    protected $topping_names = array();
    protected $sauce_names = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');

        // build the list of patties - approach 1
        foreach ($this->xml->patties->patty as $patty) {
            $this->patty_names[(string) $patty['code']] = (string) $patty;
        }

        foreach ($this->xml->cheeses->cheese as $cheese) {
            $this->cheese_names[(string) $cheese['code']] = (string) $cheese;
        }
        
        foreach ($this->xml->toppings->topping as $topping) {
            $this->topping_names[(string) $topping['code']] = (string) $topping;
        }
        
        foreach ($this->xml->sauces->sauce as $sauce) {
            $this->sauce_names[(string) $sauce['code']] = (string) $sauce;
        }
    }

    // retrieve a list of patties, to populate a dropdown, for instance
    function patties() {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code) {
        if (isset($this->$patty_names[$code])) {
            return $this->patty_names[$code];
       } else {
            return null;
       }
    }

    function cheeses() {
        return $this->cheese_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getCheese($code) {
        if (isset($this->$cheese_names[$code])) {
            return $this->cheese_names[$code];
       } else {
            return null;
       }
    }
    
    function toppings() {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getTopping($code) {
        if (isset($this->$topping_names[$code])) {
            return $this->topping_names[$code];
       } else {
            return null;
       }
    }
    
    function sauces() {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getSauce($code) {
        if (isset($this->$sauce_names[$code])) {
            return $this->sauce_names[$code];
       } else {
            return null;
       }
    }
}
