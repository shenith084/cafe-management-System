<?php
session_start();
?>
<?php
include('database.php');
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
            header("Location:addsales");
        }
    }
    ?>