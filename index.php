<?php
    $name_error = '';
    $surname_error = '';
    $bDay_error = '';
    $email_error = '';
    $password_error = '';
    $password_error2 = '';

    $login_email_error = '';
    $login_password_error = '';

    $add_css = '';
    $no_error_text = '';
    $slide_left = '';
    $slide_in = '';

    $view = 'register';

    // function doLogin(){
    //     if(isset($_GET['login'])){
    //         //do nothing
    //         echo '<script>alert("hi");</script>';
    //     }else{
    //         header("location: index.php?login=true");
    //     }
    // }

    // function doRegister(){
    //     header("location: index.php?register=true");
    // }

    if(isset($_GET['login'])){
        if($_GET['login'] == 'true'){
            $slide_left = 'slide-left';
            $slide_in = 'slide-in';
        }
        $view = 'login';
    }

    if(isset($_GET['login'])){
        if($_GET['login'] == 'quick'){
            $slide_left = 'quick-out';
            $slide_in = 'quick-in';
        }
        $view = 'login';
    }

    if(isset($_GET['register'])){
        if($_GET['register'] == 'true'){
            $slide_left = 'slide-right';
            $slide_in = 'quick-out';
        }
        $view = 'register';
    }

    if(isset($_GET['error'])){
        $str = $_GET['error'];
    
        if(preg_match("/none/", $str)){
            if(isset($_GET['login'])){
                if($_GET['login'] == 'true'){
                    $add_css = 'no-error added_animation';
                    $slide_left = 'slide-left';
                    $slide_in = 'slide-in';
                    $no_error_text = 'User created successfully';
                }
                $view = 'login';
            }
        }else{
            if(preg_match("/emptyname/", $str)){
                $name_error = 'Name is required';
            }
    
            if(preg_match("/emptysurname/", $str)){
                $surname_error = 'Surame is required';
            }
    
            if(preg_match("/emptyemail/", $str)){
                $email_error = 'Email is required';
            }

            if(preg_match("/emptydate/", $str)){
                $bDay_error = 'Birthday is required';
            }
    
            if(preg_match("/emptypassword/", $str)){
                $password_error = 'Password is required';
            }

            if(preg_match("/emptypassword2/", $str)){
                $password_error2 = 'Password must be confirmed';
            }

            if(preg_match("/wrongemail/", $str)){
                $email_error = 'Email is invalid';
            }

            if(preg_match("/wrongdate/", $str)){
                $bDay_error = 'Birthday is invalid';
            }
    
            if(preg_match("/wrongemail/", $str)){
                $email_error = 'Email is invalid';
            }
    
            if(preg_match("/passlength/", $str)){
                $password_error = 'Must be longer than 8 characters';
            }

            if(preg_match("/passmatch/", $str)){
                $password_error2 = 'Passwords do not match';
            }
    
            if(preg_match("/emailtaken/", $str)){
                $email_error = 'Email already exists';
            }

            //now for login:            
            if(preg_match("/emptyLogEmail/", $str)){
            $login_email_error = 'Email is required';
            }
        
            if(preg_match("/emptyLogPassword/", $str)){
            $login_password_error = 'Password is required';
            }
        
            if(preg_match("/wrongLogEmail/", $str)){
            $login_email_error = 'Email is invalid';
            }
        
            if(preg_match("/emailnotexist/", $str)){
            $login_email_error = 'User does not exist, register instead';
            }
        
            if(preg_match("/wrongpassword/", $str)){
            $login_password_error = 'Password is incorrect';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashir Butt, u20422475">
    <title>Exhibo | Splash</title>
    <link rel="icon" type="image/x-icon" href="images/logo.svg">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
</head>
<body class="splash-page">
    <div class="container-fluid">
        <div class="header">
            <div class="nav">
                <div class="logo-banner">
                    <img class="logo-img" src="images/logo.svg" alt="website logo">
                    <h1>exhibo</h1>
                </div>
                <div class="page-links">
                    <a href='#' onclick="setViewLogin()">Login</a>
                    <a href='#' onclick="setViewRegister()">Register</a>
                </div>
            </div>
        </div>

        <div class="<?php echo $add_css?>"><span class="no_error_text"><?php echo $no_error_text?></span></div>

        <div id="setReg" class="registration-form <?php echo $slide_left ?>">
            <div class="reg-cover">
                <h1>Register</h1>

                <form action="register.php" method="POST">
                    <fieldset>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label for="regName">First Name<sup>*</sup></label>
                                <input type="text" id="regName" class="form-control" placeholder="John" name="fname">
                                <span class="formspan" id="nameSpan"><?php echo $name_error?></span>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="regSurname">Last Name<sup>*</sup></label>
                                <input type="text" id="regSurname" class="form-control" placeholder="Doe" name="lname">
                                <span class="formspan" id="surnameSpan"><?php echo $surname_error?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-6">
                                <label for="regEmail">Email Address<sup>*</sup></label>
                                <input type="email" id="regEmail" class="form-control" placeholder="john.doe@gmail.com" name="email">
                                <span class="formspan" id="emailSpan"><?php echo $email_error?></span>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="regBirthDate">Date of Birth<sup>*</sup></label>
                                <input type="date" id="regBirthDate" class="form-control" name="date">
                                <span class="formspan" id="dateSpan"><?php echo $bDay_error?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-6">
                                <label for="regEmail">Create Password<sup>*</sup></label>
                                <input type="password" id="pass1" class="form-control" placeholder="******" name="pass">
                                <span class="formspan passspan" id="passwordSpan"><?php echo $password_error?></span>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="regEmail">Confirm Password<sup>*</sup></label>
                                <input type="password" id="pass2" class="form-control" placeholder="******" name="pass2">
                                <span class="formspan passspan" id="passwordSpan2"><?php echo $password_error2?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button name="submit" type="submit" id="regSubmit" class="btn">Register</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <div id="setLog" class="login-form <?php echo $slide_in ?>">
            <div class="log-cover">
            <h1>Login</h1>

            <form action="login.php" method="POST">
                <fieldset>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label for="loginEmail">Email Address<sup>*</sup></label>
                            <input type="email" id="loginEmail" class="form-control" placeholder="name@email.com" name="logEmail">
                            <span class="formspan" id="LogEmailSpan"><?php echo $login_email_error?></span>
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="loginPass">Password<sup>*</sup></label>
                            <input type="password" id="loginPass" class="form-control" placeholder="******" name="logPass">
                            <span class="formspan" id="LogPassSpan"><?php echo $login_password_error?></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button name="logSubmit" type="submit" id="logSubmit" class="btn">Login</button>
                        </div>
                    </div>
                </fieldset>
            </form>

            </div>
        </div>

        <div class="wrapper">
            <div class="typewriter">
                <h1 class="tagline">Exhibit your creativity to the world.</h1>
            </div>
        </div>
        
        <div class="background-images">

            <div class="gradient"></div>
            <div class="row">
                <div class="column">
                  <img src="images/background/img1.jpeg" alt="background-img">
                  <img src="images/background/img2.jpg" alt="background-img">
                  <img src="images/background/img4.jpg" alt="background-img">
                  <img src="images/background/img32.jpg" alt="background-img">
                  <img src="images/background/img36.jpg" alt="background-img">
                </div>
                <div class="column">
                    <img src="images/background/img5.jpg" alt="background-img">
                    <img src="images/background/img19.jpg" alt="background-img">
                    <img src="images/background/img33.jpg" alt="background-img">
                    <img src="images/background/img30.jpg" alt="background-img">
                    <img src="images/background/img37.jpg" alt="background-img">
                </div>
                <div class="column">
                    <img src="images/background/img10.jpg" alt="background-img">
                    <img src="images/background/img7.jpg" alt="background-img">
                    <img src="images/background/img9.jpg" alt="background-img">
                    <img src="images/background/img34.jpg" alt="background-img">
                    <img src="images/background/img39.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img11.jpg" alt="background-img">
                  <img src="images/background/img12.jpg" alt="background-img">
                  <img src="images/background/img13.jpg" alt="background-img">
                  <img src="images/background/img35.jpg" alt="background-img">
                  <img src="images/background/img38.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img15.jpg" alt="background-img">
                  <img src="images/background/img31.jpg" alt="background-img">
                  <img src="images/background/img29.jpg" alt="background-img">
                  <img src="images/background/img8.jpg" alt="background-img">
                  <img src="images/background/img14.jpg" alt="background-img">
                </div>
                <div class="column">
                  <img src="images/background/img23.jpg" alt="background-img">
                  <img src="images/background/img24.jpg" alt="background-img">
                  <img src="images/background/img25.jpg" alt="background-img">
                  <img src="images/background/img27.jpg" alt="background-img">
                  <img src="images/background/img21.jpg" alt="background-img">
                </div>
              </div>
        </div>

        
    </div>

    <script src="js/register.js"></script>
    <script src="js/login.js"></script>

    <script type="text/javascript">
        let view = "<?php echo $view; ?>";
        
        function setViewLogin(){
            if(view == 'register'){
                let reg = document.getElementById('setReg');
                if(reg.classList.contains('slide-right')){
                    reg.classList.remove('slide-right');
                }
                reg.classList.add('slide-left');

                let log = document.getElementById('setLog');
                if(log.classList.contains('slide-out')){
                    log.classList.remove('slide-out');
                }
                log.classList.add('slide-in');

                view = 'login';

                <?php
                    $view = 'login';
                ?>
            }
        }

        function setViewRegister(){
            if(view == 'login'){
                let reg = document.getElementById('setReg');
                if(reg.classList.contains('slide-left')){
                    reg.classList.remove('slide-left');
                }
                if(reg.classList.contains('slide-out')){
                    reg.classList.remove('slide-out');
                }
                reg.classList.add('slide-right');

                let log = document.getElementById('setLog');
                if(log.classList.contains('slide-in')){
                    log.classList.remove('slide-in');
                }
                log.classList.add('slide-out');

                view = 'register';

                <?php
                    $view = 'register';
                ?>
            }
        }
        
    </script>
</body>
</html>