<?php         include 'template/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="add_user.css">

    <title>SNK</title>
</head>
<body>
    <?php
        include 'template/admin_nav.php';

    ?>

    <div class="main-content">
    <form action="add_account.php" method="post" class="form">
    <p class="title">Add User </p>
        <div class="flex">
        <label>
            <input class="input" type="text"  required id="fname" name="fname">
            <span>Firstname</span>
        </label>

        <label>
            <input class="input" type="text" required id="lname" name="lname">
            <span>Lastname</span>
        </label>
    </div>  
            
    <label>
        <input class="input" type="text" required id="middle_name" name="middle_name">
        <span>Middlename</span>
    </label> 

        
    <label>
    <input class="input" type="text" required id="age" name="age" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        <span>age</span>
    </label>
    <label>
    <input class="input" type="text" required id="accID" name="accID" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        <span>AccountID</span>
    </label>
    <input type="submit" value="Submit" class="submit">
</form>
    </div>
</body>
</html>