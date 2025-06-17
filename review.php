<?php
include 'connection.php'; // Make sure this file contains $conn = new mysqli(...);

// Fetch feedback data
$sql = "SELECT * FROM feedback ORDER BY feedback_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CC Video Advertising</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../CC_Video_Advertisining/css/review.css" rel="stylesheet">
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

<!-- Review Section -->
<div class="container mt-4">
  <h3>Review</h3>

  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="review-card">
        <div class="d-flex align-items-start">
          <i class="fas fa-user fa-2x"></i>
          <div class="ms-3">
            <h6><strong><?= htmlspecialchars($row['name']) ?></strong></h6>
            <p class="mt-2"><?= nl2br(htmlspecialchars($row['msg'])) ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No feedback available yet.</p>
  <?php endif; ?>
</div>


<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- Footer cols -->
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
          <li><a href="#">Phone</a><ul><li class="a">078 73 86 366</li></ul></li>
          <li><a href="#">Email</a><ul><li class="a">chanukanirmal899@gmail.com</li></ul></li>
          <li><a href="#">Address</a><ul><li class="a">G38,CC Vido Advertising,<br>Ruwanwella,Kegalle.</li></ul></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Follow Us</h4>
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
  </div>
</footer>

<script>
  const profileIcon = document.getElementById("profileIcon");
  const signoutMenu = document.getElementById("signoutMenu");
  profileIcon.addEventListener("click", () => {
    signoutMenu.style.display = signoutMenu.style.display === "block" ? "none" : "block";
  });
  document.addEventListener("click", function(event) {
    if (!profileIcon.contains(event.target) && !signoutMenu.contains(event.target)) {
      signoutMenu.style.display = "none";
    }
  });
</script>

</body>
</html>
