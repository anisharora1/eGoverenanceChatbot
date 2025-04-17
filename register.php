<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username']);
    $email = sanitize_input($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Username or email already exists!";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            // Registration successful
            header("Location: login.html?registered=1");
            exit();
        } else {
            $error = "Registration failed. Please try again. Error: " . $conn->error;
        }
    }
}

// If there was an error, display it
if (isset($error)) {
    echo "<div style='background-color: #ffebee; color: #c62828; padding: 10px; margin: 10px; border-radius: 5px;'>";
    echo "Error: " . htmlspecialchars($error);
    echo "</div>";
}
?>

<!DOCTYPE html>