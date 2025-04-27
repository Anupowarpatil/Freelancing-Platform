<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>KaryaSetu - Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .profile-container {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      max-width: 400px;
      width: 100%;
      text-align: center;
    }
    h1 {
      color: #1e90ff;
      margin-bottom: 1rem;
    }
    p {
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }
    a.logout-btn {
      display: inline-block;
      margin-top: 1rem;
      padding: 10px 20px;
      background-color: #1e90ff;
      color: white;
      text-decoration: none;
      border-radius: 25px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    a.logout-btn:hover {
      background-color: #187bcd;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
    <p>Email: <?php
      // Fetch email from database for current user
      $host = "localhost";
      $user = "root";
      $password = "";
      $dbname = "karyasetu";
      $conn = new mysqli($host, $user, $password, $dbname);
      if ($conn->connect_error) {
          echo "Error connecting to database";
      } else {
          $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
          $stmt->bind_param("i", $_SESSION['user_id']);
          $stmt->execute();
          $stmt->bind_result($email);
          $stmt->fetch();
          echo htmlspecialchars($email);
          $stmt->close();
      }
    ?></p>

    <h2>Your Jobs</h2>
    <?php
      // Placeholder for jobs - assuming a jobs table with user_id foreign key
      $jobs = [];
      $stmt = $conn->prepare("SELECT id, title, status FROM jobs WHERE user_id = ?");
      if ($stmt) {
          $stmt->bind_param("i", $_SESSION['user_id']);
          $stmt->execute();
          $result = $stmt->get_result();
          while ($row = $result->fetch_assoc()) {
              $jobs[] = $row;
          }
          $stmt->close();
      }
      $conn->close();

      if (count($jobs) === 0) {
          echo "<p>You have no jobs posted yet.</p>";
      } else {
          echo "<ul>";
          foreach ($jobs as $job) {
              echo "<li>Job ID: " . htmlspecialchars($job['id']) . " - Title: " . htmlspecialchars($job['title']) . " - Status: " . htmlspecialchars($job['status']) . "</li>";
          }
          echo "</ul>";
      }
    ?>

    <a href="logout.php" class="logout-btn">Logout</a>
  </div>
</body>
</html>
