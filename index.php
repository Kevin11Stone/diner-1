<?php

// order1 route -> views/order-form1.html
// summary route -> views/order-summary.html

//This is my controller

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);


//var_dump($_SESSION);

//Require files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validate.php');
//require_once('classes/order.php');

//Start a session, must start Session after requiring auto-load files
session_start();

// class test code
//$myOrder = new Order();
//$myOrder->setFood("tacos");
//$myOrder->setMeal("salsa");
//$myOrder->setCondiments("taquitos");
//var_dump($myOrder);

/*
$food1 = "tacos";
$food2 = "        ";
$food3 = "x";
echo validFood($food1) ? "valid" : "not valid";
echo validFood($food2) ? "valid" : "not valid";
echo validFood($food3) ? "valid" : "not valid";
*/
//var_dump(getMeals());
//var_dump(getCondiments());

//Instantiate F3 Base class
$f3 = Base::instance();

//Define a default route (328/diner)
$f3->route('GET /', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/diner-home.html");

});

//Define a breakfast route (328/diner/breakfast)
$f3->route('GET /breakfast', function() {

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/breakfast.html");

});

//Define an order1 route (328/diner/order1)
$f3->route('GET|POST /order1', function($f3) {

    //var_dump($_POST);
    //["food"]=> string(5) "pizza" ["meal"]=> string(9) "breakfast" }


    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // create object. This object will be stored in the Session array
        $newOrder = new Order();


        //Move food from POST array to SESSION array
        $food = trim($_POST['food']);
        if (Validate::validFood($food)) {
            $newOrder->setFood($food);
            //$_SESSION['food'] = $food; we're putting into object now instead of the Session array
        }
        else {
            $f3->set('errors["food"]',
                'Food must have at least 2 chars');
        }

        //Validate the meal
        $meal = $_POST['meal'];
        if (Validate::validMeal($meal)) {
            $newOrder->setMeal($meal);
            //$_SESSION['meal'] = $meal;
        }
        else {
            $f3->set('errors["meal"]',
                'Meal is invalid');
        }

        //Redirect to summary page
        //if there are no errors
        if (empty($f3->get('errors'))) {

            // put newOrder object in the Session array
            $_SESSION['newOrder'] = $newOrder;
            $f3->reroute('order2');
        }
    }

    //Add meals to F3 hive
    $f3->set('meals', DataLayer::getMeals());

    //Instantiate a view
    $view = new Template();
    echo $view->render('views/order-form1.html');

});

//Define an order2 route (328/diner/order2)
$f3->route('GET|POST /order2', function($f3) {

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // assign condiments to newOrder object
        $condimentString = implode(", ",$_POST['conds']);
        $_SESSION['newOrder']->setCondiments($condimentString);

        //Move data from POST array to SESSION array
        //$_SESSION['conds'] = implode(", ",$_POST['conds']);  We're now adding directly to object instead of Session

        //Redirect to summary page
        $f3->reroute('summary');
    }

    //Add condiments to the hive
    $f3->set('condiments', DataLayer::getCondiments());

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-form2.html");

});

//Define a summary route (328/diner/summary)
$f3->route('GET /summary', function() {
    //echo var_dump($_POST);

    // write to database here

    //Instantiate a view
    $view = new Template();
    echo $view->render("views/order-summary.html");

    // destroy Session array
    session_destroy();

});

//1. Help each other get caught up
//2. Define a lunch route + page
//3. Add an image to breakfast and/or lunch


//Run Fat Free
$f3->run();
