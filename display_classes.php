<?php
    include 'template/header.php';


include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

// Fetch all classes from the "class" table
$query = "SELECT c.classID, c.className, c.units, u.FirstName AS teacherFirstName, u.LastName AS teacherLastName
          FROM class c
          JOIN user u ON c.teacherID = u.userID";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNK</title>
</head>
<body>

<style>

        .user-table {
            border-collapse: collapse;
            margin-top: 70px;
            text-align: center;
         

        }
       
        .main-content{
            width: 200px;
            margin-top: 70px;


        }
        table {
            text-align: center;
            color: rgba(249, 245, 253, 0.836);
            background: rgba(36, 36, 47, 0.4);
            width: 200px;

        }

        th, td {
            border: 1px solid #2a2b38;
            padding: 12px;
            text-align: left;
            
        }

        th {
            background: #2a2b38;
            color: rgba(249, 245, 253, 0.836);
            
        }

        tr:hover {
            background-color: rgba(149, 149, 149, 0.536);
        }

        .user-table {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab {
            cursor: pointer;
            padding: 8px;
            background-color: #2a2b38;
            color: rgba(249, 245, 253, 0.836);
            margin: 0;
        }

        .tab:hover {
            background-color: #557;
        }


       
        .add-button {
            background: rgba(135, 135, 135, 0.949);
            font-size: 1em; 
            font-weight: bolder;
            color: #2a2b73;
            margin-left: 10px;
            z-index: 1000;
            
            
}

       
        .add-button:hover{
            background-color: #557;
            font-size: 1.05em;

        }

    </style>
    <?php 
        if($userLevel == 1){
            include 'template/admin_nav.php';
        } else {
            include 'template/stud_nav.php';
        }
    ?>
    <div class="main-content">
    <?php
        // Check if the query was successful
        if ($result) {
            echo '<table class="user-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Class ID</th>';
            echo '<th>Class Name</th>';
            echo '<th>Units</th>';
            echo '<th>Teacher Name</th>';
            echo '<th>Actions</th>'; 
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            // Loop through the results and display each class
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['classID'] . '</td>';
                echo '<td>' . $row['className'] . '</td>';
                echo '<td>' . $row['units'] . '</td>';
                echo '<td>' . $row['teacherFirstName'] . ' ' . $row['teacherLastName'] . '</td>';
                echo '<td>';
                echo '<a href="make_sched.php?classID=' . $row['classID'] . '"><button type="button" class="add-button"><i class="fas fa-plus fa-fw"></i></button></a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Error fetching classes: ' . mysqli_error($conn) . '</p>';
        }
        ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
