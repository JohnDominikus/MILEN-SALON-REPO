<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Redirect if session is not set
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
    exit;
} else {

    // Function to fetch the latest appointment
    function fetchNewAppointments($con) {
        $query = "SELECT * FROM tblappointment WHERE Status='Pending' ORDER BY ApplyDate DESC LIMIT 10";
        $result = mysqli_query($con, $query);
        return $result;
    }

    // Handle status update
    if (isset($_POST['updateStatus'])) {
        $appointmentId = $_POST['appointmentId'];
        $newStatus = $_POST['status'];

        // Update status query
        $updateQuery = "UPDATE tblappointment SET Status = '$newStatus' WHERE ID = $appointmentId";
        if (mysqli_query($con, $updateQuery)) {
            echo "<script>alert('Status updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating status: " . mysqli_error($con) . "');</script>";
        }
    }

    // Fetch new appointments
    $appointments = fetchNewAppointments($con);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Millen Hair Salon || New Appointment</title>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font CSS -->
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!-- Modal CSS -->
    <link href="css/modal.css" rel="stylesheet">
</head> 
<body class="cbp-spmenu-push">
    <div class="main-content">
        <!-- left-fixed -navigation -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- left-fixed -navigation -->

        <!-- header-starts -->
        <?php include_once('includes/header.php'); ?>
        <!-- //header-ends -->

        <!-- main content start-->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">New Appointment</h3>

                    <div class="table-responsive bs-example widget-shadow">
                        <h4>New Appointment:</h4>
                        <!-- Button to toggle table visibility -->
                        <button id="toggleTable" class="btn btn-primary">Show/Hide Appointments</button>
                        <table class="table table-bordered" id="appointmentsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Appointment Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Services</th>
                                    <th>Branch</th>
                                    <th>Apply Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($appointments) > 0) {
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_assoc($appointments)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $cnt; ?></th>
                                        <td><?php echo $row['AptNumber']; ?></td>
                                        <td><?php echo $row['Name']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo $row['PhoneNumber']; ?></td>
                                        <td><?php echo $row['AptDate']; ?></td>
                                        <td><?php echo $row['AptTime']; ?></td>
                                        <td><?php echo $row['Services']; ?></td>
                                        <td><?php echo $row['Branch']; ?></td>
                                        <td><?php echo $row['ApplyDate']; ?></td>
                                        <td>
                                            <form method="post" id="statusForm-<?php echo $row['ID']; ?>" onsubmit="return confirmUpdate(<?php echo $row['ID']; ?>)">
                                                <select name="status" id="status-<?php echo $row['ID']; ?>">
                                                    <option value="Pending" <?php if($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                    <option value="Accepted" <?php if($row['Status'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                                                    <option value="Rejected" <?php if($row['Status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                                </select>
                                                <input type="hidden" name="appointmentId" value="<?php echo $row['ID']; ?>">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal" onclick="setAppointmentId(<?php echo $row['ID']; ?>)">Update Status</button>
                                            </form>
                                        </td>
                                        <td><a href="view-appointment.php?viewid=<?php echo $row['ID']; ?>">View</a></td>
                                    </tr>
                                <?php
                                    $cnt++;
                                    }
                                } else {
                                    echo "<tr><td colspan='12'>No new appointments found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php include_once('includes/footer.php'); ?>
        <!-- //footer -->
    </div>

    <!-- Modal for Confirmation -->
    <div id="confirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="confirmModalLabel">Confirm Status Update</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want to proceed with updating the status?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmBtn">Yes, Proceed</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Classie -->
    <script src="js/classie.js"></script>
    <script>
        // Toggle the visibility of the appointment table
        document.getElementById('toggleTable').onclick = function() {
            var table = document.getElementById('appointmentsTable');
            if (table.style.display === "none") {
                table.style.display = "block";
            } else {
                table.style.display = "none";
            }
        };

        var appointmentIdToUpdate;

        function setAppointmentId(appointmentId) {
            appointmentIdToUpdate = appointmentId;
        }

        function confirmUpdate(appointmentId) {
            $('#confirmModal').modal('show');
            document.getElementById('confirmBtn').onclick = function() {
                var status = document.getElementById('status-' + appointmentId).value;
                var form = document.getElementById('statusForm-' + appointmentId);
                var hiddenField = document.createElement("input");
                hiddenField.type = "hidden";
                hiddenField.name = "updateStatus";
                form.appendChild(hiddenField);
                form.submit();
            };
        }
    </script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
</body>
</html>
<?php } ?>
