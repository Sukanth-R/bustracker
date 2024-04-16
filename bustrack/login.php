<?php
// Database connection
$host = "localhost";
$dbname = "user_db";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Function to authenticate user
function authenticateUser($username, $password, $conn) {
    $query = "SELECT uname,password FROM user_detail WHERE uname = :username AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["user_username"]) && isset($_POST["user_password"])) {
        $username = $_POST["user_username"];
        $password = $_POST["user_password"];
        
        // Authenticate user
        $user = authenticateUser($username, $password, $conn);
        
        if ($user) {
            // Authentication successful
            // Redirect to user.html or any other page
            header("Location: user.html");
            exit();
        } else {
            // Authentication failed
            echo "Invalid username or password.";
        }
    }
}
?>
