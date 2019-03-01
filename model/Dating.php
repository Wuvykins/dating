<?php
/**
 * Created by PhpStorm.
 * User: Nic Alexander
 * Date: 2/28/2019
 * Time: 6:52 PM
 */

//CREATE TABLE members( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, fname VARCHAR(50), lname VARCHAR(50), age INT,
// gender VARCHAR(10), phone VARCHAR(10), email VARCHAR(50), state VARCHAR(20), seeking VARCHAR(1), bio VARCHAR(255),
// premium Tinyint, image VARCHAR(50), interests VARCHAR(137) );

class Database
{

    function connect()
    {
        require '/home/nalexand/config.php';

        try{
            //instantiate a database object, I had to put it into a global because insert member wouldnt have access to
            //it if I hadn't
            $GLOBALS[dbh] = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            echo 'connected to database!';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function insertMember()
    {
        //had to create this field so that I could define the query with the global I created in connect
        global $dbh;

        //grabbing member from the session array in order to use the members getters
        $member = $_SESSION['member'];

        $fname = $member->getFname();
        $lname = $member->getLname();
        $age = $member->getAge();
        $gender = $member->getGender();
        $phone = $member->getPhone();
        $email = $member->getEmail();
        $state = $member->getState();
        $seeking = $member->getSeeking();
        $bio = $member->getBio();
        $image = "";

        //If member is premium it returns a 1 and if its not it returns 0
        $premium = function($member)
                    {
                        if (get_class($member)== 'PremiumMember')
                        {
                            return 1;
                        }
                        else
                        {
                            return 0;
                        }
                    };

        //I need to get the interests from the getters but only if the member is a premium member
        $interests = function($member)
                {
                    if (get_class($member)== 'PremiumMember')
                    {
                        if(!empty($member->getInDoorInterests()) && !empty($member->getOutDoorInterests()))
                        {
                            return implode(', ', $member->getInDoorInterests()) . ', ' . implode(', ', $member->getOutDoorInterests());
                        }
                        else if(!empty($member->getInDoorInterests()))
                        {
                            return implode(', ', $member->getInDoorInterests());
                        }
                        else if(!empty($member->getOutDoorInterests()))
                        {
                            return implode(', ', $member->getOutDoorInterests());
                        }
                    }
                    //member isnt premium
                    else
                    {
                        return null;
                    }
                };


        //define the query
        $sql = "INSERT INTO datingMembers
            (fname, lname, age, gender, phone, email, state, seeking, bio, premium, image, interests)
            VALUES(:fname, :lname, :age, :gender, :phone, :email, :state, :seeking, :bio, :premium, :image, :interests)";

        //Prepare the statement
        $statement = $dbh->prepare($sql);

        //bind the parameters
        $statement->bindValue(':fname', $fname, PDO::PARAM_STR);
        $statement->bindValue(':lname', $lname, PDO::PARAM_STR);
        $statement->bindValue(':age', $age, PDO::PARAM_STR);
        $statement->bindValue(':gender', $gender, PDO::PARAM_STR);
        $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':state', $state, PDO::PARAM_STR);
        $statement->bindValue(':seeking', $seeking, PDO::PARAM_STR);
        $statement->bindValue(':bio', $bio, PDO::PARAM_STR);
        $statement->bindValue(':premium', $premium, PDO::PARAM_STR);
        $statement->bindValue(':image', $image, PDO::PARAM_STR);
        $statement->bindValue(':interests', $interests, PDO::PARAM_STR);


        //Execute
        $statement->execute();
        $id = $dbh->lastInsertId();
        echo "<p>Pet $id inserted successfully.</p>";

        //brandon found this and posted it in the discussion so hopefully its ok that I "plagiarized"
        $arr = $statement->errorInfo();
        if(isset($arr[2])) {
            print_r($arr[2]);
        }

    }

    function getMembers()
    {
        global $dbh;
        $sql = "SELECT * FROM members";
        $statement = $dbh->prepare($sql);
        $statement->execute();

        $arr = $statement->errorInfo();
        if(isset($arr[2])) {
            print_r($arr[2]);
        }

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function getMember($id)
    {

    }
}

