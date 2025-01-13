<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<footer class="bg-danger text-white pt-5 pb-5" style="background-color: #ff6f61;">
  <div class="container">
    <div class="row mb-5">
      <!-- Location Map Section -->
      <div class="col-lg-4 col-md-4 mb-4">
        <h2 class="h4 text-white">Our Location</h2>
        <div>
          <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3864.3267785321405!2d120.97445127357602!3d14.408316481758492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d22decfa4fb3%3A0x22ee9a583731962f!2sRFC%20Molino%20Mall!5e0!3m2!1sen!2sph!4v1736787754098!5m2!1sen!2sph" 
            style="border: 0; width: 100%; height: 350px;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>

      <!-- Business Info Section -->
      <div class="col-lg-4 col-md-4 mb-4">
        <h2 class="h4 text-white">Millen Hair Salon</h2>
        <?php
        $ret = mysqli_query($con, "select * from tblpage where PageType='aboutus' ");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
          <p><?php echo strip_tags(substr($row['PageDescription'], 0, 200)); ?> <a href="about.php" class="text-white">More.......</a></p>
        <?php } ?>
      </div>

      <!-- Contact Info Section -->
      <div class="col-lg-4 col-md-4 mb-4">
        <h2 class="h4 text-white">Have a Question?</h2>
        <ul class="list-unstyled">
          <?php
          $ret = mysqli_query($con, "select * from tblpage where PageType='contactus' ");
          while ($row = mysqli_fetch_array($ret)) {
          ?>
            <li><span class="icon icon-map-marker"></span><span class="text"><?php echo $row['PageDescription']; ?></span></li>
            <li><a href="tel:+<?php echo $row['MobileNumber']; ?>" class="text-white"><span class="icon icon-phone"></span><span class="text">+<?php echo $row['MobileNumber']; ?></span></a></li>
            <li><a href="mailto:<?php echo $row['Email']; ?>" class="text-white"><span class="icon icon-envelope"></span><span class="text"><?php echo $row['Email']; ?></span></a></li>
          <?php } ?>
        </ul>
      </div>
    </div>

    <!-- Footer Bottom Section -->
    <div class="row">
      <div class="col-md-12 text-center">
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="#" class="text-white">
              <span class="icon icon-facebook border border-white rounded-circle p-2" style="font-size: 24px;"></span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#" class="text-white">
              <span class="icon icon-twitter border border-white rounded-circle p-2" style="font-size: 24px;"></span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#" class="text-white">
              <span class="icon icon-instagram border border-white rounded-circle p-2" style="font-size: 24px;"></span>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="#" class="text-white">
              <span class="icon icon-linkedin border border-white rounded-circle p-2" style="font-size: 24px;"></span>
            </a>
          </li>
        </ul>
        <p>&copy; 2024 Millen Hair Salon. All Rights Reserved.</p>
      </div>
    </div>
  </div>
</footer>
