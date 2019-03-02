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
            $first=$_POST['first'];
            $last=$_POST['last'];
            $age=$_POST['age'];
            $gender=$_POST['gender'];
            $phone=$_POST['phone'];
            $premium = $_POST['premium'];
            if ($premium == 'premium')
            {
                $member = new PremiumMember($first, $last, $age, $gender, $phone, $premium);
            }
            else{
                $member = new Member($first, $last, $age, $gender, $phone, $premium);
            }
            $_SESSION['member'] = $member;
            $f3->reroute('set_profile');
        }
    }
    $template = new Template();
    echo $template->render('views/personal.html');
});

//route to set profile webpage
$f3->route('GET|POST /set_profile', function($f3) {
    $member = $_SESSION['member'];
    if(!empty($_POST) && email($_POST['email']))
    {
        $email= $_POST['email'];
        $state= $_POST['state'];
        $seek= $_POST['seek'];
        $bio= $_POST['bio'];

        $member->setEmail($email);
        $member->setState($state);
        $member->setSeeking($seek);
        $member->setBio($bio);

        if (get_class($member) == 'PremiumMember')
        {
            $f3->reroute('interest');
        }
        else {
            print_r($_SESSION['premium']);
            $f3->reroute('summary');
        }

    }

    include('include/states.php');
    $template = new Template();
    echo $template->render('views/set_profile.html');
});
//route to set interest webpage
$f3->route('GET|POST /interest', function($f3) {
    include('include/interests.php');
    $member = $_SESSION['member'];
    $member->setInDoorInterests(array());
    $member->setOutDoorInterests(array());

    if(isset($_POST['submit']))
    {

        if (!empty($_POST['indoor']) && !empty($_POST['outdoor']))
        {
            if (!validIndoor($_POST['indoor']) && !validOutdoor($_POST['outdoor']))
            {
                $f3->reroute('interest');
            }
            $member->setInDoorInterests($_POST['indoor']);
            $member->setOutDoorInterests($_POST['outdoor']);

        }

        else if (!empty($_POST['indoor']))
        {
            if (!validIndoor($_POST['indoor']))
            {
                $f3->reroute('interest');
            }
            $member->setInDoorInterests($_POST['indoor']);
        }
        else if (!empty($_POST['outdoor']))
        {
            if (!validOutdoor($_POST['outdoor']))
            {
                $f3->reroute('interest');
            }
            $member->setOutDoorInterests($_POST['outdoor']);
        }

        $f3->reroute('summary');
    }


    $template = new Template();
    echo $template->render('views/interest.html');
});

//route to set summary webpage
$f3->route('GET|POST /summary', function() {

    //connect to the database
    $db = new Database();
    $db->connect();
    $db->insertMember();

    $template = new Template();
    echo $template->render('views/summary.html');
});

$f3->route('GET|POST /admin', function($f3) {

    //connect to database
    $db = new Database();
    $db->connect();

    //grabs the members from the database
    $members = $db->getMembers();
    $f3->set('members', $members);

    $template = new Template();
    echo $template->render('views/admin.html');
});

$f3->route('GET|POST /admin/@id', function($f3, $params) {

    //gets the id to search through the database
    $id = $params['id'];

    //connect
    $db = new Database();
    $db->connect();

    //grabs the member with the id
    $member = $db->getMember($id);
    $f3->set('member', $member);

    //load a template
    $template = new Template();
    echo $template->render('views/member.html');
});


//Run fat free
$f3->run();