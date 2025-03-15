<!DOCTYPE html>
<html lang="en">
<head>
    @component('header')
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Move jQuery to the head section -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('resources/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/message.css') }}">
</head>
<body>
    <div class="sidebar-overlay"></div>
    <div class="sticky-top" id="temp-body" style="z-index: 10;"></div>
    @component('head', ['title' => 'Message'])
    @endcomponent
    @component('sidebar', [
            'home' => '',
            'message' => 'active',
            'discovery' => '',
            'project' => '',
            'task' => ''
            ])
    @endcomponent

    <div class="main-bg-color content-width">
        <div class="d-flex flex-column flex-md-row message-container">
            <!-- Chat Sidebar -->
            <div class="chat-sidebar">
                <div class="chat-header">
                    <div class="search-wrapper">
                        <input type="text" class="search-input" placeholder="Search conversations...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                <div class="chat-users custom-scrollbar">
                    <!-- the followed and the one who fallowd you will display here -->
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="chat-main">
                <!-- Empty State -->
                <div class="chat-empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Your Messages</h3>
                    <p>Send private messages to your connections</p>
                </div>

                <!-- Chat Interface (Initially Hidden) -->
                <div class="chat-interface d-none">
                    <div class="chat-header">
                        <button class="back-button d-md-none">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <div class="chat-header-user">
                            <div class="user-avatar">
                                <img src="" alt="" class="chat-profile-pic">
                                <span class="status-dot"></span>
                            </div>
                            <div class="user-info">
                                <h6 class="chat-user-name"></h6>
                                <small class="user-status">Offline</small>
                            </div>
                        </div>
                    </div>

                    <div class="chat-messages custom-scrollbar"></div>

                    <div class="chat-input-area">
                        <div class="input-wrapper">
                            <input type="text" class="message-input" placeholder="Type a message...">
                            <button class="send-message-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.js"></script>
    <script src="{{ asset('resources/js/sidebar.js') }}"></script>
    <script src="{{ asset('resources/js/message_js/messageprovider.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>