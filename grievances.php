<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $desc = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO grievances (username, subject, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $subject, $desc);
    $stmt->execute();
    header("Location: grievances.php?submitted=1");
    exit();
}

$result = $conn->query("SELECT * FROM grievances WHERE username='$username' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Grievances</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Set the background image */
        body {
            background-image: url('download.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="p-6 bg-gray-50 bg-opacity-70"> <!-- Added bg-opacity-70 for transparency effect -->
<h1 class="text-2xl font-bold mb-4">Grievance Submission</h1>
<form method="POST" class="space-y-4 max-w-md bg-white p-6 rounded-lg shadow-md">
    <input name="subject" placeholder="Subject" required class="w-full p-2 border rounded">
    <textarea name="description" placeholder="Describe your grievance..." rows="5" required class="w-full border p-2 rounded"></textarea>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Submit</button>
</form>
<?php if (isset($_GET['submitted'])) echo "<p class='text-green-600 mt-4'>Grievance submitted successfully.</p>"; ?>
<h2 class="text-xl mt-10 mb-2">Your Grievances</h2>
<table class="w-full bg-white border mt-2">
    <tr><th class="border px-4 py-2">Subject</th><th>Status</th><th>Submitted On</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr class="text-center border-t"><td><?= $row['subject'] ?></td><td><?= $row['status'] ?></td><td><?= $row['created_at'] ?></td></tr>
    <?php endwhile; ?>
</table>
</body>
</html>
