document.addEventListener('DOMContentLoaded', function() {
    let activeChat = null;

    function fetchChatUsers() {
        const chatUsers = document.querySelector('.chat-users');
        chatUsers.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div></div>';

        $.ajax({
            url: '/getChatUsers',
            method: 'GET',
            success: function(users) {
                console.log(users);
                chatUsers.innerHTML = '';
                
                if (!users || users.length === 0) {
                    chatUsers.innerHTML = `
                        <div class="text-center p-4">
                            <i class="fas fa-user-friends fa-3x mb-3 text-muted"></i>
                            <p class="text-muted">No connections found. Follow some users to start chatting!</p>
                        </div>
                    `;
                    return;
                }

                users.forEach(user => {
                    const userElement = document.createElement('div');
                    userElement.className = 'chat-user';
                    userElement.dataset.userId = user.id;
                    
                    userElement.innerHTML = `
                        <div class="d-flex align-items-center w-80 chat-user-container">
                            <div class="chat-avatar-wrapper">
                                <img src="http://127.0.0.1:8000/storage/${user.profile_picture}" 
                                     alt="${user.name}" 
                                     class="chat-profile-pic">
                                <span class="status-indicator ${Math.random() > 0.5 ? 'online' : ''}"></span>
                            </div>
                            <div class="chat-user-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="user-details">
                                        <h6 class="mb-0 user-name">${user.name}</h6>
                                        <small class="text-muted user-occupation">
                                            <i class="fas ${getOccupationIcon(user.occupation)}"></i> 
                                            ${user.occupation || 'No occupation'}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    userElement.addEventListener('click', () => selectUser(user));
                    chatUsers.appendChild(userElement);
                });
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                chatUsers.innerHTML = `
                    <div class="text-center p-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                        <p>Error loading connections</p>
                    </div>
                `;
            }
        });
    }

    function selectUser(user) {
        // Remove active class from all users
        document.querySelectorAll('.chat-user').forEach(el => el.classList.remove('active'));
        // Add active class to selected user
        document.querySelector(`.chat-user[data-user-id="${user.id}"]`).classList.add('active');
        
        // Show chat interface and hide empty state
        document.querySelector('.chat-empty-state').style.display = 'none';
        const chatInterface = document.querySelector('.chat-interface');
        chatInterface.classList.remove('d-none');
        
        // Update chat header with user info
        document.querySelector('.chat-user-name').textContent = user.name;
        document.querySelector('.chat-header .chat-profile-pic').src = `http://127.0.0.1:8000/storage/${user.profile_picture}`;
        
        // Handle mobile view
        if (window.innerWidth <= 768) {
            document.querySelector('.chat-main').classList.add('active');
        }
        
        activeChat = user.id;
        fetchMessages(user.id);
    }

    // Add back button functionality
    document.querySelector('.back-button')?.addEventListener('click', function() {
        document.querySelector('.chat-main').classList.remove('active');
    });

    function fetchMessages(userId) {
        const messagesContainer = document.querySelector('.chat-messages');
        messagesContainer.innerHTML = '<div class="text-center p-3"><div class="spinner-border text-primary"></div></div>';

        $.ajax({
            url: `/getMessages/${userId}`,
            method: 'GET',
            success: function(response) {
                if (response.error) {
                    console.error('Server error:', response.error);
                    return;
                }

                const messages = response.messages;
                const currentUserId = response.currentUserId;
                messagesContainer.innerHTML = '';
                
                messages.forEach(message => {
                    const isSent = message.sender_id === currentUserId;
                    const messageElement = document.createElement('div');
                    messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
                    messageElement.innerHTML = `
                        <div class="message-content">
                            ${message.message}
                        </div>
                    `;
                    messagesContainer.appendChild(messageElement);
                });
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            },
            error: function(xhr) {
                console.error('Error fetching messages:', xhr.responseText);
            }
        });
    }

    // Handle message sending
    const messageInput = document.querySelector('.message-input');
    const sendButton = document.querySelector('.send-message-btn');

    function sendMessage() {
        if (!activeChat || !messageInput.value.trim()) return;

        $.ajax({
            url: '/sendMessage',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                receiver_id: activeChat,
                content: messageInput.value.trim()
            }),
            success: function(response) {
                if (response.success) {
                    messageInput.value = '';
                    fetchMessages(activeChat);
                } else {
                    console.error('Failed to send message:', response.error);
                }
            },
            error: function(xhr) {
                console.error('Error sending message:', xhr.responseText);
            }
        });
    }

    // Update the event listeners to use the sendMessage function
    sendButton.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Initial fetch of chat users
    fetchChatUsers();

    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.chat-user').forEach(userEl => {
            const userName = userEl.querySelector('h6').textContent.toLowerCase();
            userEl.style.display = userName.includes(searchTerm) ? 'flex' : 'none';
        });
    });
});

function getOccupationIcon(occupation) {
    const icons = {
        'student': 'fa-graduation-cap',
        'teacher': 'fa-chalkboard-teacher',
        'developer': 'fa-code',
        'default': 'fa-user-tie'
    };
    return icons[occupation?.toLowerCase()] || icons.default;
}
