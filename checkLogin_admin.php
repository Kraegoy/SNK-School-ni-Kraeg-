<?php
include 'connection.php';

session_start();

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["logemail"];
    $password = $_POST["logpass"];

    // Use prepared statements to prevent SQL injection

    // Check if the provided username and password match records in the accounts table
    $stmt = $conn->prepare("SELECT accountID, userID, username, password, userLevel FROM account WHERE username = ? AND userLevel = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($accountiD, $userID, $username, $hashedPassword, $userLevel);  
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if ($password === $hashedPassword) { 
        $_SESSION['accountID'] = $accountID;
        $_SESSION['userID'] = $userID;
        $_SESSION['username'] = $username;
        $_SESSION['userLevel'] = $userLevel;
        

        echo "<script>
                window.location.href = 'dashboard.php';
            </script>";
    } else {
        echo "<script>
                window.location.href = 'admin_login.php';
            </script>";
    }
} else {
    echo "No data submitted.";
}

$conn->close();
?>
