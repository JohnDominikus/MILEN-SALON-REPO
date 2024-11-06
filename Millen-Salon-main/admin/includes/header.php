<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Millen Hair Salon</title>
    <style>
        .sticky-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff;
            border-bottom: 1px solid #ccc;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .header-left, .header-right {
            display: flex;
            align-items: center;
        }

        .logo h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .logo span {
            font-size: 14px;
            color: #777;
        }

        .profile-img img {
            border-radius: 50%;
        }

        .notifications-dropdown {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #333;
        }

        .profile-details-drop a {
            display: flex;
            align-items: center;
        }

        .profile-details-drop .user-name p {
            margin: 0;
            font-weight: bold;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="sticky-header header-section">
        <div class="header-left">
            <!-- Toggle Button Start -->
            <button id="showLeftPush" class="toggle-btn">
                <i class="fa fa-bars"></i>
            </button>
            <!-- Toggle Button End -->

            <!-- Logo -->
            <div class="logo">
                <a href="index.html">
                    <h1>Millen Hair Salon</h1>
                    <span>Hi Admin</span>
                </a>
            </div>
            <!-- //Logo -->
        </div>

        <div class="header-right">
            <!-- Profile Notifications Section -->
            <div class="profile-details-left">
                <?php
                    // Fetching new appointment notifications
                    $ret1 = mysqli_query($con, "SELECT AptNumber, Name, Status FROM tblappointment WHERE Status='pending'");
                    $num = mysqli_num_rows($ret1);
                ?>
                <ul class="notifications-dropdown">
                    <li class="dropdown head-dpdn">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="badge blue"><?php echo $num; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="notification_header">
                                    <h3>You have <?php echo $num; ?> new notification<?php echo $num > 1 ? 's' : ''; ?></h3>
                                </div>
                            </li>
                            <li>
                                <div class="notification_desc">
                                    <?php if ($num > 0) {
                                        while ($result = mysqli_fetch_array($ret1)) { ?>
                                            <a class="dropdown-item" href="view-appointment.php?viewid=<?php echo $result['AptNumber']; ?>">
                                                New appointment received from <?php echo $result['Name']; ?>
                                            </a><br />
                                        <?php }} else { ?>
                                            <a class="dropdown-item" href="all-appointment.php">No New Appointment Received</a>
                                        <?php } ?>
                                </div>
                            </li>
                            <li>
                                <div class="notification_bottom">
                                    <a href="new-appointment.php">See all notifications</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Profile Details Section -->
            <div class="profile-details">
                <?php
                    // Fetching admin name from the database
                    $adid = $_SESSION['bpmsaid'];
                    $ret = mysqli_query($con, "SELECT AdminName FROM tbladmin WHERE ID='$adid'");
                    $name = '';
                    if ($row = mysqli_fetch_array($ret)) {
                        $name = $row['AdminName'];
                    }
                ?>
                <ul>
                    <li class="dropdown profile-details-drop">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <div class="profile-img">
                                <img src="images/download (1).png" alt="Admin Profile" width="50" height="60">
                            </div>
                            <div class="user-name">
                                <p><?php echo htmlspecialchars($name); ?></p>
                                <span>Administrator</span>
                            </div>
                            <i class="fa fa-angle-down lnr"></i>
                            <i class="fa fa-angle-up lnr"></i>
                        </a>
                        <ul class="dropdown-menu drp-mnu">
                            <li><a href="change-password.php"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="admin-profile.php"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a href="index.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
