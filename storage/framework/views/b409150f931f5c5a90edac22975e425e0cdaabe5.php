<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="<?php echo e(asset('resources/css/frontpage.css')); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f4d60c73af.js" crossorigin="anonymous"></script>
    <title>SNSU Codelaborate</title>
</head>
<body>
    <nav class="p-3 navbar navbar-expand-lg justify-content-between bg-col6A041D mb-5">
        <div class="navbar-brand d-flex align-items-center brand">
            <div class="logo center">&lt;/SNSUCL&gt;</div>
            <div>
                <span class="colF4FF52">SNSU</span> <span class="col53FF45">CodeLaborate</span>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-decoration-none bold-font colF5B841" href="<?php echo e(route('login')); ?>">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- upper content -->
     <div class="container content-height">
        <div class="text-justify mb-5">
            <p class="small-font">
            <span class="col53FF45 v-space-1 bold-font mid-font-size">CodeLaborate</span> is a collaborative social media platform specifically built to all programs from 
            <span class="bold-font">Surigao del Norte State University (SNSU)</span>, mainly for coding i.e. Computer Science, Information Technology, 
            Computer Engineering and related courses! This platform is one of team building space for students, faculties, 
            and developers helping them make something big together through coding and offering opportunity to practice 
            your coding skills in taken challenges with creative problem-solving.
            </p>
        </div>
        <form action="<?php echo e(route('signup')); ?>" method="GET">
            <button class="bold-font bg-colF5B841 btn" type="submit">Join Now</button>
        </form>

        <div class="p-5 center">
            <p class="small-font bold-font">With <span class="col53FF45">CodeLaborate</span>, users can:</p>
        </div>

        <div class="center">
            <div class="wrap-div center justify-content-between">
                <div class="box">
                    <div class="center col6A041D">
                        <i class="fa-solid fa-clock small-font"></i>
                    </div>
                    <div>
                        <p class="bold-font text-center extra-small-font">
                            Real-time<br>Collaboration
                        </p>
                    </div>
                    <div class="text-center extra-small-font">
                        <p>
                            Work together on coding projects and assignments across different disciplines
                        </p>
                    </div>
                </div>

                <div class="box">
                    <div class="center col6A041D">
                        <i class="fa-solid fa-share-from-square small-font"></i>
                    </div>
                    <div>
                        <p class="bold-font text-center extra-small-font">
                            Code Sharing &<br>Feedback
                        </p>
                    </div>
                    <div class="text-center extra-small-font">
                        <p>
                            Share code, give feedback, and troubleshoot with peers.
                        </p>
                    </div>
                </div>

                <div class="box">
                    <div class="center col6A041D">
                        <i class="fa-solid fa-list-check small-font"></i>
                    </div>
                    <div>
                        <p class="bold-font text-center extra-small-font">
                        Coding Challenges &<br>Hackathons
                        </p>
                    </div>
                    <div class="text-center extra-small-font">
                        <p>
                            Organize team-based coding events to improve skills.
                        </p>
                    </div>
                </div>
            </div>
        </div>
     </div>

    <!-- middle content -->

    <div class="content-height">
        <div class="d-flex justify-content-between p-2 horizontal-space">
            <div>
                <h1 class="big-font-size">Interdisciplinary Code <span class="col1E2EDE">Collaboration</span></h1>
                <p class="small-font text-justify">
                <span class="col53FF45 bold-font">CodeLaborate</span> is designed to promote interdisciplinary collaboration, bridging the gap between 
                different coding-focused programs and preparing SNSU students for the tech industry's challenges.
                </p>
            </div>
            <div>
                <img class="img-size-big" src="<?php echo e(asset('resources/img/Capture.png')); ?>" alt="">
            </div>
        </div>
        <!-- developer intro -->
         <div>
            <div>
                <h1 class="mid-font-size">Developer</h1>
            </div>
            <div class="d-flex">
                <div class="p-1">
                    <img class="my-img japan-vibes" src="<?php echo e(asset('resources/img/developer_img.jpg')); ?>" alt="">
                </div>
                <div>
                    <div class="d-flex">
                        <p class="bold-font small-font">PRINCE CARL S. AJOC</p>
                        <div class="check-logo center"><i class="fa-solid fa-check"></i></div>
                    </div>
                    <div>
                        <p class="small-font">My mission in creating this collaborative social media platform is to unite all 
                            programming students, faculties, and developers at SNSU, fostering a vibrant 
                            community where ideas, skills, and knowledge can be shared and developed collaboratively.</p>
                    </div>
                </div>
            </div>
         </div>
    </div>

    <!-- footer -->
    <div class="footer-bg-color p-5 center colWhite">
        <div class="text-center v-space-1">
            <h1>Connect With Us</h1>
            <div class="d-flex justify-content-between colWhite">
                <a class="colWhite" href="#"><i class="fa-brands fa-facebook"></i></a>
                <a class="colWhite" href="#"><i class="fa-brands fa-twitter"></i></a>
                <a class="colWhite" href="#"><i class="fa-brands fa-instagram"></i></a>
                <a class="colWhite" href="#"><i class="fa-brands fa-linkedin"></i></a>
            </div>
            <h1>Contact Us</h1>
            <p>For inquiries or support, reach out at:<br>Email: support-codelaborate@snsu.edu.ph<br>Phone: +63 967 687 7741</p>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\dashboard\codelaborate\resources\views/frontpage.blade.php ENDPATH**/ ?>