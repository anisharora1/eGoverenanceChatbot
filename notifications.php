<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Get the user_id from session

// Check if there are already notifications
$check = $conn->query("SELECT COUNT(*) AS count FROM notifications WHERE user_id='$user_id'");
$countRow = $check->fetch_assoc();

if ($countRow['count'] == 0) {
    // Insert sample notifications for testing
    $conn->query("INSERT INTO notifications (user_id, title, message) VALUES ('$user_id', 'Appointment Confirmed', 'Your appointment has been confirmed.')");
    $conn->query("INSERT INTO notifications (user_id, title, message) VALUES ('$user_id', 'Grievance Resolved', 'Your grievance has been resolved.')");
    $conn->query("INSERT INTO notifications (user_id, title, message) VALUES ('$user_id', 'New Service Available', 'New service available: Voter ID update.')");
    $conn->query("INSERT INTO notifications (user_id, title, message) VALUES ('$user_id', 'Appointment Reminder', 'Reminder: Your Aadhaar appointment is tomorrow.')");
}

// Mark all notifications as read
$conn->query("UPDATE notifications SET is_read = 1 WHERE user_id='$user_id'");

// Fetch notifications
$result = $conn->query("SELECT * FROM notifications WHERE user_id='$user_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - e-Governance Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f6f8fc 0%, #e9f0f7 100%);
            min-height: 100vh;
        }
        .notification-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .unread-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #3b82f6;
        }
        .dark body {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            color: #e5e7eb;
        }
        .dark .notification-card {
            background-color: #1f2937;
            border-color: #374151;
        }
    </style>
</head>
<body class="text-gray-800">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    e-Governance Chatbot
                </h1>
                <div class="flex items-center gap-6">
                    <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                    <nav class="hidden md:flex space-x-6">
                        <a href="home.php" class="text-gray-600 hover:text-blue-600">Home</a>
                        <a href="services.php" class="text-gray-600 hover:text-blue-600">Services</a>
                        <a href="appointments.php" class="text-gray-600 hover:text-blue-600">Appointments</a>
                        <a href="notifications.php" class="text-blue-600 font-medium">Notifications</a>
                    </nav>
                    <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Your Notifications</h2>
            <div class="flex items-center">
                <span class="text-sm text-gray-500 mr-2"><?php echo $result->num_rows; ?> notifications</span>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Mark all as read</button>
            </div>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <div class="space-y-4">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="notification-card bg-white rounded-lg border border-gray-200 p-4 flex items-start">
                        <div class="notification-icon bg-blue-100 text-blue-600 mr-4">
                            <?php 
                            // Display different icons based on notification title
                            if (strpos(strtolower($row['title']), 'appointment') !== false) {
                                echo '📅';
                            } elseif (strpos(strtolower($row['title']), 'grievance') !== false) {
                                echo '✅';
                            } elseif (strpos(strtolower($row['title']), 'service') !== false) {
                                echo '🔔';
                            } else {
                                echo '📢';
                            }
                            ?>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-semibold text-gray-900"><?php echo htmlspecialchars($row['title']); ?></h3>
                                <span class="text-xs text-gray-500">
                                    <?php 
                                    $date = new DateTime($row['created_at']);
                                    echo $date->format('M d, Y h:i A');
                                    ?>
                                </span>
                            </div>
                            <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($row['message']); ?></p>
                        </div>
                        <?php if (!$row['is_read']): ?>
                            <div class="unread-indicator ml-2"></div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg border border-gray-200 p-8 text-center">
                <div class="text-5xl mb-4">📭</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No notifications yet</h3>
                <p class="text-gray-600">You don't have any notifications at the moment.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <p class="text-center text-gray-500 text-sm">&copy; 2025 e-Governance Chatbot. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Add any JavaScript functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add click event to mark all as read button
            const markAllReadBtn = document.querySelector('button');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    // This would typically make an AJAX call to mark all as read
                    alert('All notifications marked as read');
                });
            }
        });
    </script>
</body>
</html>
