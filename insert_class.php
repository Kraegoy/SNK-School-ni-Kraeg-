<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $classID = $_POST['classID'];
    $className = $_POST['className'];
    $units = $_POST['units'];
    $teacherName = $_POST['teacher']; 

    $teacherNameParts = explode(' ', $teacherName);
    $lastName = $teacherNameParts[0];
    $firstName = $teacherNameParts[1];

    $teacherQuery = "SELECT u.userID 
                     FROM user u
                     JOIN account a ON u.userID = a.userID
                     WHERE a.userLevel = 2
                     AND u.LastName = '$lastName'
                     AND u.FirstName = '$firstName'";

    $teacherResult = $conn->query($teacherQuery);

    if ($teacherResult->num_rows > 0) {
        $teacherRow = $teacherResult->fetch_assoc();
        $teacherID = $teacherRow['userID'];

        // Insert data into the class table
        $insertQuery = "INSERT INTO class (classID, className, units, teacherID) 
                        VALUES ('$classID', '$className', '$units', '$teacherID')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "<script>
            alert('Added Successfully!');
            window.location.href = 'add_class.php'; 
        </script>";
        } else {
            echo "<script>
            alert('Error! Check input.');
            window.location.href = 'add_class.php'; 
        </script>";        }
    } else {
        echo "Error: Teacher not found";
    }
}

$conn->close();
?>
