<?php include 'connection.php';
        include 'template/header.php';
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="add_user.css">

    <title>Document</title>
</head>
<body>
    <?php
        include 'template/admin_nav.php';

    ?>

    <div class="main-content">
    <form action="insert_class.php" method="post" class="form">
    <p class="title">Add Class</p>
        <div class="flex">
        <label>
        <input class="input" type="text" inputmode="numeric" pattern="[0-9]*" required id="classID" name="classID" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            <span>Class ID</span>
        </label>

        <label>
            <input class="input" type="text" required id="className" name="className">
            <span>Class Name</span>
        </label>
    </div>  
            
    <label>
    <input class="input" type="text" inputmode="numeric" pattern="[0-9]*" required id="units" name="units" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        <span>Units</span>
    </label> 

        
    <label>
    <select class="input" required id="teacher" name="teacher" style="width: 102%; ">
        <!-- Placeholder option -->
        <option style="padding: 15px;" value="" disabled selected ></option>
        <?php
        // Fetch teacher names from the user table
        $sql = "SELECT u.LastName, u.FirstName 
        FROM user u
        JOIN account a ON u.userID = a.userID
        WHERE a.userLevel = 2";
        $result = $conn->query($sql);

        // Populate the dropdown with teacher names
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['LastName'] . ' ' . $row['FirstName'] . '">' . $row['LastName'] . ' ' . $row['FirstName'] . '</option>';
            }
        }
        ?>
    </select>
    <span>Teacher</span>
</label>

    <input type="submit" value="Submit" class="submit">
</form>
    </div>
</body>
</html>