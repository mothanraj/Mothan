<?php
$servername = "localhost";
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "mothan_search_engine";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_result = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $conn->real_escape_string($_POST['search']);
    $sql = "SELECT name, url FROM websites WHERE name LIKE '%$search%' OR url LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            header("Location: " . $row['url']);
            exit();
        } else {
            while ($row = $result->fetch_assoc()) {
                $search_result .= "<div class='result'><a href='" . $row['url'] . "' target='_blank'>" . $row['name'] . "</a></div>";
            }
        }
    } else {
        $search_result = "<div class='no-result'>No results found</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOTHAN Search Engine</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Body Styling with Background Image */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('tim-zankert-1YFt4rpHKp0-unsplash.jpg') center center/cover no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        
        /* Overlay for Background Image */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Adjust opacity as needed */
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative; /* Ensure overlay covers the container */
            z-index: 1; /* Ensure container is above overlay */
        }
        
        /* Logo Styling */
        .logo {
            font-size: 48px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        /* Search Bar Styling */
        .search-bar {
            width: 80%;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 30px;
            font-size: 18px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .search-bar:focus {
            border-color: #0072ff;
            box-shadow: 0px 0px 10px rgba(0, 114, 255, 0.2);
        }
        
        /* Search Button Styling */
        .search-button {
            padding: 15px 30px;
            border-radius: 30px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        
        .search-button:hover {
            background-color: #45a049;
        }
        
        /* Search Results Styling */
        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        
        .result a {
            text-decoration: none;
            color: #0072ff;
            font-size: 18px;
            transition: color 0.3s ease;
        }
        
        .result a:hover {
            color: #004C99;
        }
        
        /* No Results Styling */
        .no-result {
            margin-top: 20px;
            padding: 10px;
            color: #555;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="logo">MOTHAN</div>
        <form method="post" action="">
            <input type="text" name="search" class="search-bar" placeholder="Search for a website...">
            <button type="submit" class="search-button">Search</button>
        </form>
        <div>
            <?php echo $search_result; ?>
        </div>
    </div>
</body>
</html>
