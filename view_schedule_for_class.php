<?php

include 'template/header.php';

include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

// Initialize an empty array to store unique days
$uniqueDays = [];

// Define the desired order of the days
$desiredOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $classID = $_GET['classID'];

    // Fetch the "day" values for the given classID
    $query = "SELECT day FROM schedule WHERE classID = '$classID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if there are rows returned
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row and add "day" values to the array
            while ($row = mysqli_fetch_assoc($result)) {
                $uniqueDays[] = htmlspecialchars($row['day']);
            }

            // Remove duplicates from the array
            $uniqueDays = array_unique($uniqueDays);

            // Sort the days based on the desired order
            usort($uniqueDays, function($a, $b) use ($desiredOrder) {
                return array_search($a, $desiredOrder) - array_search($b, $desiredOrder);
            });
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="vsfc.css">

    <title>SNK</title>
</head>

<body>
    <?php if ($userLevel == 1) {
    include 'template/admin_nav.php';
} else {
    include 'template/stud_nav.php';
}?>
  
<div class="main-content">
    <div class="con">
<?php
    // Display unique days in main content
    if (!empty($uniqueDays)) {
        foreach ($uniqueDays as $day) {
            echo '<form action="view_class_for_day.php" method="get">';
            echo '<input type="hidden" name="classID" value="' . $classID . '">';
            echo '<input type="hidden" name="day" value="' . htmlspecialchars($day) . '">';
            echo '<button type="submit" class="card" id="card">';
            echo '<div class="content">';
            echo '<span>' . $day . '</span>';
            echo '</div>';
            echo '</button>';
            echo '</form>';
        }
        
    } else {
        echo '<p>No schedule found for Class ID: ' . $classID . '</p>';
    }
    ?>
    </div>
</div>
</body>
</html>
