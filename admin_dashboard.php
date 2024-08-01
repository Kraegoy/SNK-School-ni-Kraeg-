<?php

session_start();

include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

// Fetch user schedule with class names and teacher information from the database
$query = "SELECT user_sched.*, class.className, user.FirstName, user.LastName, user.MiddleName, schedule.day, schedule.start_time, schedule.end_time
          FROM user_sched 
          JOIN class ON user_sched.classID = class.classID 
          JOIN user ON class.teacherID = user.userID 
          JOIN schedule ON user_sched.scheduleID = schedule.scheduleID
          WHERE user_sched.userID = $userID";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="sched.css">
    <title>SNK</title>
</head>
<body>
    <?php 
        include 'template/header.php';
        if($userLevel == 1){
            include 'template/admin_nav.php';
        } else {
            include 'template/stud_nav.php';
        }
    ?>
    <div class="main-content">
        <?php
        date_default_timezone_set('Asia/Manila');

        if ($result) {
        // Get the current day in the format "Monday", "Tuesday", etc.
        $today = date('l');
           $currentTime = date('H:i');

            // Loop through the results and display each card
            while ($row = mysqli_fetch_assoc($result)) {
                $isToday = ($row['day'] === $today);
                $isToday = ($row['day'] === $today);

                // Check if the current time is within the range
                $isWithinTimeRange = ($currentTime >= substr($row['start_time'], 0, 5) && $currentTime <= substr($row['end_time'], 0, 5));
                $style = ($isToday && $isWithinTimeRange) ? 'color: green; animation: shine 2s infinite;' : '';

                echo '<div class="card">';
                echo '<div class="card-header">';
                echo '<p style="display: inline-block; ' . $style . '">' . $row['day'] . '</p>';
                echo '<span style="display: inline-block; margin-left: 135px;"><button type="button" class="join">Attend</button></span>';                
                echo '<div>';
                echo '<p class="title" ' . $style . '>' . strtoupper($row['className']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="card-author">';
                echo '<a class="author-avatar" href="#">';
                echo '<span></span></a>';
                echo '<svg class="half-circle" viewBox="0 0 106 57">';
                echo '<path d="M102 4c0 27.1-21.9 49-49 49S4 31.1 4 4"></path>';
                echo '</svg>';
                echo '<div class="author-name">';
                echo '<div class="author-name-prefix">Teacher</div>';
                echo ucwords($row['FirstName']) . ' ' . strtoupper(substr($row['MiddleName'], 0, 1)) . '. ' . ucwords($row['LastName']);
                echo '</div>';
                echo '</div>';
                echo '<div class="tags">';
                echo '<a href="#"> Start: ' . substr($row['start_time'], 0, 5) . '</a>';
                echo '<a href="#"> End: ' . substr($row['end_time'], 0, 5) . '</a>';                
                echo '<a href="#">' . $row['classID'] . '</a>';
                echo '</div>';
                echo '</div>';

            }
        } else {
            // Display an error message if the query fails
            echo '<p>Error fetching schedule: ' . mysqli_error($conn) . '</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
