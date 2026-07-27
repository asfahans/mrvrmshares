<?php
session_start();

// Include the database configuration
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Connect to the database using the configuration constants
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to retrieve user information based on the provided email
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct; set user session and redirect to dashboard
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_email"] = $row["email"];
            header("Location: feedback_list.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Invalid email or password.";
        }
    } else {
        $_SESSION["login_error"] = "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}

header("Location: login.php");
exit();
?>
