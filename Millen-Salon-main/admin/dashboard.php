<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('./includes/dbconnection.php');

// Secure session check
if (!isset($_SESSION['bpmsaid']) || empty($_SESSION['bpmsaid'])) {
    header('location:logout.php');
    exit(); 
}

// Query functions for DRY approach
function getCount($query) {
    global $con;
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error in query: " . mysqli_error($con);
        return 0; // Return 0 if the query fails
    }
    return mysqli_num_rows($result);
}

function getSum($query) {
    global $con;
    $result = mysqli_query($con, $query);
    if (!$result) {
        echo "Error in query: " . mysqli_error($con);
        return 0; // Return 0 if the query fails
    }
    $sum = 0;
    while ($row = mysqli_fetch_array($result)) {
        $sum += $row['Cost'];
    }
    return $sum;
}

// Data fetching for dashboard stats
$totalAppointments = getCount("SELECT * FROM tblappointment");
$totalAcceptedAppointments = getCount("SELECT * FROM tblappointment WHERE Status='1'");
$totalRejectedAppointments = getCount("SELECT * FROM tblappointment WHERE Status='2'");  // Fixed query for rejected appointments
$totalServices = getCount("SELECT * FROM tblservices");
$todaysSale = getSum("SELECT tblinvoice.ServiceId as ServiceId, tblservices.Cost 
                      FROM tblinvoice 
                      JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId 
                      WHERE DATE(PostingDate) = CURDATE()");
$totalRevenue = getSum("SELECT tblinvoice.ServiceId as ServiceId, tblservices.Cost 
                        FROM tblinvoice 
                        JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId");

?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Millen Hair Salon | Admin Dashboard</title>

    <!-- External CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet" type="text/css" />
    <link href="css/clndr.css" rel="stylesheet" type="text/css" />
    <link href="css/custom.css" rel="stylesheet">
    
    <!-- jQuery and Scripts -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/Chart.js"></script>
    <script src="js/underscore-min.js"></script>
    <script src="js/moment-2.2.1.js"></script>
    <script src="js/clndr.js"></script>
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/classie.js"></script>
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Wow.js Initialization -->
    <script>
        new WOW().init();
    </script>
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">

        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <!-- Main Content -->
        <div id="page-wrapper" class="row calender widget-shadow">
            <div class="main-page">

                <div class="row calender widget-shadow">
                    <!-- First divider: Appointments Stats -->
                    <div class="col-md-4 widget states-mdl">
                        <div class="stats-left">
                            <h5>Total</h5>
                            <h4>Appointment</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $totalAppointments; ?></label>
                        </div>
                    </div>

                    <div class="col-md-4 widget states-last">
                        <div class="stats-left">
                            <h5>Total</h5>
                            <h4>Accepted Apt</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $totalAcceptedAppointments; ?></label>
                        </div>
                    </div>

                    <div class="col-md-4 widget states-last">
                        <div class="stats-left">
                            <h5>Total</h5>
                            <h4>Rejected Apt</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $totalRejectedAppointments; ?></label>
                        </div>
                    </div>
                </div>

                <div class="row calender widget-shadow">
                    <!-- Second divider: Services and Sales -->
                    <div class="col-md-4 widget states-mdl">
                        <div class="stats-left">
                            <h5>Total</h5>
                            <h4>Services</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $totalServices; ?></label>
                        </div>
                    </div>

                    <div class="col-md-4 widget states-last">
                        <div class="stats-left">
                            <h5>Today</h5>
                            <h4>Sales</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $todaysSale; ?></label>
                        </div>
                    </div>

                    <div class="col-md-4 widget">
                        <div class="stats-left">
                            <h5>Total</h5>
                            <h4>Revenue</h4>
                        </div>
                        <div class="stats-right">
                            <label> <?php echo $totalRevenue; ?></label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Menu Toggle Script -->
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

</body>

</html>
