<?php
session_start();
include 'connection.php';

$username = $_SESSION['username'] ?? 'demo_user';

// ✅ Updated: Use CustomerID as per your table
function getCustomerID($conn, $username) {
    $stmt = $conn->prepare("SELECT CustomerID FROM Customer WHERE username = ? LIMIT 1");
    if (!$stmt) {
        echo "<p style='color:red;'>Prepare failed: " . $conn->error . "</p>";
        return null;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) return $row['CustomerID'];
    return null;
}

// ✅ Approve / Reject
if (isset($_POST['action']) && isset($_POST['username'])) {
    $customerID = getCustomerID($conn, $_POST['username']);
    if ($customerID) {
        $stmt = $conn->prepare("INSERT INTO projects (aprovel, CustomerID) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("si", $_POST['action'], $customerID);
            $stmt->execute();
        } else {
            echo "<p style='color:red;'>Prepare failed: " . $conn->error . "</p>";
        }
    }
}

// ✅ State update
if (isset($_POST['state']) && isset($_POST['username'])) {
    $customerID = getCustomerID($conn, $_POST['username']);
    if ($customerID) {
        $stmt = $conn->prepare("INSERT INTO projects (state, CustomerID) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("si", $_POST['state'], $customerID);
            $stmt->execute();
        } else {
            echo "<p style='color:red;'>Prepare failed: " . $conn->error . "</p>";
        }
    }
}

function fetchAds($conn) {
    $results = [];
    $videoTables = [
        "TextAnimationVideoAd" => ["label" => "Text Animation Video", "summary_col" => "script_text"],
        "LivePerformingAds" => ["label" => "Live Performing Ad", "summary_col" => "script_reference"]
    ];
    foreach ($videoTables as $table => $meta) {
        $summary_col = $meta["summary_col"];
        $sql = "SELECT id, $summary_col AS summary, resource_file FROM $table";
        $query = $conn->query($sql);
        if (!$query) continue;
        while ($row = $query->fetch_assoc()) {
            $results[] = [
                'id' => $row['id'],
                'name' => $meta['label'],
                'summary' => $row['summary'],
                'file' => $row['resource_file']
            ];
        }
    }
    return $results;
}

function fetchGraphics($conn) {
    $results = [];
    $tables = ["BannerDesign", "BookCover", "IntroVideo", "LogoDesign", "PosterLeaflet", "TuteCover", "SocialMediaPost"];
    foreach ($tables as $table) {
        $sql = "SELECT id, other_details, resource_file FROM $table";
        $query = $conn->query($sql);
        if (!$query) continue;
        while ($row = $query->fetch_assoc()) {
            $results[] = [
                'id' => $row['id'],
                'name' => $table,
                'details' => $row['other_details'],
                'file' => $row['resource_file']
            ];
        }
    }
    return $results;
}

$videoAds = fetchAds($conn);
$graphicDesigns = fetchGraphics($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CC Video Advertising</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../CC_Video_Advertisining/css/admin.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="../CC_Video_Advertisining/images/logo.png" alt="Logo" style="height: 75px;"></a>
    <div class="heading">
      <h1>Order Request</h1>
    </div>
  </div>
</nav>
<hr>

<main>
<section class="request-section">
  <h2>Video Advertisement</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Video ID</th>
        <th>Name</th>
        <th>Summary</th>
        <th>Resource File</th>
        <th>Approve / Reject</th>
        <th>State</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($videoAds as $ad): ?>
        <tr>
          <form method="post">
            <td><?= $ad['id'] ?></td>
            <td><?= $ad['name'] ?></td>
            <td><?= $ad['summary'] ?></td>
            <td>
              <?php if (!empty($ad['file'])): ?>
                <a href="download.php?file=<?= urlencode($ad['file']) ?>" class="btn btn-info btn-sm">Download</a>
              <?php else: ?>
                <span>No File</span>
              <?php endif; ?>
            </td>
            <td>
              <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
              <button type="submit" name="action" value="Approve" class="btn btn-success btn-sm">Approve</button>
              <button type="submit" name="action" value="Reject" class="btn btn-danger btn-sm">Reject</button>
            </td>
            <td>
              <?php foreach (["20%", "40%", "60%", "80%", "Completed"] as $state): ?>
                <button type="submit" name="state" value="<?= $state ?>" class="btn btn-outline-secondary btn-sm"><?= $state ?></button>
              <?php endforeach; ?>
            </td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<section class="request-section">
  <h2>Graphic Design Services</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Design ID</th>
        <th>Name</th>
        <th>Other Details</th>
        <th>Resource File</th>
        <th>Approve / Reject</th>
        <th>State</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($graphicDesigns as $design): ?>
        <tr>
          <form method="post">
            <td><?= $design['id'] ?></td>
            <td><?= $design['name'] ?></td>
            <td><?= $design['details'] ?></td>
            <td>
              <?php if (!empty($design['file'])): ?>
                <a href="download.php?file=<?= urlencode($design['file']) ?>" class="btn btn-info btn-sm">Download</a>
              <?php else: ?>
                <span>No File</span>
              <?php endif; ?>
            </td>
            <td>
              <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
              <button type="submit" name="action" value="Approve" class="btn btn-success btn-sm">Approve</button>
              <button type="submit" name="action" value="Reject" class="btn btn-danger btn-sm">Reject</button>
            </td>
            <td>
              <?php foreach (["20%", "40%", "60%", "80%", "Completed"] as $state): ?>
                <button type="submit" name="state" value="<?= $state ?>" class="btn btn-outline-secondary btn-sm"><?= $state ?></button>
              <?php endforeach; ?>
            </td>
          </form>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<div class="review-section text-center my-4">
  <a href="../CC_Video_Advertisining/review.php" class="btn btn-primary review-button">Review Section</a>
</div>
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

</body>
</html>
