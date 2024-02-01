<?php
session_start();

if(isset($_SESSION['user_login'])){

    $user_login = $_SESSION['user_login'] ;    
    $user_name = $_SESSION['user_name'] ; 
    $user_type = $_SESSION['user_type'] ; 
    
}


unset($_SESSION['user_login']);
unset($_SESSION['user_name']);

session_destroy() ;

?>
<script>window.location="login.php";</script>
