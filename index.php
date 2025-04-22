<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sports Scoreboard</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #232526, #414345);
      color: white;
    }

    header {
      background-color: #111;
      padding: 20px 0;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 50px;
      color: #00ffcc;
      text-shadow: 2px 2px 4px black;
    }

    .welcome {
      text-align: center;
      margin-top: 20px;
      font-size: 20px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      padding: 40px 20px;
    }

    .card {
      background-color: #1e1e1e;
      border-radius: 20px;
      width: 280px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 30px rgba(0, 255, 204, 0.3);
    }

    .card img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      background-color: white;
      margin-bottom: 15px;
    }

    .card a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #00ffcc;
      color: black;
      font-weight: bold;
      border-radius: 8px;
      text-decoration: none;
      margin-bottom: 10px;
      transition: background 0.2s ease;
    }

    .card a:hover {
      background-color: #00bfa5;
    }

    .rules {
      text-align: left;
      font-size: 15px;
      margin-top: 15px;
      background-color: #2a2a2a;
      padding: 15px;
      border-radius: 10px;
      line-height: 1.5;
    }

    .rules h3 {
      color: #00ffcc;
      margin-top: 0;
    }

    .logout {
      text-align: center;
      margin: 20px;
    }

    .logout a {
      color: #00ffcc;
      text-decoration: none;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .card {
        width: 90%;
      }

      header h1 {
        font-size: 35px;
      }
    }
    .a1{
      text-decoration: none; 
      color: #00ffcc;
    }
  </style>
</head>
<body>

  <header>
    <h1>🏆 Sports Scoreboard</h1>
  </header>

  <div class="welcome">
    <?php
    if (isset($_SESSION['username'])) {
      echo "<p>Welcome, <strong>{$_SESSION['username']}</strong>!</p>";
    } else {
      echo "<p>Welcome, Guest! <a class='a1' href='login.php' >Login</a> or <a class='a1' href='signup.php'>Sign Up</a></p>";
    }
    ?>
  </div>

  <div class="container">
    <!-- Basketball -->
    <div class="card">
      <img src="https://i.pinimg.com/474x/ab/85/e0/ab85e039c40754794c95d88b4d08cbf2.jpg" alt="Basketball"/>
      <center><a href="bask.php" target="_blank">Basketball</a></center>
      <div class="rules">
        <h3>Rules:</h3>
        <ul>
          <li>5 players per team on court.</li>
          <li>Match is played in 4 quarters of 12 minutes each.</li>
          <li>Basket = 2 points, beyond arc = 3 points.</li>
          <li>Dribbling is mandatory when moving with the ball.</li>
        </ul>
      </div>
    </div>

    <!-- Cricket -->
    <div class="card">
      <img src="https://i.pinimg.com/474x/5e/4f/4b/5e4f4bf6f8a59049b6d0d3c7530a0807.jpg" alt="Cricket"/>
      <center><a href="crick1.php" target="_blank">Cricket</a></center>
      <div class="rules">
        <h3>Rules:</h3>
        <ul>
          <li>Each team has 11 players.</li>
          <li>Match is divided into overs (6 balls per over).</li>
          <li>Runs are scored by running or hitting boundaries.</li>
          <li>Wickets can fall via bowled, caught, run-out, etc.</li>
        </ul>
      </div>
    </div>

    <!-- Football -->
    <div class="card">
      <img src="https://i.pinimg.com/474x/29/36/20/293620a773a8ff5a5326101b6b721fb3.jpg" alt="Football"/>
      <center><a href="foot.php" target="_blank">Football</a></center>
      <div class="rules">
        <h3>Rules:</h3>
        <ul>
          <li>11 players per team on field.</li>
          <li>Match duration: 90 mins (2 halves).</li>
          <li>Only goalkeeper can use hands.</li>
          <li>Goal = 1 point. Team with more goals wins.</li>
        </ul>
      </div>
    </div>
  </div>
<!-- Add this card to the container div in index.php -->
<center><div class="card">
    <img src="https://i.pinimg.com/474x/9c/76/9f/9c769f46a0bbfbff79e1a23a766f1322.jpg" alt="All Matches"/>
    <center><a href="all_matches.php" target="_blank">All Matches</a></center>
    <div class="rules">
        <h3>Features:</h3>
        <ul>
            <li>View all your saved matches</li>
            <li>Track your team's performance</li>
            <li>Compare scores across games</li>
            <li>Manage your match history</li>
        </ul>
    </div>
</div></center>
  <?php if (isset($_SESSION['username'])): ?>
    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
  <?php endif; ?>
  <footer style="background-color: #111; padding: 30px 20px; text-align: center; color: #bbb; margin-top: 40px;">
    <div style="font-size: 18px; font-weight: bold; color: #00ffcc; margin-bottom: 10px;">About Us</div>
    <p style="margin: 0 0 10px 0;">This sports scoreboard website is built by passionate developers for sports lovers.</p>
    <p style="margin: 0;">© 2025 Sports Scoreboard. All rights reserved.</p>
    <p style="margin: 5px 0 0 0; font-size: 14px; color: #888;">Terms and Conditions apply. For educational purposes only.</p>
  </footer>

<!-- Chatbot Container -->
<div id="chatbot-container" style="position:fixed; bottom:20px; right:20px; z-index:1000;">
    <!-- Chat icon -->
    <div id="chatbot-icon" style="width:60px; height:60px; background-color:#00ffcc; border-radius:50%; display:flex; justify-content:center; align-items:center; cursor:pointer; box-shadow:0 2px 10px rgba(0,0,0,0.2);">
        <span style="font-size:24px;">🤖</span>
    </div>
    
    <!-- Chat window -->
    <div id="chatbot-window" style="display:none; width:300px; height:400px; background:#1e1e1e; border:1px solid #00ffcc; border-radius:10px 10px 0 0; flex-direction:column;">
        <!-- Header -->
        <div style="background:#00ffcc; color:#111; padding:10px; border-radius:10px 10px 0 0; font-weight:bold; display:flex; justify-content:space-between;">
            <span>Game Advisor</span>
            <span id="close-chat" style="cursor:pointer;">✕</span>
        </div>
        
        <!-- Messages -->
        <div id="chat-messages" style="flex:1; overflow-y:auto; padding:10px; color:white;"></div>
        
        <!-- Input -->
        <div style="padding:10px; border-top:1px solid #00ffcc; background:#2a2a2a;">
            <input type="text" id="user-input" style="width:250px; padding:8px; border:none; border-radius:4px; background:#1e1e1e; color:white;" placeholder="Ask about any game...">
        </div>
    </div>
</div>

<!-- Feedback Container -->
<div id="feedback-container" style="position:fixed; bottom:90px; right:20px; z-index:1000;">
    <!-- Feedback icon -->
    <div id="feedback-icon" style="width:60px; height:60px; background-color:#ff9900; border-radius:50%; display:flex; justify-content:center; align-items:center; cursor:pointer; box-shadow:0 2px 10px rgba(0,0,0,0.2);">
        <span style="font-size:24px;">📝</span>
    </div>
    
    <!-- Feedback window -->
    <div id="feedback-window" style="display:none; width:300px; height:400px; background:#1e1e1e; border:1px solid #ff9900; border-radius:10px 10px 0 0; flex-direction:column;">
        <!-- Header -->
        <div style="background:#ff9900; color:#111; padding:10px; border-radius:10px 10px 0 0; font-weight:bold; display:flex; justify-content:space-between;">
            <span>Give Feedback</span>
            <span id="close-feedback" style="cursor:pointer;">✕</span>
        </div>
        
        <!-- Feedback form -->
        <div style="flex:1; overflow-y:auto; padding:15px; color:white;">
            <p style="margin-top:0;">We'd love to hear your feedback about our website!</p>
            
            <form id="feedback-form">
                <div style="margin-bottom:15px;">
                    <label for="feedback-type" style="display:block; margin-bottom:5px;">Type of feedback:</label>
                    <select id="feedback-type" style="width:100%; padding:8px; border-radius:4px; background:#2a2a2a; color:white; border:1px solid #444;">
                        <option value="suggestion">Suggestion</option>
                        <option value="bug">Bug Report</option>
                        <option value="compliment">Compliment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div style="margin-bottom:15px;">
                    <label for="feedback-message" style="display:block; margin-bottom:5px;">Your feedback:</label>
                    <textarea id="feedback-message" rows="5" style="width:100%; padding:8px; border-radius:4px; background:#2a2a2a; color:white; border:1px solid #444;" required></textarea>
                </div>
                
                <div style="margin-bottom:15px;">
                    <label for="feedback-email" style="display:block; margin-bottom:5px;">Email (optional):</label>
                    <input type="email" id="feedback-email" style="width:100%; padding:8px; border-radius:4px; background:#2a2a2a; color:white; border:1px solid #444;">
                </div>
                
                <button type="submit" style="width:100%; padding:10px; background:#ff9900; color:#111; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>

<script>



// DOM elements
const chatIcon = document.getElementById('chatbot-icon');
const chatWindow = document.getElementById('chatbot-window');
const closeChat = document.getElementById('close-chat');
const userInput = document.getElementById('user-input');
const chatMessages = document.getElementById('chat-messages');

// Feedback elements
const feedbackIcon = document.getElementById('feedback-icon');
const feedbackWindow = document.getElementById('feedback-window');
const closeFeedback = document.getElementById('close-feedback');
const feedbackForm = document.getElementById('feedback-form');

// Common greetings
const greetings = ['hello', 'hi', 'hey', 'greetings', 'howdy', 'hola', 'yo'];

// Toggle chat window and show initial message when opened
chatIcon.addEventListener('click', function() {
    chatWindow.style.display = 'flex';
    chatIcon.style.display = 'none';
    
    // Only add welcome message if chat is empty
    if (chatMessages.children.length === 0) {
        addMessage('bot', "Hello! I'm your Game Advisor. I can help you with any game-related questions 😊");
    }
});

closeChat.addEventListener('click', function() {
    chatWindow.style.display = 'none';
    chatIcon.style.display = 'flex';
});

// Toggle feedback window
feedbackIcon.addEventListener('click', function() {
    feedbackWindow.style.display = 'flex';
    feedbackIcon.style.display = 'none';
});

closeFeedback.addEventListener('click', function() {
    feedbackWindow.style.display = 'none';
    feedbackIcon.style.display = 'flex';
});

// Handle feedback form submission
feedbackForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const feedbackType = document.getElementById('feedback-type').value;
    const feedbackMessage = document.getElementById('feedback-message').value;
    const feedbackEmail = document.getElementById('feedback-email').value;
    
    // Here you would typically send this data to your server
    // For this example, we'll just show a confirmation and log it
    console.log('Feedback submitted:', {
        type: feedbackType,
        message: feedbackMessage,
        email: feedbackEmail
    });
    
    alert('Thank you for your feedback! We appreciate your input.');
    
    // Reset form and close window
    feedbackForm.reset();
    feedbackWindow.style.display = 'none';
    feedbackIcon.style.display = 'flex';
});

// Handle user input for chatbot
userInput.addEventListener('keypress', async function(e) {
    if (e.key === 'Enter') {
        const userMessage = this.value.trim();
        if (!userMessage) return;
        
        this.value = '';
        addMessage('user', userMessage);
        
        // Show "typing" indicator
        const typingIndicator = addMessage('bot', 'Thinking...');
       
        try {
            const lowerMsg = userMessage.toLowerCase();
            
            // Check if it's a greeting
            const isGreeting = greetings.some(greet => lowerMsg.includes(greet));
            
            if (isGreeting) {
                removeMessage(typingIndicator);
                addMessage('bot', "Hello there! 👋 I'm your Game Advisor. How can I help you with games today?");
                return;
            }
            
            // Check if it's a game-related question
            const isGameQuestion = /game|games|sport|sports|play|player|rule|rules|strategy|team|score|match|tournament|league/i.test(lowerMsg);
            
            if (!isGameQuestion) {
                removeMessage(typingIndicator);
                addMessage('bot', "I'm a Game Advisor and can't answer that. I specialize in game-related questions - sports, board games, video games, etc. What would you like to know about games?");
                return;
            }
            
            // Call Gemini API
            const response = await callGeminiAPI(userMessage);
            removeMessage(typingIndicator);
            
            // Verify response is appropriate
            const cleanResponse = response.includes("Sorry") && response.includes("game") 
                ? "I'm a Game Advisor and can't answer that. Please ask me about games - sports, rules, strategies, etc."
                : response;
                
            addMessage('bot', cleanResponse);
            
        } catch (error) {
            console.error("Error:", error);
            removeMessage(typingIndicator);
            addMessage('bot', "Sorry, I'm having trouble answering right now. Please try again later.");
        }
    }
});

// Helper functions
function addMessage(sender, message) {
    const msgDiv = document.createElement('div');
    msgDiv.style.margin = '5px 0';
    msgDiv.style.padding = '8px 12px';
    msgDiv.style.borderRadius = '10px';
    msgDiv.style.maxWidth = '80%';
    msgDiv.style.wordWrap = 'break-word';
    msgDiv.style.backgroundColor = sender === 'user' ? '#00ffcc' : '#2a2a2a';
    msgDiv.style.color = sender === 'user' ? '#111' : 'white';
    msgDiv.style.float = sender === 'user' ? 'right' : 'left';
    msgDiv.style.clear = 'both';
    msgDiv.textContent = message;
    chatMessages.appendChild(msgDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
    return msgDiv;
}

function removeMessage(element) {
    if (element && element.parentNode) {
        element.parentNode.removeChild(element);
    }
}

// API call function with your key
async function callGeminiAPI(question) {
    const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${GEMINI_API_KEY}`;
    
    const prompt = `You are a Game Advisor that specializes in all types of games - sports, board games, video games, card games, etc.
    Important rules:
    1. Only answer if the question is specifically about any type of game
    2. If the question is not game-related, reply: "I'm a Game Advisor and can't answer that. Please ask me about games."
    3. Keep answers concise (1-3 sentences maximum)
    4. Provide factual and accurate information only
    5. If unsure about an answer, say "I don't have information about that specific game"
    
    Question: ${question}`;
    
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                contents: [{
                    parts: [{ text: prompt }]
                }],
                generationConfig: {
                    maxOutputTokens: 150,
                    temperature: 0.3
                },
                safetySettings: [
                    {
                        "category": "HARM_CATEGORY_DANGEROUS_CONTENT",
                        "threshold": "BLOCK_ONLY_HIGH"
                    }
                ]
            })
        });
        
        if (!response.ok) {
            throw new Error(`API request failed with status ${response.status}`);
        }
        
        const data = await response.json();
        
        // Robust response parsing
        if (data?.candidates?.[0]?.content?.parts?.[0]?.text) {
            return data.candidates[0].content.parts[0].text.trim();
        }
        throw new Error("Invalid response structure from API");
        
    } catch (error) {
        console.error("API Error:", error);
        throw error;
    }
}
</script>
  
</body>
</html>
