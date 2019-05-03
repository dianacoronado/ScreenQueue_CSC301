<?php
class User
{
    private $id = 0;
    private $username;
    private $firstName;
    private $lastName;
    private $password;
    private $database;

    function __construct($database)
    {
        $this->database = $database;
    }

    function set($property,$value)
    {
        $this->{$property} = $value;
        return $this;
    }

    function get($key)
    {
        return $this->$key;
    }

    function login($username,$password)
    {
        // Query records that have usernames and passwords that match those in the users  table
        $sql = file_get_contents('sql/attemptLogin.sql');
        $params = array(
            'username' => $username,
            'password' => $password,  		
        );

        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        // If $users is not empty
        if(!empty($users)) {
            // Set $user equal to the first result of $users
            $user = $users[0];
            // Set a session variable with the user received
            $_SESSION['userid'] =  $user['userid'];

            // Redirect to the profile.php file
            header('location: index.php');


        }
        else
        {
            print_r("Unabe to log in");
        }
    }

    function getProperties($id)
    {
        // Query records that have usernames and passwords that match those in the users  table
        $sql = file_get_contents('sql/getUser.sql');
        $params = array(
            'userid' => $id 		
        );

        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        // If $users is not empty
        if(!empty($users)) {
            // Set $user equal to the first result of $users
            $user = $users[0];

            //Set the object variables to the items on the database
            $this->username= $user['username'];
            $this->password = $user['password'];
            $this->firstName = $user['firstname'];
            $this->lastName = $user['lastname'];
            $this->id = $user['userid'];

        }

    }

    function getWatchlists()
    {
        $sql = file_get_contents('sql/getUserWatchlists.sql');
        $params = array('userid' => $this->id);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getReviews()
    {
        $sql = file_get_contents('sql/getUserReviews.sql');
        $params = array('userid' => $this->id);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    function getWatchlistsForMovie($movieid)
    {
        $sql = file_get_contents('sql/getUserWatchlist.sql');
        $params = array('userid' => $this->id,
                        'movieid' => $movieid);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getWatchlistItems($watchlistid)
    {
        $sql = file_get_contents('sql/getUserWatchlistItems.sql');
        $params = array('userid' => $this->id,
                        'watchlistid' => $watchlistid);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getWatchlist($watchlistid)
    {
        $sql = file_get_contents('sql/getWatchlist.sql');
        $params = array('watchlistid' => $watchlistid,
                       'userid' => $this->id);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function getReviewForMovie($movieid)
    {
        $sql = file_get_contents('sql/getUserReview.sql');
        $params = array('userid' => $this->id,
                        'movieid' => $movieid);
        $statement = $this->database->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    function delete()
    {
        $sql = file_get_contents('sql/deleteUser.sql');
        $params = array(
            'userid' => $this->id
        );

        $statement = $this->database->prepare($sql);
        $statement->execute($params);
    }


    function save()
    {
        $params = array(
            'username' => $this->username,
            'password' => $this->password,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName);

        if($this->id==0)
        {
            $sql = file_get_contents('sql/insertUser.sql');
        }
        else
        {
            $params['userid'] = $this->id;
            $sql = file_get_contents('sql/updateUser.sql');
        }


        $statement = $this->database->prepare($sql);
        $statement->execute($params);
    }
}
?>