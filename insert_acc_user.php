<?php
include 'connection.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];
    $middle_name = $_POST["middle_name"];
    $age = $_POST["age"];
    $accID = $_POST["accID"];

    // Additional form data (adjust as needed)
    $userLevel = $_POST["userLevel"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Insert data into the user table
    $userQuery = "INSERT INTO user (FirstName, LastName, MiddleName, age, accountID) VALUES ('$fname', '$lname', '$middle_name', $age, $accID)";
    $userResult = $conn->query($userQuery);

    if ($userResult) {
        // Get the auto-generated user ID
        $userID = $conn->insert_id;

        // Insert data into the account table
        $accountQuery = "INSERT INTO account (accountID, userID, userLevel, username, password) VALUES ($accID, $userID, $userLevel, '$username', '$password')";
        $accountResult = $conn->query($accountQuery);


        if ($accountResult) {

            echo "<script>
            alert('Registration successful!');   
            window.location.href = 'add_user.php'; 
  
        </script>
        ";  
    } 
        else {
            echo "<script>
            alert('error');
            window.location.href = 'add_account.php'; 
        </script>";
        }
    } 

    $conn->close();
}
?>
