<?php
$host = "localhost";
$user = "root";       // XAMPP default user
$pass = "";           // XAMPP default password is empty
$db = "egov_chatbot";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");

// Function to safely escape user input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Function to execute a query and return the result
function execute_query($sql) {
    global $conn;
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    return $result;
}

// Function to get a single row from a query
function get_row($sql) {
    $result = execute_query($sql);
    return $result->fetch_assoc();
}

// Function to get multiple rows from a query
function get_rows($sql) {
    $result = execute_query($sql);
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}
?>