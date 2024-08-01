<?php
include 'template/header.php';

include("connection.php");
$username = $_SESSION['username'];
$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="profile.css">
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
        <div class="parent">
  <div class="card">
      <div class="content-box">
      <span class="card-title"><p><?php echo ucfirst($username); ?></p></span>
          <p class="card-content">
        <?php echo $accountID; ?>
     </p>
          <span class="see-more">See More</span>
      </div>
      <div class="date-box">
          <img src="template/js.png" alt="profile" class="profile-pic">
      </div>
  </div>
</div>
        </div>
</body>
</html>