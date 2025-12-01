<?php
// Include the database connection
include('db_config.php');

// Start the session
session_start();

// User login validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database for the user
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR); // Bind the email parameter
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $user = $result[0]; // Fetch user data

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user['id']; // Store user id in session for later use

            // Redirect to dashboard after successful login
            header("Location: dashboard.php");
            exit(); // Make sure to stop further execution
        } else {
            // Invalid password error message
            $error_message = "Invalid password.";
        }
    } else {
        // No user found with that email
        $error_message = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-600 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-96">
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
            <img src="img/bukidnon_logo.png" alt="Bukidnon Logo" class="w-24 h-24 object-contain">
        </div>

        <h2 class="text-3xl font-semibold text-center text-green-600 mb-6">Sign In</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <button type="submit" class="w-full py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">Sign In</button>
        </form>

        <div class="mt-4 text-center">
            <a href="register.php" class="text-sm text-green-600 hover:text-green-800">Don't have an account? Register here</a>
        </div>
    </div>

</body>
</html>
