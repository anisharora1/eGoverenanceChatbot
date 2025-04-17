<?php
session_start();
require 'db.php'; // assumes this connects to your database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "You must be logged in to submit feedback.";
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $message = trim($_POST['feedback']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5; // Get rating from form or default to 5

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, rating, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $rating, $message);

        if ($stmt->execute()) {
            echo "Thank you for your feedback!";
        } else {
            echo "Error saving feedback. Please try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please enter your feedback.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
