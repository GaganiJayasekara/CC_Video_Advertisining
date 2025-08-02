<?php
include 'connection.php';


$username = $_SESSION['username'] ?? null;

if ($username) {
    $stmt = $conn->prepare("SELECT CustomerID FROM Customer WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $customerID = $row['CustomerID'];

            $stmt2 = $conn->prepare("SELECT aprovel, state FROM projects WHERE CustomerID = ? LIMIT 1");
            $stmt2->bind_param("i", $customerID);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($project = $result2->fetch_assoc()) {
                $message = "";
                if ($project['aprovel'] === 'Reject') {
                    $message = "❌ The task you submitted has been rejected.";
                } elseif ($project['aprovel'] === 'Approve') {
                    $message = "✅ The task you submitted has been approved.";

                    // Add state if available
                    switch ($project['state']) {
                        case "20%": $message .= "<br>📊 20% complete so far."; break;
                        case "40%": $message .= "<br>📊 40% complete so far."; break;
                        case "60%": $message .= "<br>📊 60% complete so far."; break;
                        case "80%": $message .= "<br>📊 80% complete so far."; break;
                        case "Completed": $message .= "<br>🎉 Your task is 100% completed."; break;
                    }
                }

                if ($message !== "") {
                    echo '<div class="container mt-4 mb-3">
                            <div class="alert alert-info text-center fw-bold shadow-sm rounded-3" style="font-size: 1.1rem;">
                                ' . $message . '
                            </div>
                          </div>';
                }
            }
        }
    }
}
?>
