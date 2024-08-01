<?php

$query = "SELECT class.*, schedule.scheduleID, schedule.day, schedule.start_time, schedule.end_time, user.FirstName, user.MiddleName, user.LastName
          FROM class
          JOIN schedule ON class.classID = schedule.classID
          JOIN user ON class.teacherID = user.userID
          WHERE class.teacherID = $userID

          UNION

          SELECT class.*, schedule.scheduleID, schedule.day, schedule.start_time, schedule.end_time, user.FirstName, user.MiddleName, user.LastName
          FROM user_sched 
          JOIN class ON user_sched.classID = class.classID 
          JOIN schedule ON user_sched.scheduleID = schedule.scheduleID
          JOIN user ON class.teacherID = user.userID
          WHERE user_sched.userID = $userID";


$result = mysqli_query($conn, $query);

$dayCards = array();

while ($row = mysqli_fetch_assoc($result)) {
    $day = $row['day'];

    if (!isset($dayCards[$day])) {
        $dayCards[$day] = array();
    }

    $isTeacher = true;

    $dayCards[$day][] = array_merge($row, ['isTeacher' => $isTeacher]);
}

?>
<?php foreach ($daysOfWeek as $day) { ?>
    <div class="day-container" id="<?php echo $day; ?>">
        <?php
        if (isset($dayCards[$day])) {
            foreach ($dayCards[$day] as $row) {
                $isTeacher = ($row['teacherID'] == $userID);

                if ($isTeacher) {
                    ?>
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
                <?php
                } // end if $isTeacher
            }
        } else {
            echo '<div class="no-container">';
            echo '<span class="no">No Classes for this day!</span>';
            echo '<p class="down-no">Give yourself a rest. </p>';
            echo '</div>';
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

<!-- Teacher dash -->
