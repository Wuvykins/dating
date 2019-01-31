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
    if(isset($_POST))
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
        if ($_POST['gender']=='male')
        {
            $f3->set('male', "checked='checked'");
            $f3->set('female', "");
        }
        elseif ($_POST['gender']=='female')
        {
            $f3->set('male', "");
            $f3->set('female', "checked='checked'");
        }
    }
    $template = new Template();
    echo $template->render('views/personal.html');
});

//route to set profile webpage
$f3->route('GET|POST /set_profile', function($f3) {
    if(!empty($_POST) && email($_POST['email']))
    {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seek'] = $_POST['seek'];
        $_SESSION['bio'] = $_POST['bio'];
        $f3->reroute('interest');
    }
    if ($_POST['seek']=='male')
    {
        $f3->set('male', "checked='checked'");
        $f3->set('female', "");
    }
    elseif ($_POST['seek']=='female')
    {
        $f3->set('male', "");
        $f3->set('female', "checked='checked'");
    }
    include('include/states.php');
    $template = new Template();
    echo $template->render('views/set_profile.html');
});
//route to set interest webpage
$f3->route('GET|POST /interest', function($f3) {
    if(!empty($_POST))
    {
        $_SESSION['interests[]'] = $_POST['indoor[]'];
        $f3->reroute('summary');
    }
    $f3->reroute('summary');
    include('include/interests.php');
    $template = new Template();
    echo $template->render('views/interest.html');
});

//route to set summary webpage
$f3->route('GET|POST /summary', function() {
    if(!empty($_POST))
    {
        //$_SESSION['email'] = $_POST['email'];

    }

    $template = new Template();
    echo $template->render('views/summary.html');
});


//Run fat free
$f3->run();