<?php
//Turn on error reporting
ini_set('display_errors' , 1);
error_reporting(E_ALL);

//Require
require_once('vendor/autoload.php');
session_start();

//create an instance of the Base class (instantiateing fat free
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);
require_once("model/personal_validation.php");
//define a default route
$f3->route('GET /', function() {

    $view = new View();
    echo $view->render('views/home.html');
});

//route to personal webpage
$f3->route('POST /personal', function($f3) {
    if(!empty($_POST))
    {
        if (first($_POST['first']) && last($_POST['last']) && age($_POST['age']) && number($_POST['phone']))
        {
            $_SESSION['first']=$_POST['first'];
            $_SESSION['last']=$_POST['last'];
            $_SESSION['age']=$_POST['age'];
            $_SESSION['gender']=$_POST['gender'];
            $_SESSION['phone']=$_POST['phone'];
            $f3->reroute('set_profile');
        }
    }
    $template = new Template();
    echo $template->render('views/personal.html');
});

//route to set profile webpage
$f3->route('GET /set_profile', function() {

    include('include/states.php');
    $template = new Template();
    echo $template->render('views/set_profile.html');
});


//Run fat free
$f3->run();