<!DOCTYPE html>
<html>

<head>
    <title>Web Scraper</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="lib/style.css" rel="stylesheet">

</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="lib/logo.jpg" class="brand_logo" alt="Logo">
                    </div>
                </div>
                <div class="d-flex justify-content-center form_container">
                    <form method="POST" action="server/user_controller.php">
                        <h2 class="text-danger text-center mb-3">Login</h2>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user fa-2x" style="width: 2vw;"></i></div>
                            </div>
                            <input type="email" name="email" class="form-control input_user" value="" placeholder="username">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key fa-2x" style="width: 2vw;"></i></div>
                            </div>
                            <input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
                        </div>

                        <div class="d-flex justify-content-center mt-3 login_container">
                            <input type="submit" name="submit" class="btn login_btn" value="Login">
                        </div>
                    </form>
                </div>
                <?php
                if (!empty($_GET['message'])) {
                    echo '<div class="container" style="margin-top:10px;">
                            <div class="alert alert-danger">
                                <p class="text-danger text-bold">' . $_GET['message'] . '</p>
                            </div>
                            </div>';
                }
                ?>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>

</html>