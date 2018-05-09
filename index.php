<!-- Create a DB entity class with autosave
- Use an old DB exercise in sequel pro
- Create a php class
- Pass it a PDO script that fetches a class or aray of objects from DB
- Populate class with properties from DB
    - each property is a DB column
- Create a destruct method that autosaves the object properties to the DB
-->

<?php

class Adult {

    // set up variables you want in your class
    public $id;
    public $name;
    public $DOB;
    public $gender;
    public $db;

    // assigns db connection to $db variable on object instantiation
    public function __construct() {
        $this->db = new PDO('mysql:host=127.0.0.1; dbname=MySQLTestDb', 'root');
    }
    // prepares and executes an update SQL statement on object destruct (when script ends or unset($Adult) runs)
    public function __destruct() {
        // to update all names you'd set: "WHERE 'id' = $id". $id is the id of the object that's been assigned from the DB.
        $query = $this->db->prepare("UPDATE `adults` SET `name` = 'gertrude' WHERE `id` = 1 ;");
        $query->execute();
    }
}
// creates new db connection (fetches data in assoc array)
$db = new PDO('mysql:host=127.0.0.1; dbname=MySQLTestDb', 'root');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

function getAdultsData ($db) {
    $query = $db->prepare("SELECT `adults`.`id`, `adults`.`name`, `adults`.`DOB`, `adults`.`gender` FROM `adults`;");
    $query->setFetchMode(PDO::FETCH_CLASS, 'Adult');
    $query->execute();
    return $query->fetch();
}

$result = getAdultsData($db);
