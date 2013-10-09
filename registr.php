<?php 
session_start() ; 
$username = $_POST['username'] ; 
$password = $_POST['password'] ; 
$repassword = $_POST['repassword'] ; 
$email = $_POST['email'] ; 
    if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])){
        echo "Логин может состоять только из букв английского алфавита" ;
    } 
    if (strlen($_POST['username'] < 5 or strlen($_POST['username'] > 30))) {
        
    }



 ?>