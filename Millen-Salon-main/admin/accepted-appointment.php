<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the session is set, otherwise redirect to logout
if (strlen($_SESSION['bpmsaid']) == 0) {
  header('location:logout.php');
} else {

  // SQL query to fetch only accepted appointments (where Status = 'Accepted')
  $ret = mysqli_query($con, "SELECT * FROM tblappointment WHERE Status='Accepted'");

  // Initialize counter for row numbering
  $cnt = 1;
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Millen Hair Salon || Accepted Appointment</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- Font Awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- JS -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">

</head>

<body class="cbp-spmenu-push">
    <div class="main-content">

        <!-- Left Sidebar Navigation -->
        <?php include_once('includes/sidebar.php'); ?>

        <!-- Header -->
        <?php include_once('includes/header.php'); ?>

        <!-- Main Content -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Accepted Appointment</h3>

                    <div class="table-responsive bs-example widget-shadow">
                        <h4>Accepted Appointment:</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Appointment Number</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Branch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the accepted appointments and display them
                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $cnt; ?></th>
                                        <td><?php echo $row['AptNumber']; ?></td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo $row['PhoneNumber']; ?></td>
                                        <td><?php echo $row['AptDate']; ?></td>
                                        <td><?php echo $row['AptTime']; ?></td>
                                        <td><?php echo $row['branch']; ?></td>
                                        <td><a href="view-appointment.php?viewid=<?php echo $row['ID']; ?>">View</a></td>
                                    </tr>
                                    <?php
                                    $cnt++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include_once('includes/footer.php'); ?>

    </div>

    <!-- Scroll Effect and Menu -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function () {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>

    <!-- Scrolling JS -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
</body>

</html>

<?php } ?>
