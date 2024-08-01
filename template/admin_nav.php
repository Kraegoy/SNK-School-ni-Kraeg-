<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            background-color: rgb(86, 87, 94);
        }

        #sidebar {
            width: 200px;
            height: 100vh;
            background: #2a2b38;
            padding-top: 20px;
            color: white;
            position: fixed;
            transition: width 0.3s ease;
            margin-top:28px;
        }

        #sidebar.collapsed {
            width: 65px;
        }

        #sidebar a {
            text-decoration: none;
            color: white;
            padding: 15px 20px;
            display: block;
            transition: background 0.1s;
            margin-bottom: 20px;
            position: relative;
        }

        #sidebar a span {
            display: inline-block;
            opacity: 1;
            position: absolute;
            left: 32%;
            transition: opacity 0.3s ease;
        }

        #sidebar a:hover {
            background: #434453;
        }

        #sidebar.collapsed a span {
            opacity: 0;
            visibility: hidden;
        }

        .icon-menu {
            cursor: pointer;
            margin-left: 18px;
            margin-top: 20px;
            transition: margin-left 0.5s ease;
        }

        .main-content {
            transition: margin-left 0.3s ease;
            margin-left: 40px; 
            width: 100%;
        }

        .bar {
            margin-left: 18px;
            height: 2.5px;
            width: 25px;
            border-radius: .5rem;
            background-color: rgba(152, 65, 252, 0.55);
            margin-bottom: 5px;
            transition: transform 0.3s ease, margin-left 0.3s ease;
        }

        .check-icon:checked + .icon-menu .bar--1 {
            transform: rotate(45deg) translate(4px, 4px);
            margin-left: 150px;
        }

        .check-icon:checked + .icon-menu .bar--2 {
            transform: scaleX(0);
            margin-left: 150px;
        }

        .check-icon:checked + .icon-menu .bar--3 {
            transform: rotate(-45deg) translate(4px, -4px);
            margin-left: 150px;
        }

        i {
            margin-right: 10px;
        }

        .last {
            margin-top: 290px;
            margin-left: 70px;
        }

    </style>
    <title>Your Website</title>
</head>

<body>
    <div class="container">
        <div id="sidebar" class='collapsed'>
            <input hidden class="check-icon" id="check-icon" name="check-icon" type="checkbox" >
            <label class="icon-menu" for="check-icon" >
                <div class="bar bar--1"></div>
                <div class="bar bar--2"></div>
                <div class="bar bar--3" style="margin-bottom: 18px;"></div>
            </label>
            <a href="dashboard.php"><i class="fas fa-home"></i><span> Home</span></a>
            <a href="display_classes.php"><i class="fas fa-book"></i> <span>Classes</span></a>
            <a href="display_users.php"><i class="fas fa-user"></i><span> Users</span></a>
            <a href="add_class.php"><i class="fas fa-plus"></i><span>Add Class</span></a>
            <a href="add_user.php"><i class="fas fa-user-plus"></i><span>Add User</span></a>

            <a href="#"><i class="far fa-calendar-alt"></i> <span>Calendar</span></a>
        </div>
        <div id="main-content" class="main-content">
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('main-content');
            var checkIcon = document.getElementById('check-icon');

            checkIcon.addEventListener('change', function () {
                sidebar.classList.toggle('collapsed', !checkIcon.checked);
                mainContent.style.marginLeft = sidebar.classList.contains('collapsed') ? '40px' : '177px';
            });
        });
    </script>
</body>

</html>
