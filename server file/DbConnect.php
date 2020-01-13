<?php
$servername = "localhost";
$username = "id12082469_admin";
$password = "admin";
$database = "id12082469_homeo";


//creating a new connection object using mysqli 
$conn = new mysqli($servername, $username, $password, $database);

//if there is some error connecting to the database
//with die we will stop the further execution by displaying a message causing the error 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
