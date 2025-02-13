<?php
session_start();

if(!isset($_SESSION['adminlogin'])){
    header("Location:login");
}
else{
    header("Location:income");
}

?>