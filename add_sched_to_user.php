<?php
include 'template/header.php';

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];

include("connection.php");
if (isset($_GET['userID'])) {
    // Retrieve the userID from the URL
    $userID = $_GET['userID'];
    $FirstName = $_GET['FirstName'];
    $LastName = $_GET['LastName'];

}


$sql = "SELECT classID, className FROM class";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="add_sched.css">
    <title>SNK</title>
</head>
<body>
    <?php 
        if($userLevel == 1){
            include 'template/admin_nav.php';
        }else{
            include 'template/stud_nav.php';
        }
    ?>
    <div class="main-content">
        <div class="login-box">
            <p style="margin-bottom: 35px;">Add Class to user: <?php echo $LastName ." " .$FirstName ?></p>
            <form action="insert_sched.php" method="POST">

                <div class="user-box">
                    <label for="classID">Class</label>
                    <select required name="classID" id="classID">
                        <option style="padding: 15px;" value="" disabled selected ></option>
                        <?php
                        // Check if there are classes in the database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['classID'] . "'>" . $row['className'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No classes found</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="user-box">
                    <label for="day">Schedule</label>
                    <select required name="day" id="day">
                        <option style="padding: 15px;" value="" disabled selected ></option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>

                <div class="user-box">
                <label for="timeSlot">Time available for <span id="selectedDayLabel">----</span></label>
                    <select required name="timeSlot" id="timeSlot">
                        <option style="padding: 15px;" value="" disabled selected ></option>
                        <!-- Options will be dynamically populated using JavaScript -->
                    </select>
                </div>
                <input type="hidden" name="start_time" id="start_time">
                <input type="hidden" name="end_time" id="end_time">

                
                <input type="hidden" name="userID" value=" <?php echo htmlspecialchars($_GET['userID']); ?>">
       
                <button type="submit" class="submit-button">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Add
                </button>

            </form>
        </div>
    </div>

    <script src="fetch_time_slots.js"></script>

</body>
</html>
