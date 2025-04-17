<?php
// contact.php
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
    <title>Contact Us - e-Governance Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('270618f5-b631-4c19-94bf-b21ea9c02631.jpg'); /* Replace with your image URL */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white py-4 shadow fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-700">Contact Us</h1>
            <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
        </div>
    </header>

    <main class="py-16">
        <div class="max-w-4xl mx-auto px-4 text-center bg-white bg-opacity-80 p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-bold text-blue-800 mb-6">Get in Touch</h2>
            <p class="text-gray-600 mb-8">If you have any questions or suggestions, feel free to contact us:</p>
            <form action="contact_handler.php" method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Your Name" required class="w-full p-3 border rounded">
                <input type="email" name="email" placeholder="Your Email" required class="w-full p-3 border rounded">
                <textarea name="message" placeholder="Your Message" rows="5" required class="w-full p-3 border rounded"></textarea>
                <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">Send Message</button>
            </form>
        </div>
    </main>
</body>
</html>
