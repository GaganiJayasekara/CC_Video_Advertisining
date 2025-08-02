<?php
include 'connection.php';

$registration_error = '';
$registration_success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $conform_password = $_POST['conform_password'];

    // Password confirmation
    if ($password !== $conform_password) {
        $registration_error = "Passwords do not match.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into Customer table
        $sql = "INSERT INTO Customer (username, phone_number, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $user_name, $phone_number, $email, $hashed_password);

            if ($stmt->execute()) {
                $registration_success = "Registration successful!";
                header("Location: login.php"); // Redirect to login page
                exit;
            } else {
                $registration_error = "Error during registration: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $registration_error = "SQL error: " . $conn->error;
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
  <title>CC Video Advertising</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../CC_Video_Advertisining/css/login.css" rel="stylesheet">
</head>
<body>

<div class="signin-container mx-auto my-5 p-4 text-white">
    <img src="../CC_Video_Advertisining/images/logo.png" alt="Creative Creator Logo" class="logo mb-3">
    <h2 class="text-center mb-4">Register Form</h2>

    <!-- Show error/success messages -->
    <?php if (!empty($registration_error)): ?>
        <div class="alert alert-danger text-center"><?= $registration_error ?></div>
    <?php endif; ?>
    <?php if (!empty($registration_success)): ?>
        <div class="alert alert-success text-center"><?= $registration_success ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input name="user_name" type="text" class="form-control mb-3" placeholder="User Name" required>
      <input name="phone_number" type="text" class="form-control mb-3" placeholder="Phone Number" required>
      <input name="email" type="email" class="form-control mb-3" placeholder="Email" required>
      <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>
      <input name="conform_password" type="password" class="form-control mb-4" placeholder="Confirm Password" required>
      <div class="d-flex justify-content-center gap-3">
        <button type="submit" class="btn btn-dark px-4 rounded-pill">Sign in</button>
        <button type="reset" class="btn btn-dark px-4 rounded-pill">Cancel</button>
      </div>
    </form>
</div>

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="footer-col">
        <h4>Video Production</h4>
        <ul>
          <li><a href="#">Text Animation Video Ads</a></li>
          <li><a href="#">Live Performing Video Ads</a></li>
          <li><a href="#">Logo animations</a></li>
          <li><a href="#">Intro Video</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Other Services</h4>
        <ul>
          <li><a href="#">Ringing tones</a></li>
          <li><a href="#">Video Ads</a></li>
          <li><a href="#">Logo Design</a></li>
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
            <ul><li class="a">G38, CC Video Advertising,<br>Ruwanwella, Kegalle.</li></ul>
          </li>
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

</body>
</html>

