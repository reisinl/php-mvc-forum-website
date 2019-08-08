<?php
$host = 'localhost' ;
$dbUser ='root';
$dbPass ='';
$dbName ='forum_language';
 
$db = new MySQL( $host, $dbUser, $dbPass, $dbName ) ;
$db->selectDatabase();
?>
