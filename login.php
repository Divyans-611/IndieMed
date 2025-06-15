<?php
$host = "sql308.infinityfree.com";
$username = "if0_39238132";
$password = "Ynow8rEH1ceExFb";
$database = "if0_39238132_indiemed_db";


$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$loginSuccess = false;
$errorMessage = "";

if ($result->num_rows === 1) {
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    $loginSuccess = true;
  } else {
    $errorMessage = "❌ Invalid password.";
  }
} else {
  $errorMessage = "❌ User not found.";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Status</title>
  <style>
    body {
      background-color:rgb(0, 0, 0);
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .message-box {
      text-align: center;
      padding: 40px;
      border-radius: 15px;
      background-color: rgb(4, 78, 63);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      animation: fadeIn 1s ease-in-out;
    }

    .checkmark {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      border-radius: 50%;
      background: #4BB543;
      position: relative;
      animation: pop 0.6s ease-out;
    }

    .checkmark::after {
      content: '';
      position: absolute;
      left: 22px;
      top: 38px;
      width: 20px;
      height: 40px;
      border: solid white;
      border-width: 0 6px 6px 0;
      transform: rotate(45deg);
    }

    @keyframes pop {
      0% { transform: scale(0); }
      100% { transform: scale(1); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .back-btn {
      margin-top: 25px;
      padding: 10px 20px;
      background-color: rgb(28, 169, 158);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      display: inline-block;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: rgb(8, 73, 68);
    }

    .error-msg {
      font-size: 18px;
      color: red;
    }
    .h2{
      color: white;
    }
  </style>
</head>
<body>

  <div class="message-box">
    <?php if ($loginSuccess): ?>
      <div class="checkmark"></div>
      <h2 class="h2">Login Successful!</h2>
      <p class="h2">Welcome back to IndieMed 🎉</p>
    <?php else: ?>
      <p class="error-msg"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
    <a class="back-btn" href="index.html">Back to Home</a>
  </div>

</body>
</html>
