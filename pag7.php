<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Zahra1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch disorders
$sql = "SELECT * FROM mental_health";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Mental Health Disorders</title>
     <link rel="stylesheet" href="style5.css">
    <style>
        h3 {
            font-size: 20px;
            color: #C5705D; /* Dark pink for headers */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #C5705D;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #D0B8A8;
        }
        .button {
            background-color: #D0B8A8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
        <!-- اPage title -->
         <h1>The Importance of Mental Health</h1>
        <h2>Mental Health Disorders</h2>
        <nav>
            <!-- Navigation links between pages  -->
            <a href="page1.html">Home</a>
            <a href="page2.html">Reducing Daily Stress</a>
            <a href="page3.html">Daily Exercises</a>
            <a href="page4.html">Good Sleep</a>
            <a href="page5.html">Relaxation</a>
            <a href="page6.html">Contact Us</a>
            <a href="pag7.php">Mental Health Disorders</a>
        </nav>
    </header>
    <main>
    <h3>List of Mental Health Disorders</h3>

    <?php
    if ($result->num_rows > 0) {
        // Display the data in a table
        echo '<table>';
        echo '<tr><th>Name</th><th>Description</th><th>Symptoms</th></tr>';
        
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['symptoms'] . '</td>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo "No disorders found.";
    }
    ?>
    <p>If you are feeling sad or depressed, you can take this test:</p>
    <a href="https://www.moh.gov.sa/HealthAwareness/MedicalTools/Pages/depressiontest.aspx" target="_blank">
        Take the Depression Test - Saudi Ministry of Health
</a>
   <p style="text-align:center; font-size: 18px; color: #C5705D;">
        "We know that life can be challenging at times, but always remember that there is hope in each new day. We wish you happiness and peace of mind, and if you need support, we are here for you."
    </p>

   
    <br>
    <br>
<a href="newEmptyPHP.php" class="button">Go to admin page</a>
    </main>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
