<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Millen Hair Salon</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff5f5; /* Light red background */
    }
    #ftco-navbar {
      position: fixed;
      top: 0;
      width: 100%;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #8B0000; /* Dark red background */
      height: 70px; /* Slightly increased height for a more prominent look */
      transition: opacity 0.5s; /* Smooth transition for opacity */
      z-index: 1000; /* Ensure navbar is always on top */
    }
    .nav-link {
      font-size: 1.1rem;
      padding-left: 1rem;
      padding-right: 1rem;
      transition: color 0.3s;
      color: #FFFFFF; /* White text color */
    }
    .nav-link:hover {
      color: #FFD700 !important; /* Gold hover color */
    }
    .nav-link.active {
      color: #FFD700 !important; /* Highlight current page link */
      font-weight: bold; /* Bold current page link */
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.7rem;
      color: #FFD700; /* Gold color for the brand name */
      font-family: 'Brush Script MT', cursive; /* Script font for brand name */
    }
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23FFD700' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E"); /* Gold color for the toggler icon */
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">Millen Hair Salon</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="services.php" class="nav-link">Services</a></li>
          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
          <li class="nav-item"><a href="appointments.php" class="nav-link">Appointments</a></li>
          <li class="nav-item"><a href="admin/index.php" class="nav-link">Admin</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Your page content goes here -->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script>
    // Highlight the current page link
    document.addEventListener('DOMContentLoaded', function() {
      var links = document.querySelectorAll('.nav-link');
      links.forEach(function(link) {
        if (link.href === window.location.href) {
          link.classList.add('active');
        }
      });
    });

    // Make navbar fade out on scroll
    window.onscroll = function() {
      var navbar = document.getElementById("ftco-navbar");
      if (window.pageYOffset > 50) {
        navbar.style.opacity = "0"; /* Fade out */
      } else {
        navbar.style.opacity = "1"; /* Fade in */
      }
    };
  </script>
</body>
</html>
