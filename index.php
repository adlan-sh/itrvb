<?php

abstract class Product
{
    protected float $price;

    public abstract function countPrice();
}

class RetailProduct extends Product
{
    private int $count;

    public function countPrice(): float
    {
        return $this->price * $this->count;
    }
}

class DigitalProduct extends Product
{
    public function countPrice(): float
    {
        return $this->price / 2;
    }
}

class WeightProduct extends Product
{
    private float $weight;

    public function countPrice(): float
    {
        return $this->price * $this->weight / 1000;
    }
}
