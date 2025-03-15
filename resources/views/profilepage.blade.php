<!DOCTYPE html>
<html lang="en">
<head>
    @component('header')
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('resources/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/profilepage.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar-overlay"></div>
    <button id="sidebarToggle" class="d-md-none sidebar-toggle-btn" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>
    @component('head', ['title' => 'Profile'])
    @endcomponent
    @component('sidebar', [
        'home' => '',
        'message' => '',
        'discovery' => '',
        'project' => '',
        'task' => ''
        ])
    @endcomponent
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-sidebar" data-id="{{ auth()->id() }}">
                    <div class="profile-userpic">
                        <img id="profile-picture" class="img-responsive" alt="Profile Picture">
                    </div>
                    <div class="profile-usertitle">
                        <div id="profile-name" class="profile-usertitle-name"></div>
                        <div id="profile-occupation" class="profile-usertitle-job"></div>
                    </div>
                    <div class="profile-info">
                        <div id="profile-email"><i class="fas fa-envelope"></i> <span></span></div>
                        <div id="profile-birthday"><i class="fas fa-birthday-cake"></i> <span></span></div>
                        <div id="profile-sex"><i class="fas fa-user"></i> <span></span></div>
                    </div>
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-success btn-sm follow-btn">
                            <i class="fas fa-user-plus"></i> Follow
                        </button>
                        <button type="button" class="btn btn-danger btn-sm message-btn">
                            <i class="fas fa-envelope"></i> Message
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-content">
                    <h3 class="mb-4" style="color: #2c3e50;"><i class="fas fa-stream"></i> Posts</h3>
                    <div id="user-posts">
                        <!-- post will dynamically show here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="{{ asset('resources/js/postTemplates_js/templates.js') }}"></script>
    <script type="module" src="{{ asset('resources/js/profile_js/profileHandler.js') }}"></script>
    <script src="{{ asset('resources/js/sidebar.js') }}"></script>
</body>
</html>