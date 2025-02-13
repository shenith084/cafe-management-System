<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');
$datetoday = date("Y-m-d");
?>
<script src="sweetalert.min.js"></script>
<?php

//Items add to till sale
if(isset($_POST['saveProduct'])){
    $product = $_POST['product'];
    $qty = $_POST['qty'];
    $sqlp = "SELECT * FROM product WHERE id = {$product}";
	$resultp = $conn->query($sqlp);
	if ($resultp->num_rows > 0){
        $dlistp = "";
		while($rowp = $resultp->fetch_assoc()){
			$pricep = $rowp['price'];
		}
	}
	$sqli = "INSERT INTO tillsales(pid,qty,price,date) VALUES({$product},{$qty},{$pricep},'{$datetoday}')";
	if($conn->query($sqli) === TRUE){
        echo "<script>window.history.back()</script>";
	}
}

//Add sale
if(isset($_POST["saveid"])){
    $sqlp = "SELECT * FROM tillsales";
    $resultp = $conn->query($sqlp);
    if ($resultp->num_rows > 0){
        while($rowp = $resultp->fetch_assoc()){
            $pid = $rowp['pid'];
            $price = $rowp['price'];
            $qty = $rowp['qty'];
            $date = $rowp['date'];
            $sqli = "INSERT INTO sales(pid,qty,price,date) VALUES({$pid},{$qty},{$price},'{$date}')";
            if($conn->query($sqli) === TRUE){
            }
        }
        $sqli = "DELETE FROM tillsales";
        if($conn->query($sqli) === TRUE){
            $_SESSION['successsale'] = 0;
            echo "<script>window.history.back()</script>";
        }
    }
}

//Delete Item Before sale
if(isset($_GET['deleteproduct'])){
    $deleteproductid = $_GET['deleteproduct'];
	$sqli = "DELETE FROM tillsales WHERE id = {$deleteproductid}";
	if($conn->query($sqli) === TRUE){
        echo "<script>window.history.back()</script>";
	}
}

//User Login
if(isset($_POST['loginAdmin'])){
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $sql = "SELECT * FROM user WHERE user = '{$username}'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id = $row['id'];
            $pasword = $row['password'];
            $type = $row['type'];
            $verifypwd = password_verify($pwd, $pasword);
            if($verifypwd){
                $_SESSION['adminlogin'] = $id;
                header("Location:income ");
            }
            else{
                $_SESSION['wrongpwd'] = 100;
                echo "<script>window.history.back()</script>";
            }
        }
    }
    else{
        $_SESSION['wronguser'] = 100;
        echo "<script>window.history.back()</script>";
    }
    
}

//User Logout
if(isset($_GET['logoutId'])){
    session_destroy();
    header("Location:main");
}

//Delete User
if(isset($_GET['delCustomer'])){
	
    $delId = $_GET['delCustomer'];
	$sqli = "DELETE FROM user WHERE id = {$delId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Delete Item
if(isset($_GET['delitem'])){
    $delId = $_GET['delitem'];
	$sqli = "DELETE FROM product WHERE id = {$delId}";
	if($conn->query($sqli) === TRUE){
		echo "<script>window.history.back()</script>";
	}
}

//Add User
if(isset($_POST['addCustomer'])){	
    $customername = $_POST['customername'];
    $pwd = $_POST['customername'];
    $type = $_POST['type'];
    $password = password_hash($_POST['pwd'],PASSWORD_DEFAULT);
	$sqli = "INSERT INTO user(user,password,type) VALUES('{$customername}','{$password}',{$type})";
	if($conn->query($sqli) === TRUE){
        $_SESSION['successuser'] = $customername;
        echo "<script>window.history.back()</script>";
	}
    
}

//Add Item
if(isset($_POST['addProduct'])){
    $productname = $_POST['productname'];
    $price = $_POST['price'];
	$sqli = "INSERT INTO product(product,price) VALUES('{$productname}',{$price})";
    $password = password_hash($_POST['pwd'],PASSWORD_DEFAULT);
	if($conn->query($sqli) === TRUE){
        echo "<script>window.history.back()</script>";
	}
}

//Edit Item Price
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $idu = $row['id'];
        $tid = "edititem" . $idu;
        if(isset($_POST["{$tid}"])){
            $itemidu = $_POST["item{$idu}"];
            $sqli = "UPDATE product SET price = {$itemidu} WHERE id = {$idu}";
            if($conn->query($sqli) === TRUE){
            }
        }
    }
    echo "<script>window.history.back()</script>";
}
		
    
?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>