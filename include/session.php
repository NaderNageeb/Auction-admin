<?php


if(!isset($_SESSION['user_login']))
    {
?>
<script>window.location="./login.php";</script>
<?php 
    }else{
        $user_login = $_SESSION['user_login'] ;    
        $user_name = $_SESSION['user_name'] ;   
        echo $user_type = $_SESSION['user_type'] ; 
  
    }

    //print_r($_SESSION) ;
?>
