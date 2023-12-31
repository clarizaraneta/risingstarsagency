<?php
// Include your database connection code

// Assuming you have a database connection established elsewhere in your code

// Replace these values with your actual database connection details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "capstone";

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the period_id from the AJAX request
    $periodId = $_POST['period_id'];

    // Fetch the period_type from the database based on the period_id
    $stmt = $pdo->prepare("SELECT period_type FROM payroll_period WHERE period_id = :period_id");
    $stmt->bindParam(':period_id', $periodId, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the result is not empty
    if ($result) {
        $periodType = $result['period_type'];
        echo $periodType;
    } else {
        echo 'Not available';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
