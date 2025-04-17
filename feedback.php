<?php
// feedback.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - e-Governance Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('FEEDBACK Concept with icons by IhorZigor on….jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            scroll-behavior: smooth;
            min-height: 100vh; /* Ensure the body fills the viewport */
            display: flex;
            flex-direction: column;
            font-family: 'Inter', sans-serif;
        }

        main {
            max-height: calc(100vh - 80px); /* Make main section scrollable, considering header height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Mobile menu styles */
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-menu.hidden {
            transform: translateY(-100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="glass-effect fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
                    e-Governance Chatbot
                </h1>
                <div class="flex items-center gap-6">
                    <span class="text-gray-600 hidden md:inline">Welcome, <?php echo $username; ?>!</span>
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex space-x-6">
                        <a href="home.php" class="nav-link text-gray-600 hover:text-blue-600">Home</a>
                        <a href="services.php" class="nav-link text-gray-600 hover:text-blue-600">Services</a>
                        <a href="appointments.php" class="nav-link text-gray-600 hover:text-blue-600">Appointments</a>
                        <a href="notifications.php" class="nav-link text-gray-600 hover:text-blue-600">Notifications</a>
                        <a href="feedback.php" class="nav-link text-blue-600 font-medium">Feedback</a>
                    </nav>
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="md:hidden text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium">Logout</a>
                </div>
            </div>
        </div>
        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-4 py-3 space-y-3">
                <div class="text-gray-600 py-2">Welcome, <?php echo $username; ?>!</div>
                <a href="home.php" class="block py-2 text-gray-600 hover:text-blue-600">Home</a>
                <a href="services.php" class="block py-2 text-gray-600 hover:text-blue-600">Services</a>
                <a href="appointments.php" class="block py-2 text-gray-600 hover:text-blue-600">Appointments</a>
                <a href="notifications.php" class="block py-2 text-gray-600 hover:text-blue-600">Notifications</a>
                <a href="feedback.php" class="block py-2 text-blue-600 font-medium">Feedback</a>
            </div>
        </div>
    </header>

    <main class="py-16 px-4">
        <div class="max-w-3xl mx-auto text-center bg-white bg-opacity-80 p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-blue-800 mb-6">We Value Your Feedback</h2>
            <form action="feedback_handler.php" method="POST" class="space-y-4">
                <textarea name="feedback" rows="5" required placeholder="Your feedback..." class="w-full p-4 border rounded-lg"></textarea>
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Submit Feedback</button>
            </form>
        </div>
    </main>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
