<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');

if(!isset($_SESSION['adminlogin'])){
    header("Location:login");
}
if(isset($_POST["sbmitBtn"])){
    $date = $_POST["monthselect"];
}
else{
    $date = date("Y-m-d");
}

$sql = "SELECT price, sum(qty) as sqty, pid FROM sales WHERE date = '{$date}' GROUP BY pid";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    $tot = 0;
    $dlist = "";
    while($row = $result->fetch_assoc()){
        $sqty = $row['sqty'];
        $price = $row['price'];
        $pid = $row['pid'];
        $sum = $price * $sqty;
        $sqlp = "SELECT * FROM product WHERE id = {$pid}";
        $resultp = $conn->query($sqlp);
        if ($resultp->num_rows > 0){
            while($rowp = $resultp->fetch_assoc()){
                $product = $rowp['product'];
            }
        }
        $tot += $sum;
        $dlist .= "<tr><td>{$product}</td><td>{$sqty}</td><td>Rs. {$price}</td><td>Rs. {$sum}</td></tr>";
    }
    $dlist .= "<tr><th colspan = '3'>Total</th><th>Rs. {$tot}</th></tr>";
}
else{
    $dlist = "";
}
?>
<script src="sweetalert.min.js"></script>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Income - Savor Haven</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <link rel="icon" href="logo1.png" type="image/x-icon" />
        <!-- Custom styles for this template-->
        <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
        <link rel="icon" href="logo1.png" type="image/x-icon" />
        <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <noscript>
      <style type='text/css'>
        [data-aos] {
            opacity: 1 !important;
            transform: translate(0) scale(1) !important;
        }
      </style>
    </noscript>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include('sidebar.php');
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Navbar -->
                <?php
                    include('navbar.php');
                ?>
               

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daily Income
                            <a href="monthlyincome" class = "btn btn-primary ml-3" style = "background:#8f93e7;">View Monthly Income</a>
                        </h1>
                    </div>

                    <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    
                    <!-- DataTales  -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <form action="#" method = "post">
                            <div class="row">
                                <div class="col">
                                <label for="">Select Date</label>
                                <input type="date" class="form-control" placeholder="select month" name = "monthselect">
                                </div>
                                <div class="col">
                                <label for=""><br></label>
                                <input type="submit" style = "background:#8f93e7;color:#fff;border:none;" class="form-control" value="Search" name = "sbmitBtn">
                                </div>
                                <div class="col">
                                <label for=""><br></label>
                                </div>
                                <?php
                                if($type == 1){
                                ?>
                                <div class="col">
                                    <label for=""><br></label>
                                    <button type = "button" style = "background:#8f93e7;color:#fff;border:none;" class="form-control" id = "download">Download</button>
                                </div>
                                <?php    
                                }
                                ?>
                            </div>
                    </form>
                    <center>
                        <h4><?php echo $date; ?></h4>
                    </center>
                        </div>
                        <div class="card-body" id='invoice'>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>QTY</th>
                                            <th>unit price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php echo $dlist;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

                </div>

            </div>
            
        </div>

    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="admin/js/demo/datatables-demo.js"></script>

    <script>
        window.onload = function () {
            //console.log("invoice");
            document.getElementById("download")
            .addEventListener("click", () => {
                const invoice = this.document.getElementById("invoice");
                console.log("invoice");
                var opt = {
                    margin: 0.2,
                    filename: '<?php echo $date;?> Daily Income.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().from(invoice).set(opt).save();
            })
        }
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</body>
</html>