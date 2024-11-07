<?php 
include('includes/dbconnection.php'); // connection
session_start();
error_reporting(0);

if(isset($_POST['submit'])) // form field values
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $services = $_POST['services'];
    $branch = $_POST['branch'];
    $adate = date('Y-m-d', strtotime($_POST['adate'])); // Format the date here
    $atime = $_POST['atime'];
    $phone = $_POST['phone'];
    $aptnumber = mt_rand(100000000, 999999999);  // Generates a random 9-digit appointment number.

    // Insert query with default 'Pending' status
    $query = mysqli_query($con, "INSERT INTO tblappointment (AptNumber, Name, Email, PhoneNumber, AptDate, AptTime, Services, Branch, Status) VALUES ('$aptnumber', '$name', '$email', '$phone', '$adate', '$atime', '$services', '$branch', 'Pending')");
    
    if ($query) {
        $ret = mysqli_query($con, "SELECT AptNumber FROM tblappointment WHERE Email='$email' AND PhoneNumber='$phone'");
        $result = mysqli_fetch_array($ret);
        $_SESSION['aptno'] = $result['AptNumber'];
        echo "<script>window.location.href='thank-you.php'</script>"; // Redirects the user to a "thank-you.php"
    } else {
        $msg = "Something Went Wrong. Please try again";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Millen Hair Salon ||Home Page</title>
        
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
	  <?php include_once('includes/header.php');?>
    <!-- END nav -->

    <section id="home-section" class="hero" style="background-image: url(images/redbg.jpg);" data-stellar-background-ratio="0.5">
		  <div class="home-slider owl-carousel">
	      <div class="slider-item js-fullheight">
	      	<div class="overlay"></div>
	        <div class="container-fluid p-0">
	          <div class="row d-md-flex no-gutters slider-text align-items-end justify-content-end" data-scrollax-parent="true">
	          	<img class="one-third align-self-end order-md-last img-fluid" src="images/har2.png" alt="">
		          <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
		          	<div class="text mt-5">
		          		<span class="subheading">Beauty Parlour</span>
			            <h1 class="mb-4">Good hair days start here.</h1>
			            <p class="mb-4">Ready to ditch the bad hair days and embrace your hair goals?   We're experts in all things hair, from classic cuts and vibrant colors to the trendiest styles.  
							Whether you're craving a complete makeover or just need a bit of TLC, we'll create a look that's perfect for you.  ✨</p>
			            
			           
		            </div>
		          </div>
	        	</div>
	        </div>
	      </div>

	      <div class="slider-item js-fullheight">
	      	<div class="overlay"></div>
	        <div class="container-fluid p-0">
	          <div class="row d-flex no-gutters slider-text align-items-center justify-content-end" data-scrollax-parent="true">
	          	<img class="one-third align-self-end order-md-last img-fluid" src="images/hair.png" alt="">
		          <div class="one-forth d-flex align-items-center ftco-animate" data-scrollax=" properties: { translateY: '70%' }">
		          	<div class="text mt-5">
		          		<span class="subheading">Natural Beauty</span>
			            <h1 class="mb-4">Get the look you deserve.</h1>
			            <p class="mb-4">This parlour provides huge facilities with advanced technology equipments and best quality service. Here we offer best treatment that you might have never experienced before.</p>
			            
			           
		            </div>
		          </div>
	        	</div>
	        </div>
	      </div>
	    </div>
    </section>


<br>
    <section class="ftco-section ftco-no-pt ftco-booking">
    	<div class="container-fluid px-0">
    		<div class="row no-gutters d-md-flex justify-content-end">
    			<div class="one-forth d-flex align-items-end">
    				<div class="text">
    					<div class="overlay"></div>
    					<div class="appointment-wrap">
    						<span class="subheading">Reservation</span>
								<h3 class="mb-2">Make an Appointment</h3>
		    				<form action="#" method="post" class="appointment-form">
			            <div class="row">
			              <div class="col-sm-12">
			                <div class="form-group">
					              <input type="text" class="form-control" id="name" placeholder="Name" name="name" required="true">
					            </div>
			              </div>
			              <div class="col-sm-12">
			                <div class="form-group">
					              <input type="email" class="form-control" id="appointment_email" placeholder="Email" name="email" required="true">
					            </div>
			              </div>
				            <div class="col-sm-12">
			                <div class="form-group">
					              <div class="select-wrap">
		                      <div class="icon"><span class="ion-ios-arrow-down"></span></div>
		                      <select name="services" id="services" required="true" class="form-control">
		                      	<option value="">Select Services</option>
		                      	<?php $query=mysqli_query($con,"select * from tblservices");
              while($row=mysqli_fetch_array($query))
              {
              ?>
		                       <option value="<?php echo $row['ServiceName'];?>"><?php echo $row['ServiceName'];?></option>
		                       <?php } ?> 
		                      </select>
		                    </div>
					            </div>
			              </div>

						  <div class="col-sm-12">
  							<div class="form-group">
    						<div class="select-wrap">
      						<div class="icon"><span class="ion-ios-arrow-down"></span></div>
      						<select name="branch" id="branch" required="true" class="form-control">
        					<option value="">Select Branch</option>
							<?php $query=mysqli_query($con,"select * from tblbranch");
              while($row=mysqli_fetch_array($query))
              {
              ?>
		                       <option value="<?php echo $row['Branch'];?>"><?php echo $row['Branch'];?></option>
		                       <?php } ?> 
      							</select>
    						</div>
  							</div>
							</div>	  
						  
			              <div class="col-sm-12">
			                <div class="form-group">
			                  <input type="text" class="form-control appointment_date" placeholder="Date" name="adate" id='adate' required="true">
			                </div>    
			              </div>
			              <div class="col-sm-12">
			                <div class="form-group">
			                  <input type="text" class="form-control appointment_time" placeholder="Time" name="atime" id='atime' required="true">
			                </div>
			              </div>
			              <div class="col-sm-12">
			                <div class="form-group">
			                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required="true" maxlength="10" pattern="[0-9]+">
			                </div>
			              </div>
				          </div>
				          <div class="form-group">
			              <input type="submit" name="submit" value="Make an Appointment" class="btn btn-primary">
			            </div>
			          </form>
		          </div>
						</div>
    			</div>
					<div class="one-third">
						<div class="img" style="background-image: url(images/salon.jpg);">
						</div>
					</div>
    		</div>
    	</div>
    </section>

		
		<br>


   <?php include_once('includes/footer.php');?>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>