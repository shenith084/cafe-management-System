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

    <title>Add Sales - Savor Haven</title>
    <link rel="icon" href="logo2.png" type="image/x-icon" />

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



@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Product"; }
	td:nth-of-type(2):before { content: "Qty"; }
	td:nth-of-type(3):before { content: "Unit Price"; }
	td:nth-of-type(4):before { content: "Total"; }
	td:nth-of-type(5):before { content: "Action"; }
}
    </style>

</head>

<body id="page-top">
<script src="sweetalert.min.js"></script>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include('sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Navbar -->
            <?php
                include('navbar.php');
            ?>


            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h2 mb-2 text-gray-800">Add Sales</h1>
                    
                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="">
                                <form action = "processing" method = "post">
                                    <div class="form-group">
                                        
                                    </div>
                                    <div class="row form-group">
                                        <div class="col">
                                        <label for="productName">Select Item</label>
                                        <select class="form-control" id="productName" name = "product">
                                            <option value = "">Select Item</option>
                                            <?php echo $dlistp;?>
                                        </select>
                                        </div>
                                        <div class="col">
                                        <label for="Qty">QTY</label>
                                        <input type="number" class="form-control" id = "Qty" name = "qty" placeholder="Enter Quantity">
                                        </div>
                                        
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" name = "saveProduct" style = "background:#8f93e7;border:none;width:40%;">Add to List</button>
                                    </center>
                                </form>
                                <br>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <?php
                                            $sql = "SELECT * FROM tillsales";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0){
                                                $tot = 0;
                                                echo "<thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>qty</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
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
                                                        <td>{$price}</td>
                                                        <td>{$sum}</td>
                                                        <td><a href = 'processing?deleteproduct={$id}'>Delete</a></td>
                                                    </tr>";
                                                }
                                                echo "<tr>
                                                    <th colspan = '3'>Total</th>
                                                    <th>Rs. {$tot}</th>
                                                    </tr>
                                                    </tbody>
                                                    </table>
                                                    <form action = 'processing' method = 'post'>
                                                        <button type = 'button' onclick = 'loadreceipt()' name = 'saveid' class=\"btn btn-primary\" style = \"background:#8f93e7;border:none;\">Add Sale</button>
                                                    </div>
                                                    </form>";
                                            }
                                        ?>
                            </div>
                        </div>
                    </div>

                </div>
                

            </div>
            
        </div>
   

    </div>

    <script>

        function loadreceipt(){
            window.location.href = "receipt.php";
        }
    </script>
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
</body>

</html>