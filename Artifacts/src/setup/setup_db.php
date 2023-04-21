<?php

include '../dblogin.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);



//Creating table for users

$sql = "CREATE TABLE users (
	uname VARCHAR(50) UNIQUE NOT NULL,
	pwd VARCHAR(100) NOT NULL,
	id int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
)";


if ($conn->query($sql) === TRUE) {
  print "Table Users created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE messages (
	author int NOT NULL,
  	msg_text VARCHAR(144) NOT NULL,
  	id int NOT NULL AUTO_INCREMENT,
  	PRIMARY KEY (id)
)";

if ($conn->query($sql) === TRUE) {
  print "Table Messages created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE followers (
	follower int NOT NULL,
	followed int NOT NULL,
	id int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
)";

if ($conn->query($sql) === TRUE) {
  print "Table followers created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE likes (
	user int NOT NULL,
	message int NOT NULL,
	id int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (id)
)";

if ($conn->query($sql) === TRUE) {
  print "Table likes created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}




