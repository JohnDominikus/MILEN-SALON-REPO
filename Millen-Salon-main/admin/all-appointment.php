<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    // Handle Status Update
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $appointmentId = intval($_POST['appointmentId']);
    $updateQuery = "UPDATE tblappointment SET Status = '$status' WHERE ID = $appointmentId";
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($con) . "');</script>";
    }
}

if (isset($_POST['updateAppointmentId'])) {
    // Handle Appointment Edit
    $appointmentId = intval($_POST['updateAppointmentId']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phoneNumber = mysqli_real_escape_string($con, $_POST['phoneNumber']);
    $aptDate = mysqli_real_escape_string($con, $_POST['aptDate']);
    $aptTime = mysqli_real_escape_string($con, $_POST['aptTime']);
    $services = mysqli_real_escape_string($con, $_POST['services']);
    $branch = mysqli_real_escape_string($con, $_POST['branch']);

    $updateQuery = "UPDATE tblappointment SET 
        Name='$name', 
        Email='$email', 
        PhoneNumber='$phoneNumber', 
        AptDate='$aptDate', 
        AptTime='$aptTime', 
        Services='$services', 
        Branch='$branch' 
        WHERE ID = $appointmentId";
    
    if (mysqli_query($con, $updateQuery)) {
        echo "<script>alert('Appointment updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating appointment: " . mysqli_error($con) . "');</script>";
    }
}

if (isset($_GET['deleteAppointmentId'])) {
    // Handle Appointment Deletion
    $appointmentId = intval($_GET['deleteAppointmentId']);
    $deleteQuery = "DELETE FROM tblappointment WHERE ID = $appointmentId";
    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('Appointment deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting appointment: " . mysqli_error($con) . "');</script>";
    }
}

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

$query = "SELECT * FROM tblappointment WHERE Name LIKE '%$searchTerm%' OR Email LIKE '%$searchTerm%' OR PhoneNumber LIKE '%$searchTerm%' ORDER BY ApplyDate DESC";
$appointments = mysqli_query($con, $query);
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Millen Hair Salon || Appointments</title>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/font-awesome.css" rel="stylesheet"> 
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"> </script>
</head> 
<body>
    <div class="main-content">
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Appointments</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>Appointments:</h4>
                        <form method="post">
                            <input type="text" name="search" placeholder="Search by name, email or phone" value="<?php echo $searchTerm; ?>">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        <table class="table table-bordered">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($appointments) > 0) {
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_assoc($appointments)) {
                                ?>
                                    <tr id="appointment-<?php echo $row['ID']; ?>">
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
                                            <!-- Status Update -->
                                            <form method="post" style="display:inline;">
                                                <input type="hidden" name="appointmentId" value="<?php echo $row['ID']; ?>">
                                                <select name="status" onchange="confirmStatusChange(this.form)">
                                                    <option value="Pending" <?php if($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                    <option value="Accepted" <?php if($row['Status'] == 'Accepted') echo 'selected'; ?>>Accepted</option>
                                                    <option value="Rejected" <?php if($row['Status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                                </select>
                                            </form>
                                            <!-- View Button -->
                                            <button class="btn btn-success" data-toggle="modal" data-target="#viewAppointmentModal" onclick="viewAppointmentDetails(<?php echo $row['ID']; ?>)">View</button>
                                            <!-- Edit Button -->
                                            <button class="btn btn-warning" data-toggle="modal" data-target="#editAppointmentModal" onclick="editAppointmentDetails(<?php echo $row['ID']; ?>)">Edit</button>
                                            <!-- Delete Button -->
                                            <a href="appointments.php?deleteAppointmentId=<?php echo $row['ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php
                                    $cnt++;
                                    }
                                } else {
                                    echo "<tr><td colspan='11'>No appointments found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>
    </div>

    <!-- View Appointment Modal -->
    <div id="viewAppointmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h4>
                </div>
                <div class="modal-body" id="appointmentDetails">
                    <!-- Appointment details will be populated here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Appointment Modal -->
    <div id="editAppointmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="editAppointmentForm">
                        <input type="hidden" name="updateAppointmentId" id="updateAppointmentId">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phoneNumber" id="editPhoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label>Appointment Date</label>
                            <input type="date" class="form-control" name="aptDate" id="editAptDate" required>
                        </div>
                        <div class="form-group">
                            <label>Appointment Time</label>
                            <input type="time" class="form-control" name="aptTime" id="editAptTime" required>
                        </div>
                        <div class="form-group">
                            <label>Services</label>
                            <input type="text" class="form-control" name="services" id="editServices" required>
                        </div>
                        <div class="form-group">
                            <label>Branch</label>
                            <input type="text" class="form-control" name="branch" id="editBranch" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewAppointmentDetails(appointmentId) {
            var appointment = document.querySelector(`#appointment-${appointmentId}`);
            var details = `
                <p><strong>Appointment Number:</strong> ${appointment.querySelector('td:nth-child(2)').textContent}</p>
                <p><strong>Name:</strong> ${appointment.querySelector('td:nth-child(3)').textContent}</p>
                <p><strong>Email:</strong> ${appointment.querySelector('td:nth-child(4)').textContent}</p>
                <p><strong>Phone Number:</strong> ${appointment.querySelector('td:nth-child(5)').textContent}</p>
                <p><strong>Appointment Date:</strong> ${appointment.querySelector('td:nth-child(6)').textContent}</p>
                <p><strong>Appointment Time:</strong> ${appointment.querySelector('td:nth-child(7)').textContent}</p>
                <p><strong>Services:</strong> ${appointment.querySelector('td:nth-child(8)').textContent}</p>
                <p><strong>Branch:</strong> ${appointment.querySelector('td:nth-child(9)').textContent}</p>
            `;
            document.getElementById('appointmentDetails').innerHTML = details;
        }

        function editAppointmentDetails(appointmentId) {
            var appointment = document.querySelector(`#appointment-${appointmentId}`);
            document.getElementById('updateAppointmentId').value = appointmentId;
            document.getElementById('editName').value = appointment.querySelector('td:nth-child(3)').textContent;
            document.getElementById('editEmail').value = appointment.querySelector('td:nth-child(4)').textContent;
            document.getElementById('editPhoneNumber').value = appointment.querySelector('td:nth-child(5)').textContent;
            document.getElementById('editAptDate').value = appointment.querySelector('td:nth-child(6)').textContent;
            document.getElementById('editAptTime').value = appointment.querySelector('td:nth-child(7)').textContent;
            document.getElementById('editServices').value = appointment.querySelector('td:nth-child(8)').textContent;
            document.getElementById('editBranch').value = appointment.querySelector('td:nth-child(9)').textContent;
        }

        function confirmStatusChange(form) {
            return confirm("Are you sure you want to update the status?");
        }
    </script>
</body>
</html>
