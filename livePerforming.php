<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $duration = $_POST['duration'] ?? '';
    $presenter_gender = $_POST['presenter'] ?? '';
    $script_reference = $_POST['script'] ?? '';
    $other_details = $_POST['details'] ?? '';

    $resource_file = "";
    if (isset($_FILES['resource']) && $_FILES['resource']['error'] == 0) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $resource_file = $targetDir . basename($_FILES['resource']['name']);
        move_uploaded_file($_FILES['resource']['tmp_name'], $resource_file);
    }

    $sql = "INSERT INTO LivePerformingAds (duration, presenter_gender, script_reference, resource_file, other_details) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $duration, $presenter_gender, $script_reference, $resource_file, $other_details);

    if ($stmt->execute()) {
        echo "<script>alert('Details submitted successfully!'); window.location.href='create.php';</script>";
    } else {
        echo "Execution failed: " . $stmt->error;
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

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC Video Advertisining</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!--External CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../CC_Video_Advertisining/css/textAnimation.css" rel="stylesheet">
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
        <div class="profile-dropdown position-relative ms-3">
  <i class="fas fa-user fa-2x" id="profileIcon" style="cursor: pointer;"></i>
  <div class="dropdown-content position-absolute bg-white border rounded shadow" id="signoutMenu" style="display: none; right: 0;">
    <a href="../CC_Video_Advertisining/start.html" class="d-block px-3 py-2 text-dark text-decoration-none">Sign Out</a>
  </div>
</div>

      </div>
    </div>
  </nav>

        <main>
          <form action="livePerforming.php" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="duration">Enter your time duration</label>
    <input type="text" id="duration" name="duration">
  </div>
  <div class="form-group">
    <label for="presenter">What do you want voice</label>
    <div class="select-wrapper">
      <select id="presenter" name="presenter">
        <option value="">Select voice option</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="script">Upload Script</label>
    <input type="text" id="script" name="script">
  </div>
  <div class="form-group">
    <label for="resource">Upload Resource</label>
    <div class="upload-wrapper">
      <input type="file" id="resource" name="resource">
    </div>
  </div>
  <div class="form-group">
    <label for="details">Other Details</label>
    <textarea id="details" name="details" rows="3"></textarea>
  </div>
  <div class="button-group">
    <button type="submit">Submit</button>
    <button type="reset">Reset</button>
  </div>
</form>

        </main>

  <!-- Footer -->
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

  // Hide dropdown if clicked outside
  document.addEventListener("click", function(event) {
    if (!profileIcon.contains(event.target) && !signoutMenu.contains(event.target)) {
      signoutMenu.style.display = "none";
    }
  });
</script>

</body>
</html>


