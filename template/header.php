<?php

session_start();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(86, 87, 94);

        }

        header {
            background-color: #2a2b38;
            padding: 8px;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav {
            display: flex;
            margin-right: 30px;
            margin-left: 67em;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav li {
            margin-right: 20px;
            position: relative;
        }
        nav li:hover {
            background-color: rgba(72, 73, 99, 0.379);
          
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
            display: block;
        }

        nav ul ul {
            display: none;
            position: absolute;
            top: 100%;
            padding: 10px;
            width: 215%;
            background-color: #2a2b38;
            font-size: 0.9em;
            border-radius: 0 0 5px 5px;
        }

        nav ul ul li:hover{
            background-color: rgba(72, 73, 99, 0.379);

        }

        nav ul li:hover > ul {
            display: inherit;
        }

        main {
            margin-top: 60px;
            padding: 20px;
        }

        #logo {
            position: fixed;
            padding: 0;
            margin-left: 75px;
        }
        img{
            height: 3.2em;
            width: 6.5em;
            padding: 0;
        }
    </style>
</head>
<body>

    <header>
        <div id="logo">
            <img src="template/SNK.png" alt="Your Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                
                <li><a href="#"><i class="fas fa-bell"></i></a></li>
                <li style="margin-right: -8px;"><a href="#"><?php echo $username ?></a></li>

                <li>
                    <a href="#"><i class="fas fa-caret-down"></i></a>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="profile.php">SDK</a></li>
                        <li><a href="login.php">Logout</i></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>


</body>
</html>
