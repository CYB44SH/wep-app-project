<?php
define('DBHOST', 'localhost');
define('DBNAME', 'lotuscare_new');
define('DBUSER', 'root');
define('DBPASS', '');

define('DBCONNSTRING', "mysql:host=".DBHOST.";dbname=".DBNAME);



try {
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>