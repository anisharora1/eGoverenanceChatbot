<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);

// Define services array with icons and descriptions
$services = [
    [
        'id' => 'aadhaar',
        'title' => 'Aadhaar Services',
        'description' => 'Apply for new Aadhaar card, update details, or download e-Aadhaar',
        'icon' => '📋',
        'color' => 'from-blue-400 to-blue-600'
    ],
    [
        'id' => 'pan',
        'title' => 'PAN Card Services',
        'description' => 'Apply for PAN card, track application status, or link with Aadhaar',
        'icon' => '💳',
        'color' => 'from-green-400 to-green-600'
    ],
    [
        'id' => 'passport',
        'title' => 'Passport Services',
        'description' => 'Apply for passport, book appointment, or track application status',
        'icon' => '🛂',
        'color' => 'from-purple-400 to-purple-600'
    ],
    [
        'id' => 'driving',
        'title' => 'Driving License',
        'description' => 'Apply for learner\'s license, renewal, or vehicle registration',
        'icon' => '🚗',
        'color' => 'from-red-400 to-red-600'
    ],
    [
        'id' => 'voter',
        'title' => 'Voter ID Services',
        'description' => 'Register as voter, download e-EPIC, or search name in voter list',
        'icon' => '🗳️',
        'color' => 'from-yellow-400 to-yellow-600'
    ],
    [
        'id' => 'certificates',
        'title' => 'Certificates',
        'description' => 'Apply for birth, death, income, or residence certificates',
        'icon' => '📜',
        'color' => 'from-pink-400 to-pink-600'
    ],
    [
        'id' => 'property',
        'title' => 'Property Services',
        'description' => 'Property registration, tax payment, or mutation services',
        'icon' => '🏠',
        'color' => 'from-indigo-400 to-indigo-600'
    ],
    [
        'id' => 'business',
        'title' => 'Business Services',
        'description' => 'Company registration, GST, or MSME registration',
        'icon' => '💼',
        'color' => 'from-teal-400 to-teal-600'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Services - e-Governance Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .service-card {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .icon-container {
            font-size: 2.5rem;
            transition: all 0.3s ease;
        }
        .service-card:hover .icon-container {
            transform: scale(1.1);
        }
        .search-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 p-6">
    <!-- Header -->
    <header class="max-w-7xl mx-auto mb-12 flex justify-between items-center bg-white rounded-lg shadow-lg p-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Government Services</h1>
            <p class="text-gray-600">Welcome, <?php echo $username; ?></p>
        </div>
        <nav class="space-x-4">
            <a href="home.php" class="text-blue-600 hover:text-blue-800">Home</a>
            <a href="appointments.php" class="text-blue-600 hover:text-blue-800">Appointments</a>
            <a href="logout.php" class="text-red-600 hover:text-red-800">Logout</a>
        </nav>
    </header>

    <!-- Search Bar -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="search-container rounded-lg shadow-lg p-4">
            <input type="text" id="searchInput" 
                   placeholder="Search for services..." 
                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   onkeyup="filterServices()">
        </div>
    </div>

    <!-- Services Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($services as $index => $service): ?>
        <div class="service-card bg-white rounded-xl shadow-lg overflow-hidden" 
             style="animation-delay: <?php echo $index * 0.1; ?>s"
             data-keywords="<?php echo strtolower($service['title'] . ' ' . $service['description']); ?>">
            <div class="p-6">
                <div class="icon-container mb-4 bg-gradient-to-r <?php echo $service['color']; ?> text-white w-16 h-16 rounded-full flex items-center justify-center">
                    <?php echo $service['icon']; ?>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo $service['title']; ?></h3>
                <p class="text-gray-600 mb-4"><?php echo $service['description']; ?></p>
                <a href="service_details.php?service=<?php echo $service['id']; ?>" 
                   class="inline-block px-4 py-2 bg-gradient-to-r <?php echo $service['color']; ?> text-white rounded-lg hover:opacity-90 transition-opacity">
                    Learn More
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
        function filterServices() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const cards = document.getElementsByClassName('service-card');

            Array.from(cards).forEach(card => {
                const keywords = card.dataset.keywords;
                if (keywords.includes(filter)) {
                    card.style.display = '';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Add animation class to cards on load
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.getElementsByClassName('service-card');
            Array.from(cards).forEach(card => {
                card.classList.add('animate-fade-in');
            });
        });
    </script>
</body>
</html>
