<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Fetch recent 7 user questions
$recentSearches = [];
$conn = new mysqli("localhost", "root", "", "egov_chatbot");
if (!$conn->connect_error) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT user_message FROM chat_logs ORDER BY created_at DESC LIMIT 7");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $recentSearches[] = $row['user_message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>e-Governance Chatbot</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f6f8fc 0%, #e9f0f7 100%);
      min-height: 100vh;
    }
    
    .chat-container {
      height: calc(100vh - 180px);
      max-height: 600px;
    }
    
    .chat-box {
      height: calc(100% - 70px);
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    .chat-box::-webkit-scrollbar {
      width: 6px;
    }
    
    .chat-box::-webkit-scrollbar-track {
      background: #f7fafc;
      border-radius: 10px;
    }
    
    .chat-box::-webkit-scrollbar-thumb {
      background-color: #cbd5e0;
      border-radius: 10px;
    }
    
    .message-bubble {
      max-width: 80%;
      word-wrap: break-word;
    }
    
    .user-message {
      background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
      color: white;
      border-radius: 18px 18px 4px 18px;
    }
    
    .bot-message {
      background: white;
      color: #2d3748;
      border-radius: 18px 18px 18px 4px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .typing-indicator {
      display: flex;
      align-items: center;
      gap: 4px;
    }
    
    .typing-dot {
      width: 8px;
      height: 8px;
      background-color: #cbd5e0;
      border-radius: 50%;
      animation: typing 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) { animation-delay: 0s; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
      0%, 60%, 100% { transform: translateY(0); }
      30% { transform: translateY(-5px); }
    }
    
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .suggestion-chip {
      transition: all 0.2s ease;
    }
    
    .suggestion-chip:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .input-container {
      position: relative;
    }
    
    .input-container input {
      transition: all 0.3s ease;
    }
    
    .input-container input:focus {
      box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
    }
    
    .send-button {
      transition: all 0.2s ease;
    }
    
    .send-button:hover {
      transform: scale(1.05);
    }
    
    .send-button:active {
      transform: scale(0.95);
    }
    
    .recent-search-item {
      transition: all 0.2s ease;
    }
    
    .recent-search-item:hover {
      transform: translateX(5px);
    }
    
    .dark-mode {
      background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
      color: #f7fafc;
    }
    
    .dark-mode .bot-message {
      background: #2d3748;
      color: #f7fafc;
    }
    
    .dark-mode .chat-box::-webkit-scrollbar-track {
      background: #2d3748;
    }
    
    .dark-mode .chat-box::-webkit-scrollbar-thumb {
      background-color: #4a5568;
    }
    
    .dark-mode .typing-dot {
      background-color: #4a5568;
    }
    
    .dark-mode .bg-white {
      background-color: #1a202c;
    }
    
    .dark-mode .text-gray-800 {
      color: #f7fafc;
    }
    
    .dark-mode .border-gray-200 {
      border-color: #4a5568;
    }
    
    .dark-mode .text-gray-600 {
      color: #cbd5e0;
    }
    
    .dark-mode .bg-gray-50 {
      background-color: #2d3748;
    }
    
    .dark-mode .bg-gray-100 {
      background-color: #2d3748;
    }
    
    .dark-mode .hover\:bg-gray-100:hover {
      background-color: #4a5568;
    }
    
    .dark-mode .text-gray-400 {
      color: #a0aec0;
    }
    
    .dark-mode .bg-blue-50 {
      background-color: #2c5282;
    }
    
    .dark-mode .text-blue-900 {
      color: #ebf8ff;
    }
    
    .dark-mode .hover\:bg-blue-100:hover {
      background-color: #2b6cb0;
    }
    
    .dark-mode .bg-gray-200 {
      background-color: #4a5568;
    }
    
    .dark-mode .text-gray-900 {
      color: #f7fafc;
    }
    
    .dark-mode .hover\:bg-gray-300:hover {
      background-color: #718096;
    }
    
    .dark-mode .border-gray-300 {
      border-color: #4a5568;
    }
    
    .dark-mode .text-green-700 {
      color: #9ae6b4;
    }
    
    .dark-mode .text-red-600 {
      color: #feb2b2;
    }
    
    .dark-mode .hover\:underline:hover {
      text-decoration-color: #cbd5e0;
    }
    
    .dark-mode .border-blue-500 {
      border-color: #4299e1;
    }
    
    .dark-mode .shadow-xl {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }
    
    .dark-mode .bg-white {
      background-color: #1a202c;
    }
    
    .dark-mode .text-gray-800 {
      color: #f7fafc;
    }
    
    .dark-mode .border-gray-200 {
      border-color: #4a5568;
    }
    
    .dark-mode .text-gray-600 {
      color: #cbd5e0;
    }
    
    .dark-mode .bg-gray-50 {
      background-color: #2d3748;
    }
    
    .dark-mode .bg-gray-100 {
      background-color: #2d3748;
    }
    
    .dark-mode .hover\:bg-gray-100:hover {
      background-color: #4a5568;
    }
    
    .dark-mode .text-gray-400 {
      color: #a0aec0;
    }
    
    .dark-mode .bg-blue-50 {
      background-color: #2c5282;
    }
    
    .dark-mode .text-blue-900 {
      color: #ebf8ff;
    }
    
    .dark-mode .hover\:bg-blue-100:hover {
      background-color: #2b6cb0;
    }
    
    .dark-mode .bg-gray-200 {
      background-color: #4a5568;
    }
    
    .dark-mode .text-gray-900 {
      color: #f7fafc;
    }
    
    .dark-mode .hover\:bg-gray-300:hover {
      background-color: #718096;
    }
    
    .dark-mode .border-gray-300 {
      border-color: #4a5568;
    }
    
    .dark-mode .text-green-700 {
      color: #9ae6b4;
    }
    
    .dark-mode .text-red-600 {
      color: #feb2b2;
    }
    
    .dark-mode .hover\:underline:hover {
      text-decoration-color: #cbd5e0;
    }
    
    .dark-mode .border-blue-500 {
      border-color: #4299e1;
    }
    
    .dark-mode .shadow-xl {
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">
  <div class="w-full max-w-5xl bg-white shadow-xl rounded-lg overflow-hidden border-t-8 border-blue-500 fade-in">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-4 flex justify-between items-center">
      <div class="flex items-center">
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3">
          <i class="fas fa-robot text-blue-600 text-xl"></i>
        </div>
        <div>
          <h2 class="text-xl font-bold text-white">e-Gov Chatbot</h2>
          <p class="text-blue-100 text-sm">Your Digital Government Assistant</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <button id="dark-mode-toggle" class="text-white hover:text-blue-200 transition-colors">
          <i class="fas fa-moon text-lg"></i>
        </button>
        <a href="download_chat.php" class="text-white hover:text-blue-200 transition-colors">
          <i class="fas fa-download text-lg"></i>
        </a>
        <a href="logout.php" class="text-white hover:text-blue-200 transition-colors">
          <i class="fas fa-sign-out-alt text-lg"></i>
        </a>
      </div>
    </div>

    <div class="flex flex-col md:flex-row h-full">
      <!-- Chat Section -->
      <div class="flex-1 p-4 flex flex-col chat-container">
        <div id="chat-box" class="chat-box p-4 bg-gray-50 rounded-lg mb-4">
          <!-- Welcome message -->
          <div class="text-left mb-4 fade-in flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
              <i class="fas fa-robot text-blue-600"></i>
            </div>
            <div class="message-bubble bot-message p-3">
              <p>Hello! I'm your e-Governance assistant. How can I help you today?</p>
            </div>
          </div>
        </div>

        <!-- Quick suggestions -->
        <div id="suggestion-box" class="mb-3 flex flex-wrap gap-2 hidden">
          <!-- Suggestions will be added here -->
        </div>

        <!-- Input form -->
        <form id="chat-form" class="mt-auto">
          <div class="input-container flex items-center gap-2">
            <input type="text" id="user-input" class="flex-1 border border-gray-300 px-4 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Type your message here..." autocomplete="off" required />
            <button type="submit" class="send-button bg-blue-600 hover:bg-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </form>
      </div>

      <!-- Right Panel: Recent Searches -->
      <div class="w-full md:w-1/3 border-t md:border-t-0 md:border-l border-gray-200 p-4 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
          <i class="fas fa-history mr-2 text-blue-600"></i> Recent Searches
        </h3>
        <div class="space-y-2">
          <?php if (empty($recentSearches)): ?>
            <p class="text-gray-500 text-sm italic">No recent searches yet</p>
          <?php else: ?>
            <?php foreach ($recentSearches as $search): ?>
              <div class="recent-search-item bg-white text-gray-800 px-3 py-2 rounded-lg shadow-sm hover:bg-blue-50 cursor-pointer flex items-center" onclick="document.getElementById('user-input').value = '<?= htmlspecialchars($search, ENT_QUOTES) ?>';">
                <i class="fas fa-search text-blue-500 mr-2 text-sm"></i>
                <span class="text-sm"><?= htmlspecialchars($search) ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    const form = document.getElementById("chat-form");
    const input = document.getElementById("user-input");
    const chatBox = document.getElementById("chat-box");
    const suggestionBox = document.getElementById("suggestion-box");
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    
    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.body.classList.add('dark-mode');
      darkModeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
    }
    
    // Toggle dark mode
    darkModeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
        darkModeToggle.innerHTML = '<i class="fas fa-sun text-lg"></i>';
      } else {
        localStorage.setItem('darkMode', 'disabled');
        darkModeToggle.innerHTML = '<i class="fas fa-moon text-lg"></i>';
      }
    });
    
    // Quick suggestions
    const quickSuggestions = [
      "How do I apply for a passport?",
      "What documents do I need for voter ID?",
      "How to pay property tax online?",
      "Schedule an appointment for driving license",
      "Check my Aadhaar card status"
    ];
    
    // Show quick suggestions on page load
    window.addEventListener('load', () => {
      showQuickSuggestions();
    });
    
    function showQuickSuggestions() {
      suggestionBox.innerHTML = '';
      quickSuggestions.forEach(suggestion => {
        const chip = document.createElement('div');
        chip.className = 'suggestion-chip bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-blue-200';
        chip.textContent = suggestion;
        chip.addEventListener('click', () => {
          input.value = suggestion;
          suggestionBox.classList.add('hidden');
          input.focus();
        });
        suggestionBox.appendChild(chip);
      });
      suggestionBox.classList.remove('hidden');
    }
    
    // Handle input for dynamic suggestions
    input.addEventListener("input", async () => {
      const query = input.value;
      if (query.length < 2) {
        showQuickSuggestions();
        return;
      }
      
      try {
        const res = await fetch("suggestions.php?q=" + encodeURIComponent(query));
        const suggestions = await res.json();
        if (suggestions.length > 0) {
          suggestionBox.innerHTML = '';
          suggestions.forEach(suggestion => {
            const chip = document.createElement('div');
            chip.className = 'suggestion-chip bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm cursor-pointer hover:bg-blue-200';
            chip.textContent = suggestion;
            chip.addEventListener('click', () => {
              input.value = suggestion;
              suggestionBox.classList.add('hidden');
              input.focus();
            });
            suggestionBox.appendChild(chip);
          });
          suggestionBox.classList.remove('hidden');
        } else {
          suggestionBox.classList.add('hidden');
        }
      } catch (error) {
        console.error('Error fetching suggestions:', error);
        suggestionBox.classList.add('hidden');
      }
    });
    
    // Focus input on page load
    window.addEventListener('load', () => {
      input.focus();
    });
    
    // Handle form submission
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const userText = input.value.trim();
      if (!userText) return;
      
      // Hide suggestions when sending a message
      suggestionBox.classList.add('hidden');
      
      const timestamp = new Date().toLocaleString('en-GB', {
        hour: '2-digit', minute: '2-digit'
      });
      
      // Add user message to chat
      addMessageToChat('user', userText, timestamp);
      
      // Clear input
      input.value = "";
      
      // Show typing indicator
      const typingIndicator = addTypingIndicator();
      
      try {
        // Send message to backend
        const response = await fetch("chatbot_backend.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "message=" + encodeURIComponent(userText)
        });
        
        // Remove typing indicator
        chatBox.removeChild(typingIndicator);
        
        if (response.ok) {
          const reply = await response.text();
          
          // Add bot response to chat
          addMessageToChat('bot', reply, timestamp);
        } else {
          // Handle error
          addMessageToChat('bot', 'Sorry, I encountered an error. Please try again later.', timestamp);
        }
      } catch (error) {
        // Remove typing indicator
        chatBox.removeChild(typingIndicator);
        
        // Handle error
        addMessageToChat('bot', 'Sorry, I encountered an error. Please try again later.', timestamp);
        console.error('Error:', error);
      }
    });
    
    function addMessageToChat(sender, message, timestamp) {
      const messageDiv = document.createElement('div');
      messageDiv.className = `text-${sender === 'user' ? 'right' : 'left'} mb-4 fade-in flex items-${sender === 'user' ? 'end' : 'start'} gap-3 ${sender === 'user' ? 'justify-end' : ''}`;
      
      if (sender === 'user') {
        messageDiv.innerHTML = `
          <div class="message-bubble user-message p-3">
            <p>${message}</p>
          </div>
          <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user text-white text-xs"></i>
          </div>
        `;
      } else {
        messageDiv.innerHTML = `
          <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
            <i class="fas fa-robot text-blue-600"></i>
          </div>
          <div class="message-bubble bot-message p-3">
            <p>${message}</p>
          </div>
        `;
      }
      
      chatBox.appendChild(messageDiv);
      chatBox.scrollTop = chatBox.scrollHeight;
    }
    
    function addTypingIndicator() {
      const typingDiv = document.createElement('div');
      typingDiv.className = 'text-left mb-4 fade-in flex items-start gap-3';
      typingDiv.innerHTML = `
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
          <i class="fas fa-robot text-blue-600"></i>
        </div>
        <div class="message-bubble bot-message p-3">
          <div class="typing-indicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
          </div>
        </div>
      `;
      
      chatBox.appendChild(typingDiv);
      chatBox.scrollTop = chatBox.scrollHeight;
      
      return typingDiv;
    }
  </script>
</body>
</html>
