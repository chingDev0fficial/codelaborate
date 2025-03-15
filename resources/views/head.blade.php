<!-- filepath: c:\xampp\htdocs\dashboard\codelaborate\resources\views\components\head.blade.php -->
<header class="bg-white d-flex justify-content-between align-items-center px-4 py-2 header-container" style="height: var(--header-height);">
    <div class="d-flex align-items-center">
        <button id="sidebarToggle" class="d-md-none sidebar-toggle-btn me-3" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="page-title m-0 text-truncate">{{ $title }}</h5>
    </div>
    <div class="header-content d-flex align-items-center">
        <div class="user-profile-name me-3 d-none d-md-block">
            <span class="fw-medium">{{ session('name') }}</span>
        </div>
        <div class="profile-pic-container">
            <img src="http://127.0.0.1:8000/storage/{{ session('profile_picture') }}" 
                 class="profile-pic" 
                 id="view-profile" 
                 alt="Profile picture"
                 loading="lazy">
        </div>
    </div>
</header>