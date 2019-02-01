<?php
/**
 * Created by PhpStorm.
 * User: nicalexander
 * Date: 1/28/19
 * Time: 12:27 PM
 */

function first($first)
{
    return ctype_alpha($first);
}

function last($last)
{
    return ctype_alpha($last);
}

function age($age)
{
    return ctype_alnum($age) && $age>= 18;
}

function number($phone)
{
    return (preg_match("/^[0-9]{10}$/", $phone));
}

function email($email)
{
    return strpos($email, '@') !== false && strpos(strtolower($email), '.com') !== false;
}
function indoor($indoor)
{

}
$f3->set('validEmail', email($_POST['email']));
$f3->set('validFirst', first($_POST['first']));
$f3->set('validLast', last($_POST['last']));
$f3->set('validAge', age($_POST['age']));
$f3->set('validNum', age($_POST['phone']));