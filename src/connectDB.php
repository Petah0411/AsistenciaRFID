<?php
/* Database connection settings */
	$servername = "localhost";
    $username = "root";		//Pon tu usuario de PHPmyAdmin.(Por defecto es "root")
    $password = "";			//Si tu PHPMyadmin tiene una contraseña ponlo aquí.(default is "root")
    $dbname = "rfidattendance";
    
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>