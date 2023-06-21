<?php

class ProductBuilder {
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function setName($name) {
        $this->product->setName($name);
        return $this;
    }

    public function setPrice($price) {
        $this->product->setPrice($price);
        return $this;
    }

    public function setImage($image) {
        $this->product->setImage($image);
        return $this;
    }

    public function build() {
        return $this->product;
    }
}

?>