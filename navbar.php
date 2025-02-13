<?php
if(isset($_SESSION['adminlogin']) || isset($_SESSION['login'])){
    if(isset($_SESSION['adminlogin'])){
        $id = $_SESSION['adminlogin'];
    }
    else{
        $id = $_SESSION['login'];
    }
}

?>
<html>
    <head>
        <style>
            nav img{
                width:120px;
            }
        </style>
    </head>
    <body>
<nav class="navbar navbar-expand navbar-light bg-white Navbar mb-4 static-top shadow">

    <img src="toplogo1.png" alt="logo">

    <!-- Navbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <li>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="processing?logoutId=1"role="button"
            aria-haspopup="true" aria-expanded="false">
                
                <i class="fas fa-sign-out-alt ml-2 fa-sm fa-fw mr-2 text-gray-400" style = 'color:#fe0000;'></i>
            </a>
        </li>
    </ul>

</nav>
