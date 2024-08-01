<?php
include 'template/header.php';
$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

include("connection.php");

if (isset($_GET['classID'])) {
    // Retrieve the classID from the URL
    $classID = $_GET['classID'];
} else {
    // Redirect or handle the case when classID is not provided in the URL
    header("Location: some_redirect_page.php");
    exit();
}

// Use prepared statements to prevent SQL injection
$sql = "SELECT classID, className FROM class WHERE classID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $classID);
$stmt->execute();
$stmt->bind_result($classID, $className);
$stmt->fetch();
$stmt->close();

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
            <p style="margin-bottom: 35px;">Add Schedule to class: <span style="color: green;"><?php echo $classID . " - " . $className; ?></span></p>
                <form action="insert_sched_to_class.php" method="POST">

              

                <div class="user-box">
                    <label for="timeRange">Start Time</label>
                    <input required="" name="start_time" type="time" id="start_time" >
                </div>
                
                <div class="user-box">
                    <label for="timeRange">End Time</label>
                    <input required="" name="end_time" type="time" id="end_time">
                </div>

                <input type="hidden" name="classID" value="<?php echo $classID; ?>">

                <div class="user-box">
                    <label for="day">Day</label>
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
      
</body>
</html>