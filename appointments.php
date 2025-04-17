<?php
session_start();
include 'db.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Get the user_id from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service_type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $stmt = $conn->prepare("INSERT INTO appointments (user_id, service_type, appointment_date, appointment_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $service, $date, $time);
    $stmt->execute();
    header("Location: appointments.php?success=1");
    exit();
}

$result = $conn->query("SELECT * FROM appointments WHERE user_id='$user_id' ORDER BY appointment_date");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - e-Governance Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('Premium Vector _ Hand drawn announcement background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }
        .appointment-card {
            border-left: 4px solid #3b82f6;
        }
        .appointment-card:hover {
            border-left-color: #2563eb;
        }
        .status-pending {
            color: #f59e0b;
        }
        .status-confirmed {
            color: #10b981;
        }
        .status-cancelled {
            color: #ef4444;
        }
        .calendar-icon {
            color: #3b82f6;
        }
        .service-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #e0f2fe;
            color: #3b82f6;
        }
    </style>
</head>
<body class="min-h-screen p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <header class="glass-effect rounded-lg p-4 mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Appointments</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <a href="home.php" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="logout.php" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Appointment Form -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-lg p-6 shadow-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Schedule New Appointment</h2>
                    
                    <?php if (isset($_GET['success'])): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                        <p><i class="fas fa-check-circle mr-2"></i> Appointment scheduled successfully!</p>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Service Type</label>
                            <select name="service_type" required class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Service</option>
                                <option value="Passport">Passport</option>
                                <option value="Aadhaar">Aadhaar</option>
                                <option value="Voter ID">Voter ID</option>
                                <option value="Driving License">Driving License</option>
                                <option value="Pan Card">Pan Card</option>
                                <option value="Birth Certificate">Birth Certificate</option>
                                <option value="Marriage Certificate">Marriage Certificate</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Date</label>
                            <div class="relative">
                                <input type="date" name="date" required class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-calendar-alt absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 mb-2">Time</label>
                            <div class="relative">
                                <input type="time" name="time" required class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="fas fa-clock absolute right-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-primary text-white px-6 py-3 rounded-lg w-full font-medium">
                            <i class="fas fa-calendar-plus mr-2"></i> Book Appointment
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Appointments List -->
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-lg p-6 shadow-lg">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">Your Appointments</h2>
                    
                    <?php if ($result->num_rows > 0): ?>
                        <div class="space-y-4">
                            <?php while ($row = $result->fetch_assoc()): 
                                // Determine status class
                                $statusClass = 'status-pending';
                                $statusIcon = 'clock';
                                $statusText = 'Pending';
                                
                                if (isset($row['status'])) {
                                    if ($row['status'] == 'Confirmed') {
                                        $statusClass = 'status-confirmed';
                                        $statusIcon = 'check-circle';
                                        $statusText = 'Confirmed';
                                    } else if ($row['status'] == 'Cancelled') {
                                        $statusClass = 'status-cancelled';
                                        $statusIcon = 'times-circle';
                                        $statusText = 'Cancelled';
                                    }
                                }
                                
                                // Format date for display
                                $formattedDate = date('F j, Y', strtotime($row['appointment_date']));
                                $formattedTime = date('g:i A', strtotime($row['appointment_time']));
                            ?>
                            <div class="appointment-card bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-start">
                                    <div class="service-icon mr-4">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <h3 class="font-semibold text-lg text-gray-800"><?= htmlspecialchars($row['service_type']) ?></h3>
                                            <span class="<?= $statusClass ?> text-sm font-medium">
                                                <i class="fas fa-<?= $statusIcon ?> mr-1"></i> <?= $statusText ?>
                                            </span>
                                        </div>
                                        <div class="mt-2 text-gray-600">
                                            <p class="flex items-center">
                                                <i class="fas fa-calendar-day mr-2 calendar-icon"></i> <?= $formattedDate ?>
                                            </p>
                                            <p class="flex items-center mt-1">
                                                <i class="fas fa-clock mr-2 calendar-icon"></i> <?= $formattedTime ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-5xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600">You don't have any appointments scheduled yet.</p>
                            <p class="text-gray-500 text-sm mt-2">Use the form to schedule your first appointment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="home.php" class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-all transform hover:scale-110 z-50">
        <i class="fas fa-home"></i>
    </a>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum date to today
            const dateInput = document.querySelector('input[type="date"]');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
            
            // Add animation to appointment cards
            const cards = document.querySelectorAll('.appointment-card');
            cards.forEach((card, index) => {
                card.style.animation = `fadeIn 0.5s ease forwards ${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>
