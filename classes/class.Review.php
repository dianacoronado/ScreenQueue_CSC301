<?php
class Review
{
    public $id = 0;
    public $value=0;
    public $movieID =0;
    function __construct()
    {
        global $database;
        $this->database = $database;
    }
    
    function set($property,$value)
    {
        $this->{$property} = $value;
        return $this;
    }
    
    function delete()
    {
        $sql = file_get_contents('sql/deleteReview.sql');
        $params = array(
        'reviewid' => $this->id;
        );
        
        $statement = $database->prepare($sql);
        statement->execute($params);
    }
    
    function save()
    {
        $params = array(
        'value' => $this->value,
        'movieid' => $this->movieID);
        
        if($this->id==0)
        {
            $sql = file_get_contents('sql/saveReview.sql');
        }
        else
        {
            $params['reviewid'] = $this->id;
            $sql = file_get_contents('sql/updateReview.sql');
        }
        
        $statement = $database->prepare($sql);
        statement->execute($params);
    }
}
?>