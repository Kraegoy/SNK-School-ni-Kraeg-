<?php
include 'template/header.php';

include 'connection.php';
include 'template/admin_nav.php';

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];

// Check if a specific user level is selected
$userLevelFilter = isset($_GET['userLevel']) ? $_GET['userLevel'] : null;

// Check if a search term is provided
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

// Query to select user information based on the user level filter and search term
$sql = "SELECT * FROM user";

// Arrays to store conditions and parameters
$conditions = [];
$params = [];

// Add conditions to the arrays based on the user level filter and search term
if ($userLevelFilter !== null) {
    $conditions[] = "account.userLevel = ?";
    $params[] = $userLevelFilter;
}

if ($searchTerm !== '') {
    $conditions[] = "(FirstName LIKE ? OR LastName LIKE ? OR MiddleName LIKE ? OR age LIKE ? OR user.accountID LIKE ?)";
    $searchTerm = "%$searchTerm%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Combine conditions into the final SQL query
if (!empty($conditions)) {
    $sql .= " INNER JOIN account ON user.accountID = account.accountID WHERE " . implode(" AND ", $conditions);
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters if needed
if (!empty($params)) {
    // Dynamically bind parameters based on their types
    $paramTypes = str_repeat('s', count($params));
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-ahZbNhi6sU/psXmdE/HB2D8am/5zBXqpXqc5uxm75UbbZqH8aaZbXbUw8Gg+XoxZkf5SM4b2bFCM02C6Id7T6sA==" crossorigin="anonymous" />
    <title>SNK</title>
    <style>

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table {
            color: rgba(249, 245, 253, 0.836);
            background: rgba(36, 36, 47, 0.4);
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

        .search-container {
            margin-top: 20px;
            margin-bottom: 10px;

        }

        .search-input {
            padding: 7px;
            background-color: #2a2b389e;
            border-radius: 8px;
            color: white;

        }

        .search-button {
            background: transparent; 
            border: none;
            cursor: pointer;
            font-size: 1em;
            color: #fff;
        }
        .search-input::placeholder {
            color: #fff;
        }
    
        .add-button {
            background: rgba(135, 135, 135, 0.949);
            font-size: 1em; 
            font-weight: bolder;
            color: #2a2b73;
            margin-left: 10px;
            z-index: 1000;
            
            
}

        th:last-child {
            background: #2a2b38;
        border: none;
        padding: 1px;
        }
        td:last-child{
            background: #2a2b38;
            border: none;
        }
        .add-button:hover{
            background-color: #557;
            font-size: 1.05em;

        }

    </style>
</head>
<body>
    <div class="main-content">
        <h1>Users</h1>

        <div>
          
            <span class="tab" onclick="filterUsers(null)">All</span>
            <span class="tab" onclick="filterUsers(1)">Admins</span>
            <span class="tab" onclick="filterUsers(2)">Teachers</span>
            <span class="tab" onclick="filterUsers(3)">Students</span>
            <div class="search-container">
                <input type="text" id="searchTerm" class="search-input" placeholder="Search...">
                <button onclick="searchUsers()" class="search-button">
                    <i class="fas fa-search"></i> 
                </button>
            </div>
        </div>

        <?php
            if ($result->num_rows > 0) {
                echo "<table class='user-table'>
                        <tr>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>Age</th>
                            <th>Account ID</th>
                            <th>Add Schedule</th> 
                        </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['userID'] . "</td>
                            <td>" . $row['FirstName'] . "</td>
                            <td>" . $row['LastName'] . "</td>
                            <td>" . $row['MiddleName'] . "</td>
                            <td>" . $row['age'] . "</td>
                            <td>" . $row['accountID'] . "</td>
                            <td><button class='add-button' onclick='addSchedule(" . $row['userID'] . ", \"" . $row['FirstName'] . "\", \"" . $row['LastName'] . "\")'><i class='fas fa-plus fa-fw'></i></button></td>
                            </button></td>
                        </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }
            ?>

    </div>

    <script>
        // JavaScript function to filter users based on user level
        function filterUsers(userLevel) {
            // Redirect to the same page with the user level filter
            window.location.href = 'display_users.php' + (userLevel !== null ? '?userLevel=' + userLevel : '');
        }

        // JavaScript function to search users
        function searchUsers() {
            var searchTerm = document.getElementById('searchTerm').value;
            window.location.href = 'display_users.php' + (searchTerm !== '' ? '?searchTerm=' + searchTerm : '');
        }

        function addSchedule(userID, FirstName, LastName) {
    window.location.href = 'add_sched_to_user.php?userID=' + userID + '&FirstName=' + FirstName + '&LastName=' + LastName;
}

    </script>
</body>
</html>

