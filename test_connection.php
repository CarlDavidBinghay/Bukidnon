<?php
include('db_config.php');

// Check if the connection is successful
if ($conn) {
    echo "Connected successfully to the database!";
} else {
    echo "Connection failed: " . $conn->connect_error;
}
?>
