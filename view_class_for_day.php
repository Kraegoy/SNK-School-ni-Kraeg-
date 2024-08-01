<?php
include 'template/header.php';
include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

$classID = $_GET['classID'];
$day = $_GET['day'];

// Fetch schedule information for the specified classID and day
$query = "SELECT *
          FROM schedule
          WHERE classID = '$classID' AND day = '$day'";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="vcfd.css">
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
        <div class="con">
            <?php
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<form action="view_attendance_for_class.php" method="get">';
                    echo '<input type="hidden" name="classID" value="' . $classID . '">';
                    echo '<input type="hidden" name="day" value="' . $day . '">';
                    echo '<input type="hidden" name="scheduleID" value="' . $row['scheduleID'] . '">';
                    echo '<button type="submit" class="card">';
                    echo '<p class="time-text"><span>' . date("h:i A", strtotime($row['start_time'])) . 
                    ' - </span><div class="time-sub-text">' . date("h:i A", strtotime($row['end_time'])) . '</div></p>';
                    echo '<div class="aw" style="color: green;"> Class: ' .$row['scheduleID'] . '</div></p>';
                    echo '<p class="day-text">' .$day . '</p>';
                    echo '</button>';
                    echo '</form>';
                }
            } else {
                echo 'Error fetching schedule information.';
            }
            ?>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
