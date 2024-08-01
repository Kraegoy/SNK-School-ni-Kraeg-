<?php
      include 'template/header.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $lname = $_POST["lname"];
    $fname = $_POST["fname"];
    $middle_name = $_POST["middle_name"];
    $age = $_POST["age"];
    $accID = $_POST["accID"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="add_user.css">
    <title>SNK</title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#username").on("blur", function() {
                var username = $(this).val();

                if (username !== "") {
                    // Perform AJAX request
                    $.ajax({
                        type: "POST",
                        url: "check_username.php", 
                        data: { username: username },
                        success: function(response) {
                            if (response === "duplicate") {
                                $("#username-warning").text("Username already exists! Please choose a different one.");
                            } else {
                                $("#username-warning").text("");
                            }
                        }
                    });
                }
            });
        });
    </script>
</head>
<body>

    <?php
        include 'template/admin_nav.php';
    ?>

    <div class="main-content">
        <form class="form" action="insert_acc_user.php" method="POST">

            <input type="hidden" name="lname" value="<?php echo $lname; ?>">
            <input type="hidden" name="fname" value="<?php echo $fname; ?>">
            <input type="hidden" name="middle_name" value="<?php echo $middle_name; ?>">
            <input type="hidden" name="age" value="<?php echo $age; ?>">
            <input type="hidden" name="accID" value="<?php echo $accID; ?>">

            <p class="title">Add Account to user: <span style="color: green;"><?php echo " " . $lname; ?></span></p>

            <label>
            <input class="input" type="number" name="userLevel" placeholder="" min="1" max="3" required oninput="this.value = Math.abs(this.value)">
                <span>UserLevel</span>
            </label> 

            <label>
            <input class="input" type="text" name="username" id="username" placeholder="" required="">
                 <span>Username</span>
            </label>
                 <div id="username-warning" style="color: rgb(255, 78, 78);"></div>

            <label>
                <input class="input" type="password" name="password" placeholder="" required="">
                <span>Password</span>
            </label>

            <label>
                <input class="input" type="password" placeholder="" required="">
                <span>Confirm Password</span>
            </label>

            <input type="submit" value="Submit" class="submit">
        </form>
    </div>
</body>
</html>
