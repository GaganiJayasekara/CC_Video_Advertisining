<?php
$filename = basename($_GET['file'] ?? '');
$filepath = __DIR__ . "/../CC_Video_Advertisining/uploads/" . $filename;

if (!file_exists($filepath)) {
    http_response_code(404);
    echo "❌ File not found.";
    exit;
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
readfile($filepath);
exit;
?>
