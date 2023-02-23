<?php

// controller/controller.php

class Controller
{
    private $_f3; // Fat-Free router

    function __construct($_f3)
    {
        $this->_f3 = $_f3;
    }

    function home()
    {
        $view = new Template();
        echo $view->render("views/diner-home.html");
    }
}