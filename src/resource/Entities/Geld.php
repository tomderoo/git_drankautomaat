<?php

namespace resource\Entities;

class Geld {
    
    private $id;
    private $waarde;
    private $aantal;
    
    private function __construct($id, $waarde, $aantal) {
        $this->id = $id;
        $this->waarde = $waarde;
        $this->aantal = $aantal;
    }
    
    public static function create($id, $waarde, $aantal) {
        $newDrank = new Geld($id, $waarde, $aantal);
        return $newDrank;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getGeldWaarde() {
        return number_format($this->waarde/100, 2);
    }
    
    public function getRekenWaarde() {
        return $this->waarde;
    }
    
    public function getAantal() {
        return $this->aantal;
    }
    
}