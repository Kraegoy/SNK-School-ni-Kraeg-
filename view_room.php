<?php
include 'template/header.php';

include("connection.php");

$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

$classID = isset($_GET['classID']) ? $_GET['classID'] : null;
$className = isset($_GET['className']) ? $_GET['className'] : null;
$meetingNumber = isset($_GET['meetingNumber']) ? $_GET['meetingNumber'] : null;
$scheduleID = isset($_GET['scheduleID']) ? $_GET['scheduleID'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;

// Fetch users with the specified conditions
$query = "SELECT user.FirstName, user.LastName, account.userLevel
          FROM attendance
          JOIN user ON attendance.userID = user.userID
          JOIN account ON user.userID = account.userID
          WHERE attendance.scheduleID = $scheduleID
            AND attendance.date = '$date'
            AND attendance.meetingNumber = $meetingNumber";

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="room.css">
    <title>SNK</title>
</head>
<body>
    <?php 
        if($userLevel == 1){
            include 'template/admin_nav.php';
        } else {
            include 'template/stud_nav.php';
        }
    ?>
    <div class="main-content">
        <div class="room-container">
            <h2><?php echo $className?> <span style="font-size: 0.45em; margin-left: 40px;"> Meeting <?php echo $meetingNumber?></span></h2>

            <?php
            // Loop through the results and display each user's information in a card
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card">';
                echo '<div class="card-border-top"></div>';
                echo '<div class="img"></div>';
                echo '<div class="online-icon"></div>';
                if ($row['userLevel'] == 2) {
                    echo '<span style="color: #e52e71d3; margin-bottom: -10px; margin-top: -8px;">Teacher</span>';
                }
                echo '<span>' . $row['LastName'] . '</span>';
                echo '<p class="job">' . $row['FirstName'] . '</p>';
              
                echo '</div>';
            }
            ?>

        </div>
    </div>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
