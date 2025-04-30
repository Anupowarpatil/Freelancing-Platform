<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "karyasetu";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../signup.html");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../signup.html");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../signup.html");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        $stmt->close();
        $conn->close();
        header("Location: ../signup.html");
        exit();
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $email, $hashed_password);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful. Please log in.";
        $stmt->close();
        $conn->close();
        header("Location: ../login.html");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
        $stmt->close();
        $conn->close();
        header("Location: ../signup.html");
        exit();
    }
} else {
    header("Location: ../signup.html");
    exit();
}
?>
