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
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../login.html");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $fullname, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $stmt->close();
            $conn->close();
            header("Location: ../main.html");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            $stmt->close();
            $conn->close();
            header("Location: ../login.html");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email. Please create an account.";
        $stmt->close();
        $conn->close();
        header("Location: ../signup.html");
        exit();
    }
} else {
    header("Location: ../login.html");
    exit();
}
?>
