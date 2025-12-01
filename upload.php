<?php
include('db_config.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profileImage'])) {
    $fileName = basename($_FILES['profileImage']['name']);
    $targetDir = 'uploads/';
    $targetFilePath = $targetDir . $fileName;

    // File upload logic
    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
        // Insert file path and upload date into the database
        $uploadDate = date('Y-m-d H:i:s');
        $sql = "INSERT INTO profile_images (image_path, upload_date) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$targetFilePath, $uploadDate]);
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading the file.";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="profileImage" required>
    <button type="submit">Upload Image</button>
</form>
