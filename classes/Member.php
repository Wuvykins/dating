<?php
/**
 * Created by PhpStorm.
 * User: nicalexander
 * Date: 2/14/19
 * Time: 11:33 AM
 */

class Member
{

    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Member constructor.
     * @param $_fname String representation of the first name
     * @param $_lname String representation of the last name
     * @param $_age String representation of the age of the person
     * @param $_gender String representation of the gender
     * @param $_phone String representation of the phone number
     * @param $_email String representation of the email
     * @param $_state String representation of the state
     * @param $seeking String representation of the gender the person is seeking
     * @param $_bio String representation of the bio of the individual
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * @return first name
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @param set $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return last name
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * @param sets $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return age
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param set $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return gender
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param set $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return phone
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param set $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return email
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param set $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return state
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param set $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * @return seeking
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * @param set $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * @return bio
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param set $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }


}