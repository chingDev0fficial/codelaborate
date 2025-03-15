<!-- filepath: c:\xampp\htdocs\dashboard\codelaborate\resources\views\home.blade.php -->
@if ( session("name") )
<!DOCTYPE html>
<html lang="en">
<head>
    @component('header')
    @endcomponent
    <link rel="stylesheet" href="{{ asset('resources/css/home.css') }}">
</head>
<body>
    <div class="sidebar-overlay"></div>
    <div class="sticky-top" id="temp-body" style="z-index: 10;"></div>
    <div class="d-flex flex-column flex-md-row">
        <button id="sidebarToggle" class="d-md-none sidebar-toggle-btn" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        @component('sidebar', [
            'home' => 'active',
            'message' => '',
            'discovery' => '',
            'project' => '',
            'task' => ''
            ])
        @endcomponent
        <div class="main-bg-color content-width vertical-scroll" id="news-feed">
            @component('head', ['title' => 'Home'])
            @endcomponent
            <div class="d-flex flex-column flex-md-row">
                <div>
                    <div class="p-3 pl-5 pr-5" id="post-container">
                        <!-- ..... -->
                        <div class="create-post-container bg-white rounded p-4">
                            <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="d-flex align-items-center mb-3">
                                    <img src="http://127.0.0.1:8000/storage/{{ session('profile_picture') }}" class="profile-pic me-2" alt="Profile">
                                    <div class="flex-grow-1">
                                        <textarea 
                                            class="form-control border-0 shadow-none" 
                                            name="body" 
                                            placeholder="What's on your mind? Share your programming thoughts..." 
                                            rows="3" 
                                            style="resize: none; background: #f0f2f5; border-radius: 15px;" 
                                            required
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="file-input-container">
                                        <label for="image-upload" class="btn custom-file-btn">
                                            <i class="fa-solid fa-image me-2"></i>Add Image
                                        </label>
                                        <input type="file" id="image-upload" name="image" accept="image/*" class="d-none">
                                    </div>
                                    <button type="submit" class="btn submit-btn">
                                        <i class="fas fa-paper-plane me-2"></i>Share
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="posts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.js"></script>
    <script type="module" src="{{ asset('resources/js/postTemplates_js/templates.js') }}"></script>
    <script src="{{ asset('resources/js/home_js/postinteraction.js') }}"></script>
    <script src="{{ asset('resources/js/home_js/buttonsinteraction.js') }}"></script>
    <script type="module" src="{{ asset('resources/js/home_js/postprovider.js')}}"></script>
    <script src="{{ asset('resources/js/sidebar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endif