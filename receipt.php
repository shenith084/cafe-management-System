<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');
$fromdate = date("Y-m-d");
if(!isset($_SESSION['adminlogin'])){
    header("Location:login");
}

    $sqlp = "SELECT * FROM product";
	$resultp = $conn->query($sqlp);
	if ($resultp->num_rows > 0){
        $dlistp = "";
		while($rowp = $resultp->fetch_assoc()){
			$idp = $rowp['id'];
			$namep = $rowp['product'];
			$pricep = $rowp['price'];
		
            $dlistp .= "<option value = {$idp}>{$namep}</option>";
		}
	}
    else{
        $dlist = "";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Add Sales - Heavens</title>
    <link rel="icon" href="logo.png" type="image/x-icon" />

    <!-- Custom fonts for this template -->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        th,td{font-weight:bold;font-size:10px;color:#000;}
        img{display:none;}
        @media print {
            body *{visibility:hidden;}
            #content-wrapper, #content-wrapper *{visibility:visible;}
            #content-wrapper{position: absolute;left:0px;top:0px;}
        }
    </style>
</head>

<body id="page-top">
<script src="sweetalert.min.js"></script>
    <div>
        <div id="content-wrapper">
            <div>
                <div>
                    <div class="card-body">
                        <div class="">
                        <center>
                            <img src="toplogo.png"
                            alt="login form" class="img-fluid" style="width:40%; border-radius: 1rem 0 0 1rem;" />
                            <h1 class="h5" style = "font-size:25px;color:#000;"><b>Heavens Cafe</h1>
                            <p style = "font-size:10px; margin: 0 20px;color:#000;">071 043 6363 | Mihinthale, Anuradhapura.</b></p>
                        </center>
                            <table class="table" id="dataTable" cellspacing="0">
                                    <?php
                                        $sql = "SELECT * FROM tillsales";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0){
                                            $tot = 0;
                                            echo "<thead>
                                                    <tr>
                                                        <th>ITEM</th>
                                                        <th>QTY</th>
                                                        <th>TOTAL</th>
                                                    </tr>
                                                </thead>
                                                <tbody>";
                                            while($row = $result->fetch_assoc()){
                                                $id = $row['id'];
                                                $pid = $row['pid'];
                                                $sqlt = "SELECT * FROM product WHERE id = {$pid}";
                                                $resultt = $conn->query($sqlt);
                                                if ($resultt->num_rows > 0){
                                                    while($rowt = $resultt->fetch_assoc()){
                                                        $product = $rowt['product'];
                                                    }
                                                }
                                                
                                                $price = $row['price'];
                                                $qty = $row['qty'];
                                                $sum = $price * $qty;
                                                $tot += $sum;
                                                echo "<tr>
                                                    <td>{$product}</td>
                                                    <td>{$qty}</td>
                                                    <td>Rs. {$sum}</td>
                                                    </tr>";
                                            }
                                            echo "<tr>
                                                <th colspan = '2'>Total</th>
                                                <th>Rs. {$tot}</th>
                                                </tr>
                                                </tbody>
                                                </table>
                                               ";
                                        }
                                    ?>
                            </table>
                            <p style = "font-size:10px;color:#000;font-weight:bold; text-align:center;margin-top:20px;">- Thank you -</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="admin/js/demo/datatables-demo.js"></script>
    <?php
if(isset($_SESSION['successsale'])){
    echo "<script>
        swal({
        title: 'Success',
            text: 'Successfully Added the sale',
            icon: 'success',
        });
    </script>";
    unset($_SESSION['successsale']);
}
?>
<script>
window.onload = function () {
        window.print()
        setTimeout(readdsale, 1000);
        }
    function readdsale(){
        window.location.href = "deletetillsales";
    }
</script>
</body>

</html>