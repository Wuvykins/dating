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
function validIndoor($indoor)
{
    foreach ($indoor as $interest)
    {
        if(!in_array($interest, $_SESSION['outdoor']))
        {
            return false;
        }
    }
    return true;
}
function validOutdoor($outdoor)
{
    foreach ($outdoor as $interest)
    {
        if(!in_array($interest, $_SESSION['outdoor']))
        {
            return false;
        }
    }
    return true;
}