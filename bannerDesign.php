<?php
// Include DB connection
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $other_details = $_POST['details'] ?? '';

    // File Upload Logic
    $resource_file = "";
    if (isset($_FILES['upload']) && $_FILES['upload']['error'] == 0) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $resource_file = $targetDir . basename($_FILES['upload']['name']);
        move_uploaded_file($_FILES['upload']['tmp_name'], $resource_file);
    }

    // Insert into DB
    $sql = "INSERT INTO BannerDesign (resource_file, other_details) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $resource_file, $other_details);
        if ($stmt->execute()) {
            echo "<script>alert('Submission Successful!'); window.location.href='create.php';</script>";
        } else {
            echo "<script>alert('Error during submission!');</script>";
        }
        $stmt->close();
    } else {
        echo "Database error: " . $conn->error;
    }

    $resource_file = "";
if (isset($_FILES['resource']) && $_FILES['resource']['error'] == 0) {
    $targetDir = "uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Generate unique file name using timestamp and random bytes
    $fileName = basename($_FILES['resource']['name']);
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueName = uniqid('res_', true) . '.' . $fileExtension;

    $resource_file = $targetDir . $uniqueName;

    if (!move_uploaded_file($_FILES['resource']['tmp_name'], $resource_file)) {
        die("Failed to upload file.");
    }
}


    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CC Video Advertisining</title>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">


  <!--External CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../CC_Video_Advertisining/css/bannerDesign.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
      <a class="navbar-brand" href="../CC_Video_Advertisining/home.php">
  <img src="../CC_Video_Advertisining/images/logo.png" alt="Logo" style="height: 75px;">
</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
          <li class="nav-item"><a class="nav-link" href="../CC_Video_Advertisining/home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="../CC_Video_Advertisining/services.html">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="../CC_Video_Advertisining/create.html">Create</a></li>
          <li class="nav-item"><a class="nav-link" href="../CC_Video_Advertisining/feedback.php">Feedback</a></li>
          <li class="nav-item"><a class="nav-link" href="../CC_Video_Advertisining/about.html">About Us</a></li>
        </ul>
        <div class="profile-dropdown">
  <i class="fas fa-user fa-2x" id="profileIcon"></i>
  <div class="dropdown-content" id="signoutMenu">
    <a href="../CC_Video_Advertisining/start.html">Sign Out</a>
  </div>
</div>

      </div>
    </div>
  </nav>

  <main class="container py-4">
    <h4 class="fw-bold">Other Graphic Design Service</h4>
    <p class="text-muted">Banner Design</p>

    <form action="bannerDesign.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="upload" class="form-label">Upload Resource</label>
    <input type="file" class="form-control form-control-lg" id="upload" name="upload">
  </div>

  <div class="mb-3">
    <label for="details" class="form-label">Enter Other Details</label>
    <textarea class="form-control form-control-lg" id="details" name="details" rows="2"></textarea>
  </div>

  <div class="text-center">
    <button type="submit" class="btn btn-dark px-5 py-2 rounded-pill me-3">Submit</button>
    <button type="reset" class="btn btn-outline-dark px-5 py-2 rounded-pill">Reset</button>
  </div>
</form>

  </main>

   <footer class="footer">
  	 <div class="container">
		
  	 	<div class="row">
			
  	 		<div class="footer-col">
			
  	 			<h4>Video Production</h4>
  	 			<ul>
  	 				<li><a href="../CC_Video_Advertisining/textAnimation.html">Text Animation Video Ads</a></li>
  	 				<li><a href="../CC_Video_Advertisining/livePerforming.html">Live Performing Video Ads</a></li>
  	 				<li><a href="#">Logo animations</a></li>
  	 				<li><a href="../CC_Video_Advertisining/introVideo.html">Intro Video</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>Other Services</h4>
  	 			<ul>
  	 				<li><a href="#">Ringing tones</a></li>
  	 				<li><a href="#">Video Ads</a></li>
  	 				<li><a href="../CC_Video_Advertisining/logoDesign.html">Logo Design</a></li>
  	 				<li><a href="#">Flyers</a></li>
  	 				<li><a href="#">Business Cards</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>Contact Us</h4>
  	 			<ul>
  	 				<li><a href="#">Phone</a>
						<ul><li class="a">078 73 86 366</li></ul>
					</li>
  	 				<li><a href="#">Email</a>
						<ul><li class="a">chanukanirmal899@gmail.com</li></ul>
					</li>
  	 				<li><a href="#">Address</a>
						<ul><li class="a">G38,CC Vido Advertising,<br>Ruwanwella,Kegalle.</li></ul>
					</li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
				
  	 			<h4>follow us</h4>
  	 			<div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="#"><i class="fab fa-instagram"></i></a>
  	 				<a href="#"><i class="fab fa-linkedin-in"></i></a>
					
  	 			</div>
							
  	 		</div>
			
  	 	</div>
  	 </div>
  	 <div class="footer-bottom">
  	 	<p>Copyright &copy; 2025 CC Video Advertising. All rights reserved.</p>
  	 	
  </footer>

<script>
  const profileIcon = document.getElementById("profileIcon");
  const signoutMenu = document.getElementById("signoutMenu");

  profileIcon.addEventListener("click", () => {
    signoutMenu.style.display = signoutMenu.style.display === "block" ? "none" : "block";
  });

  // Close dropdown if clicked outside
  document.addEventListener("click", function(event) {
    if (!profileIcon.contains(event.target) && !signoutMenu.contains(event.target)) {
      signoutMenu.style.display = "none";
    }
  });
</script>

</body>
</html>