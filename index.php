<!DOCTYPE html>
<html>

<head>
    <title>Web Scraper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="lib/style.css" rel="stylesheet" type="text/css" media="all">

</head>

<body>
    <div class="container h-100">
        <?php
        if (!empty($_GET['message'])) {
            echo '<div class="container" style="margin-top:10px;">
                            <div class="alert alert-danger">
                                <h3 class="text-danger fw-bold text-center">' . $_GET['message'] . '</h3>
                            </div>
                            </div>';
        }
        ?>
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="lib/logo.jpg" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <div id="login_form">
                        <form method="POST" action="server/user_controller.php">
                            <h2 class="text-danger text-center mb-2 mt-5">LOGIN</h2>
                            <input type="hidden" name="form" value="login">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="email" name="email" class="form-control input_user" value="" placeholder="email">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
                            </div>

                            <div class="justify-content-center mt-3 login_container">
                                <input type="submit" name="submit" class="btn login_btn" value="Login">
                                <p class="text-center mt-2">Don't have an account &nbsp;<span><a href="#" id="show_register">Click here</a></span></p>
                            </div>

                        </form>
                    </div>

                    <div id="register_form">
                        <form method="POST" action="server/user_controller.php">
                            <h2 class="text-danger text-center mb-2 mt-5">REGISTER</h2>
                            <input type="hidden" name="form" value="register">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="text" name="name" class="form-control input_user" value="" placeholder="Full name">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-envelope fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="email" name="email" class="form-control input_user" value="" placeholder="Email">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="number" name="mobile" class="form-control input_user" value="" placeholder="Cell No">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key fa-2x" style="width: 2vw;"></i></div>
                                </div>
                                <input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
                            </div>

                            <div class="justify-content-center mt-3 login_container">
                                <input type="submit" name="submit" class="btn login_btn" value="Register">
                                <p class="text-center mt-2">Already have an account &nbsp;<span><a href="#" id="show_login">Click here</a></span></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#register_form').hide();
            $('#show_register').click(function() {
                $('#register_form').show();
                $('#login_form').hide();
            });

            $('#show_login').click(function() {
                $('#register_form').hide();
                $('#login_form').show();
            });

        });
    </script>
</body>

</html>