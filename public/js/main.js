document.addEventListener('DOMContentLoaded', () => {
  console.log('Explore Manaoag JS Loaded.');


  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
      });
  }





  const cssLink = document.querySelector('link[rel="stylesheet"]').href;


  const baseUrl = cssLink.substring(0, cssLink.indexOf('/css/style.css')); 
  
  console.log('Base URL detected:', baseUrl); 
  
  initPushNotifications(baseUrl); 




  const saveButtons = document.querySelectorAll('.save-btn');
  saveButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      const btn = this;
      const itemId = btn.dataset.itemId;
      const itemType = btn.dataset.itemType;
      const action = btn.dataset.action;

      const formData = new FormData();
      formData.append('item_id', itemId);
      formData.append('item_type', itemType);
      formData.append('action', action);

      fetch(baseUrl + '/index.php?page=toggle_favorite', { 
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const icon = btn.querySelector('i');
          if (action === 'add') {
            btn.dataset.action = 'remove';
            btn.classList.add('saved');
            btn.title = 'Remove from favorites';
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid'); 
          } else {
            btn.dataset.action = 'add';
            btn.classList.remove('saved');
            btn.title = 'Save to favorites';
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular'); 
          }
        } else {
          if (data.message === 'User not logged in.') {
            alert('Please log in to save items to your profile.');
            window.location.href = baseUrl + '/index.php?page=user_login'; 
          } else {
            alert('An error occurred.');
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });


  const chatBubble = document.getElementById('chat-bubble');
  const chatWindow = document.getElementById('chat-window');
  const chatClose = document.getElementById('chat-close');
  const chatInput = document.getElementById('chat-input');
  const chatSend = document.getElementById('chat-send');
  const chatBody = document.getElementById('chat-body');
  const suggestionsContainer = document.getElementById('chat-suggestions'); 
  
  let typingIndicator; 

  if (chatBubble) { 
    chatBubble.addEventListener('click', () => {
      chatWindow.style.display = 'flex';
      chatBubble.style.display = 'none';
    });

    chatClose.addEventListener('click', () => {
      chatWindow.style.display = 'none';
      chatBubble.style.display = 'flex';
    });

    const triggerBotResponse = (message) => {
      showTypingIndicator();

      if (suggestionsContainer) {
        suggestionsContainer.style.display = 'none';
      }

      fetch(baseUrl + '/chatbot_api_advanced.php', { 
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: message })
      })
      .then(response => response.json())
      .then(data => {
        hideTypingIndicator();
        addMessageToChat(data.answer, 'bot');
      })
      .catch(error => {
        console.error('Chatbot error:', error);
        hideTypingIndicator();
        addMessageToChat('Sorry, I am having trouble connecting.', 'bot');
      });
    };

    const addMessageToChat = (message, sender) => {
      const messageElement = document.createElement('div');
      messageElement.classList.add('chat-message', sender);
      messageElement.innerHTML = message.replace(/\n/g, '<br>'); 
      chatBody.appendChild(messageElement);
      chatBody.scrollTop = chatBody.scrollHeight;
    };
    
    const sendMessageFromInput = () => {
      const message = chatInput.value.trim();
      if (message === '') return;
      
      addMessageToChat(message, 'user');
      chatInput.value = '';
      
      triggerBotResponse(message); 
    };
    
    const showTypingIndicator = () => {
      typingIndicator = document.createElement('div');
      typingIndicator.classList.add('chat-message', 'typing');
      typingIndicator.innerHTML = `<div class="typing-dots"><span></span><span></span><span></span></div>`;
      chatBody.appendChild(typingIndicator);
      chatBody.scrollTop = chatBody.scrollHeight;
    };
    
    const hideTypingIndicator = () => {
      if (typingIndicator) {
        chatBody.removeChild(typingIndicator);
        typingIndicator = null;
      }
    };

    chatSend.addEventListener('click', sendMessageFromInput);
    chatInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        sendMessageFromInput();
      }
    });

    if (suggestionsContainer) {
        const suggestionBtns = suggestionsContainer.querySelectorAll('.suggestion-btn');
        suggestionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const message = btn.dataset.message;
                
                addMessageToChat(message, 'user');
                
                triggerBotResponse(message);
            });
        });
    }
  }
  
  

  function initPushNotifications(baseUrl) {
      if ('serviceWorker' in navigator && 'PushManager' in window) {
          navigator.serviceWorker.register(baseUrl + '/sw.js') 
              .then(swReg => {
                  console.log('Service Worker is registered', swReg);
                  if (Notification.permission === 'granted') {
                      getSubscription(swReg, baseUrl); 
                  } else if (Notification.permission === 'default') {
                      setTimeout(() => askPermission(swReg, baseUrl), 5000); 
                  }
              })
              .catch(error => {
                  console.error('Service Worker Error', error);
              });
      }
  }

  function askPermission(swReg, baseUrl) {
      console.log('Asking for notification permission...');
      Notification.requestPermission().then(permission => {
          if (permission === 'granted') {
              getSubscription(swReg, baseUrl);
          }
      });
  }

  function getSubscription(swReg, baseUrl) {
      swReg.pushManager.getSubscription().then(subscription => {
          if (subscription === null) {
              subscribeUser(swReg, baseUrl);
          } else {
              sendSubscriptionToServer(subscription, baseUrl);
          }
      });
  }

  function subscribeUser(swReg, baseUrl) {
      const applicationServerKey = urlBase64ToUint8Array(window.VAPID_PUBLIC_KEY);
      swReg.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: applicationServerKey
      })
      .then(subscription => {
          console.log('User is subscribed.');
          sendSubscriptionToServer(subscription, baseUrl);
      })
      .catch(err => {
          console.log('Failed to subscribe the user: ', err);
      });
  }

  function sendSubscriptionToServer(subscription, baseUrl) {
      fetch(baseUrl + '/push_handler.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify(subscription.toJSON())
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              console.log('Subscription saved on server.');
          } else {
              console.error('Failed to save subscription:', data.message);
          }
      });
  }

  function urlBase64ToUint8Array(base64String) {
      const padding = '='.repeat((4 - base64String.length % 4) % 4);
      const base64 = (base64String + padding)
          .replace(/-/g, '+')
          .replace(/_/g, '/');

      const rawData = window.atob(base64);
      const outputArray = new Uint8Array(rawData.length);

      for (let i = 0; i < rawData.length; ++i) {
          outputArray[i] = rawData.charCodeAt(i);
      }
    return outputArray;
  }
  

  document.addEventListener('keydown', (e) => {
      if (e.ctrlKey && e.altKey && e.key === 'a') {
          e.preventDefault(); 
          window.location.href = baseUrl + '/index.php?page=login';
      }
  });
  
});