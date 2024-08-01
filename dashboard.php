<?php
include 'template/header.php';

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

    <style>
.tabs {
    margin-top: 100px;
    margin-left: 50px;
    height: 40px;
    color:  #2a2b38;
    font-weight: bold;
}

.tab {
    cursor: pointer;
    padding: 10px;
    margin-right: 5px;
    border: 2px solid #2a2b38;
    border-radius: 5px;
    margin-bottom: 40px;
    display: flex;
   
}

.tab.active {
    color: rgba(57, 192, 255, 0.729);
    border: 3px solid rgba(57, 192, 255, 0.729);
}

.day-container {
    margin-top: 50px;
    margin-left: 40px;
    display: none;
    animation: fadeIn 0.1s ease-out;
}

.day-container.active {
    display: flex;
    flex-wrap: wrap;
    animation: fadeIn 0.1s ease-out;
}
    </style>
</head>
<body>
    <?php 
        if($userLevel == 1){
            include 'template/admin_nav.php';
        } else {
            include 'template/stud_nav.php';
        }
    ?>
<?php if($userLevel == 3 || $userLevel == 2){ ?>

    <?php
    $dayCards = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $day = $row['day'];
        
        if (!isset($dayCards[$day])) {
            $dayCards[$day] = array();
        }

        $dayCards[$day][] = $row;
    }
    ?>

<div class="tabs">


    <?php

    date_default_timezone_set('Asia/Manila');

    $daysOfWeek = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    foreach ($daysOfWeek as $day) { ?>
        <div class="tab" data-day="<?php echo $day; ?>" onclick="showDay('<?php echo $day; ?>')"><?php echo $day; ?></div>
    <?php } ?>
</div>

<?php } ?>


 
 <!-- Student dash -->
<?php if($userLevel == 3){ ?>

    <?php foreach ($daysOfWeek as $day) { ?>
        <div class="day-container" id="<?php echo $day; ?>">
            <?php
            if (isset($dayCards[$day])) {
                foreach ($dayCards[$day] as $row) { ?>
                    <div class="card">
                        <div class="card-header">
                            <p style="display: inline-block;"><?php echo $row['day']; ?></p>

                         <?php
                         $isToday = ($row['day'] === date('l'));
                         $isWithinTimeRange = (date('H:i') >= substr($row['start_time'], 0, 5) && date('H:i') <= substr($row['end_time'], 0, 5));
                         $style = ($isToday && $isWithinTimeRange) ? 'color: green; animation: shine 2s infinite;' : '';
                                if ($isToday && $isWithinTimeRange) {
                                echo '<span style="display: inline-block; margin-left: 135px;">';
                                echo '<form action="process_attendance.php" method="post" style="display: inline;">';
                                echo '<input type="hidden" name="userID" value="' . $userID . '">';
                                echo '<input type="hidden" name="scheduleID" value="' . $row['scheduleID'] . '">';
                                echo '<input type="hidden" name="classID" value="' . $row['classID'] . '">';
                                echo '<input type="hidden" name="className" value="' . $row['className'] . '">';
                                echo '<input type="hidden" name="start_time" value="' . $row['start_time'] . '">';
                                echo '<button type="submit" class="join" name="attendButton">Attend</button>';
                                echo '</form>';
                                echo '</span>';
                            } else {
                                echo '<span style="display: inline-block; margin-left: 135px;">';
                                echo '<button type="button" class="join" onclick="alert(\'Class is not ongoing.\')">Attend</button>';
                                echo '</span>';
                            }
                            ?>

                            <div style="margin: 0; height: 2em;">
                            <p class="title" style="<?php echo $style; ?>"><?php echo strtoupper($row['className']); ?></p>
                            </div>
                        </div>
                        <div class="card-author">
                            <a class="author-avatar" href="#">
                                <span></span>
                            </a>
                            <svg class="half-circle" viewBox="0 0 106 57">
                                <path d="M102 4c0 27.1-21.9 49-49 49S4 31.1 4 4"></path>
                            </svg>
                            <div class="author-name">
                                <div class="author-name-prefix">Teacher</div>
                                <?php
                                echo ucwords($row['FirstName']) . ' ' . strtoupper(substr($row['MiddleName'], 0, 1)) . '. ' . ucwords($row['LastName']);
                                ?>
                            </div>
                        </div>
                        <div class="tags">
                            <a href="#"> Start: <?php echo substr($row['start_time'], 0, 5); ?></a>
                            <a href="#"> End: <?php echo substr($row['end_time'], 0, 5); ?></a>
                            <a href="#"><?php echo $row['classID']; ?></a>
                        </div>
                    </div>
                <?php }
            }
            else{
                echo'<div class="no-container">';
                
                echo '<span class="no">No Classes for this day!</span>';
                echo '<p class="down-no">Give yourself a rest. </p>';
                echo'</div>';

            }
            ?>
        </div>
    <?php } ?>

    <script>
    function showDay(day) {
        var tabs = document.querySelectorAll('.tab');
        var dayContainers = document.querySelectorAll('.day-container');

        tabs.forEach(function (tab) {
            tab.classList.remove('active');
        });

        dayContainers.forEach(function (container) {
            container.classList.remove('active');
        });

        if (day === 'Classes') {
            dayContainers.forEach(function (container) {
                container.classList.add('active');
            });
        } else {
            document.getElementById(day).classList.add('active');
            document.querySelector('.tab[data-day="' + day + '"]').classList.add('active');
        }
    }

    // Function to automatically activate the tab for the current day
    function activateCurrentDayTab() {
        var currentDate = new Date();
        var currentDayIndex = currentDate.getDay(); // Days are 0-indexed (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
        var currentDay = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][currentDayIndex];

        showDay(currentDay);
    }

    // Call the function to activate the tab for the current day on page load
    document.addEventListener("DOMContentLoaded", activateCurrentDayTab);
</script>

<?php } ?>
 <!-- Student dash -->


 <?php if($userLevel == 2){ 
    include 'teachers_dash.php';

 }?>



</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
