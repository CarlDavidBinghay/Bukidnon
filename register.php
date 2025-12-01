<?php
// Include the database connection
include('db_config.php');

// Start the session
session_start();

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email is already registered.";
        } else {
            // Hash the password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $hashed_password);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: login_page.php");
                exit();
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-green-600 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
            <img src="img/bukidnon_logo.png" alt="Bukidnon Logo" class="w-24 h-24 object-contain">
        </div>

        <h2 class="text-3xl font-semibold text-center text-green-600 mb-6">Register</h2>

        <!-- Display error message if registration fails -->
        <?php if (isset($error_message)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-6">
                <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">Register</button>
        </form>

        <div class="mt-4 text-center">
            <a href="login_page.php" class="text-sm text-green-600 hover:text-green-800">Already have an account? Log in</a>
        </div>
    </div>

</body>

</html>
