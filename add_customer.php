<?php
session_start();
?>
<?php
include('database.php');
date_default_timezone_set('Asia/Colombo');

if(!isset($_SESSION['adminlogin'])){
    header("Location:login");
}

    $month = date("Y-m");
    $sql = "SELECT * FROM user";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
        $dlist = "";
		while($row = $result->fetch_assoc()){
			$idu = $row['id'];
			$name = $row['user'];
			$type = $row['type'];
            if($type == 1){
                $type = "Admin";
            }
            else{
                $type ="User";
            }
          
            $dlist .= "<tr><td>{$name}</td>
            <td>{$type}</td>
            <td><a href = 'processing?delCustomer={$idu}'>Delete</a></td>
            </tr>";
		}
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

    <title>Add New User - Savor Haven</title>

    <!-- Custom fonts for this template-->
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
        <script src="html2pdf.js"></script>
    <!-- Custom styles for this template-->
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="logo2.png" type="image/x-icon" />
    <link href="admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <h1 class="h3 mb-0 text-gray-800">Add New User</h1>
                    </div>

                    <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    
                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <form action="processing" method = "post">
                            <div class="row form-group">
                                <div class="col">
                                <label for="">Username</label>
                                <input type="text" class="form-control" placeholder="Enter Username" name = "customername">
                                </div>
                                <div class="col">
                                <label for="">Password</label>
                                <input type="password" class="form-control" placeholder="Enter Password" name = "pwd">
                                </div>
                                <div class="col">
                                <label for="">User Type</label>
                                <select class="form-control" name = "type" id="exampleFormControlSelect1">
                                    <option Value = "#">Select Type</option>
                                    <option Value = "0">User</option>
                                    <option Value = "1">Admin</option>
                                </select>
                                </div>
                                
                                <div class="col">
                                <label for=""><br></label>
                                <input type="submit" style = "background:#8f93e7;color:#fff;border:none;" class="form-control" value="Add New User" name = "addCustomer">
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="card-body" id='invoice'>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Type</th>
                                            <th>Action</th>
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

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="admin/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="admin/js/demo/datatables-demo.js"></script>
</body>
<?php
if(isset($_SESSION['successuser'])){
    $successuser = $_SESSION['successuser'];
    $txt = "Successfully Added the {$successuser}";
    echo "<script>
        swal({
        title: 'Success',
            text: '{$txt}',
            icon: 'success',
        });
    </script>";
    unset($_SESSION['successuser']);
}
?>
</html>