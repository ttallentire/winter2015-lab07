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
        
        foreach ($this->xml->patties->patty as $patty) {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $this->patty_names[$record->code] = $record;
        }
        
        foreach ($this->xml->cheeses->cheese as $cheese) {
            $record = new stdClass();
            $record->code = (string) $cheese['code'];
            $record->name = (string) $cheese;
            $record->price = (float) $cheese['price'];
            $this->cheese_names[$record->code] = $record;
        }
        
        foreach ($this->xml->toppings->topping as $topping) {
            $record = new stdClass();
            $record->code = (string) $topping['code'];
            $record->name = (string) $topping;
            $record->price = (float) $topping['price'];
            $this->topping_names[$record->code] = $record;
        }
        
        foreach ($this->xml->sauces->sauce as $sauce) {
            $record = new stdClass();
            $record->code = (string) $sauce['code'];
            $record->name = (string) $sauce;
            $record->price = (float) $sauce['price'];
            $this->sauce_names[$record->code] = $record;
        }
    }

    // retrieve a list of patties, to populate a dropdown, for instance
    function patties() {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code) {
        if (isset($this->patty_names[$code])) {
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
        if (isset($this->cheese_names[$code])) {
            return $this->cheese_names[$code];
       } else {
            return null;
       }
    }
    
    function toppings() {
        return $this->topping_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getTopping($code) {
        if (isset($this->topping_names[$code])) {
            return $this->topping_names[$code];
       } else {
            return null;
       }
    }
    
    function sauces() {
        return $this->sauce_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getSauce($code) {
        if (isset($this->sauce_names[$code])) {
            return $this->sauce_names[$code];
       } else {
            return null;
       }
    }
}
