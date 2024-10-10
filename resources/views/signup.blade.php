<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/f4d60c73af.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('resources/css/signup.css') }}">
    <title>Sign Up</title>
</head>
<body>
    <form action="/">
        <button class="btn bg-white" type="submit"><i class="fa-solid fa-arrow-left-long"></i></button>
    </form>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="text-center">Sign up<br><span class="bold-font col53FF45">CodeLaborate</span></h2>
                        
                        <form action="{{ route('submit.signup') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="juan@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <div class="d-flex" name="birthday">
                                    <input type="text" name="year" class="form-control" placeholder="YYYY" required>
                                    <input type="text" name="month" class="form-control" placeholder="MM" required>
                                    <input type="text" name="day" class="form-control" placeholder="DD" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex</label>
                                <div class="form-control" style="height: auto !important;">
                                    <div>
                                        <input type="radio" name="sex" value="male" required> Male
                                    </div>
                                    <div>
                                        <input type="radio" name="sex" value="female" required> Female
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="occupation" class="form-label">Occupation</label>
                                <select name="occupation" class="form-control" id="">
                                    <option value="" disabled selected>Select your Occupation</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="developer">Developer</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="profile-pic" class="form-label">Profile picture</label>
                                <input type="file" class="form-control" name="profile-pic">
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn colWhite bg-col6A041D" style="width: 100%;">Sign up</button>
                            </div>
                            <p class="text-center">Already have an Account? <a href="{{ route('login') }}">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>