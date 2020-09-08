<?php

$host = 'localhost';
$user = 'root';
$pass = 'password';
$dbname = 'db_sop';

try
{
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
} catch( PDOException $e ) {
    die( $e->getMessage() );
}

?>