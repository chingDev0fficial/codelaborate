<nav class="left-nav bg-col6A041D">
    <div class="sidebar-header p-3 mb-4">
        <div class="navbar-brand brand center">
            <div class="logo center">&lt;/SNSUCL&gt;</div>
        </div>
        <div class="text-center brand-text">
            <span class="colF4FF52">SNSU</span> <span class="col53FF45">CodeLaborate</span>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="nav-links">
            <li>
                <form action="{{ route('home') }}" method="GET">
                    <button type="submit" class="nav-link {{ $home }}" data-tooltip="Home">
                        <i class="fa-solid fa-house"></i> 
                        <span class="nav-text">Home</span>
                    </button>
                </form>
            </li>
            <li>
                <form action="{{ route('message') }}" method="GET">
                    <button type="submit" class="nav-link {{ $message }}" data-tooltip="Messages">
                        <i class="fa-solid fa-message"></i>
                        <span class="nav-text">Messages</span>
                    </button>
                </form>
            </li>
            <li>
                <button class="nav-link {{ $discovery }}" data-tooltip="Discovery">
                    <i class="fa-solid fa-compass"></i>
                    <span class="nav-text">Discovery</span>
                </button>
            </li>
            <li>
                <!-- <form action="" method="GET"> -->
                    <button class="nav-link {{ $project }}" data-tooltip="Projects">
                        <i class="fa-solid fa-diagram-project"></i>
                        <span class="nav-text">Projects</span>
                    </button>
                <!-- </form> -->
            </li>
            <li>
                <form action="{{ route('task') }}" method="GET">
                    <button class="nav-link {{ $task }}" data-tooltip="Tasks">
                        <i class="fa-solid fa-list-check"></i>
                        <span class="nav-text">Tasks</span>
                    </button>
                </form>
            </li>
            <li class="logout-container">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link logout-link" data-tooltip="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="nav-text">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>