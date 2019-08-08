<?php
include_once 'MySQLDB.php';
require 'db.php';

//  create the database again
$db->createDatabase();
// select the database
$db->selectDatabase();

// drop the tables
$sql = "drop table if exists reply";
$result = $db->query($sql);

$sql = "drop table if exists post";
$result = $db->query($sql);

$sql = "drop table if exists user_info";
$result = $db->query($sql);

$sql = "drop table if exists follow";
$result = $db->query($sql);

$sql = "drop table if exists user";
$result = $db->query($sql);


// create the tables
$sql = "CREATE TABLE `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `login_id` varchar(45) NOT NULL,
    `login_pwd` varbinary(100) NOT NULL,
    `create_date` datetime NOT NULL,
    `last_login` datetime DEFAULT NULL,
    `err_cnt` int(11) DEFAULT '0',
    `is_locked` int(11) DEFAULT '0',
    PRIMARY KEY (`id`),
   UNIQUE KEY `login_id_UNIQUE` (`login_id`)
  ) AUTO_INCREMENT = 10001";

$result = $db->query($sql);
if ( $result )
{
    echo 'the user table was added<br>';
}
else
{
    echo 'the user table was not added<br>';
}

$sql = "CREATE TABLE `user_info` (
    `user_id` INT NOT NULL,
    `user_firstnm` VARCHAR(45) NOT NULL,
    `user_lastnm` VARCHAR(45) NOT NULL,
    `user_email` VARCHAR(45) NOT NULL,
    `user_image` VARCHAR(45) NULL,
    PRIMARY KEY (`user_id`),
    CONSTRAINT `user_id`
      FOREIGN KEY (`user_id`)
      REFERENCES `user` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)";
							 
//  execute the sql query
$result = $db->query($sql);
if ( $result )
{
   echo 'the user_info table was added<br>';
}
else
{
   echo 'the user_info table was not added<br>';
}

 
$sql = "CREATE TABLE `follow` (
    `follow_id` int(11) NOT NULL,
    `follower_id` int(11) DEFAULT NULL,
    UNIQUE KEY `id_UNIQUE` (`follow_id`,`follower_id`),
    KEY `follow_user_id` (`follower_id`),
    CONSTRAINT `follow_id` FOREIGN KEY (`follow_id`) REFERENCES `user` (`id`),
    CONSTRAINT `follow_user_id` FOREIGN KEY (`follower_id`) REFERENCES `user` (`id`)
  )";
$result = $db->query($sql);
if ( $result )
{
   echo 'the follow table was added<br>';
}
else
{
   echo 'the follow table was not added<br>';
}

$sql = "CREATE TABLE `post` (
    `post_id` int NOT NULL AUTO_INCREMENT,
    `post_title` varchar(45) NOT NULL,
    `post_content` varchar(250) NOT NULL,
    `post_attach` varchar(45) DEFAULT NULL,
    `post_user_id` int(11) NOT NULL,
    `post_time` datetime NOT NULL,
    `post_view` int DEFAULT NULL,
    `post_like` int DEFAULT NULL,
    `post_dislike` int DEFAULT NULL,
    PRIMARY KEY (`post_id`),
    KEY `post_user_id_idx` (`post_user_id`),
    CONSTRAINT `post_user_id` FOREIGN KEY (`post_user_id`) REFERENCES `user` (`id`)
  )";
															
//  execute the sql query
$result = $db->query($sql);
if ( $result )
{
   echo 'the post table was added<br>';
}
else
{
   echo 'the post table was not added<br>';
}

$sql = "CREATE TABLE `reply` (
    `reply_id` int NOT NULL AUTO_INCREMENT,
    `post_id` int DEFAULT NULL,
    `reply_user_id` int DEFAULT NULL,
    `reply_content` varchar(250) DEFAULT NULL,
    `reply_date` datetime DEFAULT NULL,
    `reply_attach` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`reply_id`),
    KEY `reply_user_id_idx` (`reply_user_id`),
    CONSTRAINT `reply_user_id` FOREIGN KEY (`reply_user_id`) REFERENCES `user` (`id`)
  ) ";
//  execute the sql query
$result = $db->query($sql);
if ( $result )
{
   echo 'the reply table was added<br>';
}
else
{
   echo 'the reply table was not added<br>';
}


?>
<html>
<body>
<br /><br />
<a href="index.php">Return To Index</a>
</body>
</html>
