<?php
/**
 * Order class represents an order from my diner
 * @Kevin Stone
 */
class Order
{
    private $_food;
    private $_meal;
    private $_condiments;


    function __construct()
    {
        $this->_food = "";
        $this->_meal = "";
        $this->_condiments = "";
    }

    /**
     * getFood returns the food item ordered
     * @returns string
     */
    public function getFood()
    {
        return $this->_food;
    }
    /**
     * setFood sets the food item
     * @param string
     */
    public function setFood($food)
    {
        $this->_food = $food;
    }

    /**
     * getMeal
     */
    public function getMeal()
    {
        return $this->_meal;
    }
    public function setMeal($meal)
    {
        $this->_meal = $meal;
    }

    /**
     * getCondiments
     */
    public function getCondiments()
    {
        return $this->_condiments;
    }
    public function setCondiments($condiments)
    {
        $this->_condiments = $condiments;
    }



}