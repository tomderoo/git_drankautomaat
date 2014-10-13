<?php

namespace resource\Entities;

class Drank {
    
    private $id;
    private $name;
    private $price;
    private $image;
    private $number;
    
    private function __construct($id, $name, $price, $image, $number) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->image = $image;
        $this->number = $number;
    }
    
    public static function create($id, $name, $price, $image, $number) {
        $newDrank = new Drank($id, $name, $price, $image, $number);
        return $newDrank;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function getNumber() {
        return $this->number;
    }
}