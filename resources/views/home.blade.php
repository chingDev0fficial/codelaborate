@if ( session("name") )
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f4d60c73af.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('resources/css/home.css') }}">
    <title>Document</title>
</head>
<body>

    <div id="comment-body"></div>

    <div class="d-flex">
        <nav class="left-nav bg-col6A041D">
            <div class="p-1 mb-5">
                <div class="navbar-brand brand center">
                    <div class="logo center">&lt;/SNSUCL&gt;</div>
                </div>
                <div class="text-center">
                    <span class="colF4FF52">SNSU</span> <span class="col53FF45">CodeLaborate</span>
                </div>
            </div>

            <div class="p-3">
                <ul class="v-space-3">
                    <li><button type="submit" class="btn bg-transparent colWhite"><i class="fa-solid fa-house"></i> Home</button></li>
                    <li><button type="submit" class="btn bg-transparent colWhite"><i class="fa-solid fa-message"></i> Messages</button></li>
                    <li><button type="submit" class="btn bg-transparent colWhite"><i class="fa-solid fa-compass"></i> Dicovery</button></li>
                    <li><button type="submit" class="btn bg-transparent colWhite"><i class="fa-solid fa-diagram-project"></i> Projects</button></li>
                    <li class="mb-5"><button type="submit" class="btn bg-transparent colWhite"><i class="fa-solid fa-list-check"></i> Tasks</button></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn bg-transparent colWhite">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main-bg-color content-width vertical-scroll" id="news-feed">
            <!-- content -->
            <nav class="sticky-top bg-white d-flex justify-content-between align-items-center p-2 mb-3 z-1">
                <h1>Home</h1>
                <div class="center">
                    <p class="bold-font" style="margin: 0; margin-right: 5px;">{{  session("name") }}</p>
                    <img class="profile-pic" src="{{ asset('storage/' . session('profile_picture')) }}" alt="">
                </div>
            </nav>

            <div class="p-5" id="post-container">
                <!-- ..... -->
                <div class="p-3 mb-3 bg-white rounded">
                    <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea class="gap rounded form-control" type="text" name="body" placeholder="Ask for help to solve programming problems..." rows="3" cols="50" style="resize: none;"></textarea>
                        <div class="btn gap bg-col53FF45 col6A041D"><i class="fa-solid fa-image"></i> <input type="file" name="image" accept="image/*"></div>
                        <input class="btn bg-col6A041D colWhite bold-font form-control" type="submit">
                    </form>
                </div>

            </div>
            
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('resources/js/postprovider.js') }}"></script>
    <script src="{{ asset('resources/js/postinteraction.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endif