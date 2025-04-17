<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
$user_id = $_SESSION['user_id']; // Get the user_id from session
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>e-Governance Chatbot</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      scroll-behavior: smooth;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f6f8fc 0%, #e9f0f7 100%);
      min-height: 100vh;
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
    .dark body {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      color: #e5e7eb;
    }
    .dark .glass-effect {
      background: rgba(31, 41, 55, 0.9);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    .float-animation {
      animation: float 3s ease-in-out infinite;
    }
    
    /* Feedback animation */
    @keyframes slideIn {
      0% { transform: translateX(-50px); opacity: 0; }
      100% { transform: translateX(0); opacity: 1; }
    }
    .feedback-animation {
      animation: slideIn 0.8s ease-out forwards;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    .pulse-animation {
      animation: pulse 2s ease-in-out infinite;
    }
    
    /* Mobile menu animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
      animation: fadeIn 0.3s ease-out forwards;
    }
    
    /* Mobile menu styles */
    #mobile-menu {
      transition: all 0.3s ease-in-out;
    }
    #mobile-menu.hidden {
      display: none;
    }
    #mobile-menu:not(.hidden) {
      display: block;
    }
  </style>
  <script>
    function openChatbot() {
      window.location.href = 'chatbot.php';
    }
    function toggleDarkMode() {
      document.body.classList.toggle("dark");
      localStorage.setItem("darkMode", document.body.classList.contains("dark") ? "enabled" : "disabled");
    }
    window.onload = () => {
      if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark");
      }
    };
  </script>
</head>
<body class="text-gray-800">
  <header class="glass-effect fixed top-0 left-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-4 py-4">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">
          e-Governance Chatbot
        </h1>
        <div class="flex items-center gap-6">
          <span class="text-gray-600 dark:text-gray-300 hidden md:inline">Welcome, <?php echo $username; ?>!</span>
          <nav class="hidden md:flex space-x-6">
            <a href="services.php" class="nav-link text-gray-600 dark:text-gray-300">Services</a>
            <a href="appointments.php" class="nav-link text-gray-600 dark:text-gray-300">Appointments</a>
            <a href="notifications.php" class="nav-link text-gray-600 dark:text-gray-300">Notifications</a>
          </nav>
          <button onclick="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <span class="dark:hidden">🌙</span>
            <span class="hidden dark:inline">☀️</span>
          </button>
          <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
          <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium hidden md:inline">Logout</a>
        </div>
      </div>
      
      <!-- Mobile Menu -->
      <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
        <div class="flex flex-col space-y-4">
          <span class="text-gray-600 dark:text-gray-300">Welcome, <?php echo $username; ?>!</span>
          <nav class="flex flex-col space-y-3">
            <a href="services.php" class="nav-link text-gray-600 dark:text-gray-300 py-2">Services</a>
            <a href="appointments.php" class="nav-link text-gray-600 dark:text-gray-300 py-2">Appointments</a>
            <a href="notifications.php" class="nav-link text-gray-600 dark:text-gray-300 py-2">Notifications</a>
          </nav>
          <a href="logout.php" class="text-red-600 hover:text-red-700 font-medium py-2">Logout</a>
        </div>
      </div>
    </div>
  </header>

  <main class="pt-24 pb-16">
    <section class="max-w-7xl mx-auto px-4 py-16">
      <div class="text-center mb-16">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
          Your Digital Government Assistant
        </h2>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Access public services, ask questions, and get instant support — all in one place.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="card glass-effect p-6 rounded-xl">
          <div class="text-blue-600 mb-4 text-3xl">💬</div>
          <h3 class="text-xl font-semibold mb-2">Chat with AI Assistant</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Get instant answers to your questions about government services.</p>
          <button onclick="openChatbot()" class="btn-primary text-white px-6 py-2 rounded-lg w-full">
            Start Chat
          </button>
        </div>

        <div class="card glass-effect p-6 rounded-xl">
          <div class="text-indigo-600 mb-4 text-3xl">📅</div>
          <h3 class="text-xl font-semibold mb-2">Book Appointments</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Schedule meetings with government officials easily.</p>
          <a href="appointments.php" class="btn-primary text-white px-6 py-2 rounded-lg w-full inline-block text-center">
            Book Now
          </a>
        </div>

        <div class="card glass-effect p-6 rounded-xl">
          <div class="text-purple-600 mb-4 text-3xl">📢</div>
          <h3 class="text-xl font-semibold mb-2">Notifications</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Stay updated with important government announcements.</p>
          <a href="notifications.php" class="btn-primary text-white px-6 py-2 rounded-lg w-full inline-block text-center">
            View Updates
          </a>
        </div>
      </div>
    </section>

    <section class="bg-white dark:bg-gray-800 py-16">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">About Our Platform</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-4">
              The e-Governance Chatbot is a digital assistant designed to simplify access to government services. Our aim is to provide a user-friendly platform where citizens can easily get the information they need.
            </p>
            <p class="text-gray-600 dark:text-gray-300">
              Our chatbot is equipped to answer frequently asked questions, provide guidance on various procedures, and make government services more accessible to the public.
            </p>
          </div>
          <div class="float-animation">
            <img src="Tecnología Educativa.jpg" alt="Digital Government" class="rounded-lg shadow-xl">
          </div>
        </div>
      </div>
    </section>
  </main>

  <section id="feedback" class="py-16 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">We Value Your Feedback</h2>
        <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">Help us improve our services by sharing your thoughts and suggestions.</p>
      </div>
      
      <div class="max-w-3xl mx-auto">
        <div class="glass-effect p-8 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105">
          <form action="feedback_handler.php" method="POST" class="space-y-6">
            <div>
              <label for="feedback-text" class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">Your Feedback</label>
              <textarea id="feedback-text" name="feedback" rows="5" required placeholder="Share your thoughts with us..." 
                class="w-full p-4 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>
            <div class="flex items-center justify-center space-x-2">
              <label for="rating" class="text-gray-700 dark:text-gray-300 font-medium">Rating:</label>
              <div class="flex space-x-1">
                <input type="radio" id="rating5" name="rating" value="5" checked class="hidden peer" />
                <label for="rating5" class="cursor-pointer text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="rating4" name="rating" value="4" class="hidden peer" />
                <label for="rating4" class="cursor-pointer text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="rating3" name="rating" value="3" class="hidden peer" />
                <label for="rating3" class="cursor-pointer text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="rating2" name="rating" value="2" class="hidden peer" />
                <label for="rating2" class="cursor-pointer text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors">★</label>
                
                <input type="radio" id="rating1" name="rating" value="1" class="hidden peer" />
                <label for="rating1" class="cursor-pointer text-2xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-400 transition-colors">★</label>
              </div>
            </div>
            <div class="flex justify-center">
              <button type="submit" class="btn-primary text-white px-8 py-3 rounded-lg transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                Submit Feedback
              </button>
            </div>
          </form>
        </div>
        
        <!-- Sample Feedback Display -->
        <div class="mt-12">
          <h3 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Recent Feedback</h3>
          <div class="glass-effect p-6 rounded-xl shadow-lg overflow-hidden feedback-animation">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold pulse-animation">
                  U
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <h4 class="font-semibold text-gray-900 dark:text-white">User</h4>
                  <div class="flex items-center">
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                    <span class="text-yellow-400 text-lg">★</span>
                  </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mt-2 italic">
                  "This e-governance platform has made accessing government services so much easier! The chatbot is incredibly helpful and the appointment booking system works seamlessly."
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Posted 2 days ago</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <button onclick="openChatbot()" class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-all transform hover:scale-110 z-50">
    <span class="text-2xl">💬</span>
  </button>

  <footer class="glass-effect py-12">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
          <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Follow Us</h4>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Facebook</a>
            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Twitter</a>
            <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">LinkedIn</a>
          </div>
        </div>
        <div>
          <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h4>
          <ul class="space-y-2">
            <li><a href="services.php" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Services</a></li>
            <li><a href="grievances.php" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Grievances</a></li>
            <li><a href="contact.php" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Contact Info</h4>
          <p class="text-gray-600 dark:text-gray-300">Email: support@egovernance.com</p>
          <p class="text-gray-600 dark:text-gray-300">Phone: +1 234 567 890</p>
        </div>
      </div>
      <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center text-gray-600 dark:text-gray-300">
        &copy; 2025 e-Governance Chatbot. All rights reserved.
      </div>
    </div>
  </footer>
  <script>
    // Mobile menu functionality
    document.addEventListener('DOMContentLoaded', function() {
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');
      
      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
          mobileMenu.classList.toggle('hidden');
          // Add animation classes
          if (!mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('animate-fadeIn');
          } else {
            mobileMenu.classList.remove('animate-fadeIn');
          }
        });
      }
    });
  </script>
</body>
</html>
