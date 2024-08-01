<?php
include 'template/header.php';

include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="view_attendance.css">

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

    <div class="holder"><span >Attendance</span></div>
    <div class="aw-container">
    <?php
        // Query to select all classes where teacherID matches the session userID
        $query = "SELECT * FROM class WHERE teacherID = '$userID'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Check if there are rows returned
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row and display class information
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="card">';
                    echo '<p class="heading">' . htmlspecialchars($row['className']) . '</p>';
                    echo '<p class="para">Class ID: ' . $row['classID'] . '</p>';
                    echo '<div class="overlay"></div>';
                    echo '<form action="view_schedule_for_class.php" method="get" style="display: inline;">';
                    echo '<input type="hidden" name="classID" value="' . $row['classID'] . '">';
                    echo '<button class="card-btn" type="submit">Click</button>';
                    echo '</form>';
                    echo '</div>';

                }
            } else {
                echo "No classes found for the teacher.";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the result set
        mysqli_free_result($result);
        ?>
    </div>
</div>

</body>
</html>
