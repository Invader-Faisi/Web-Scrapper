<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Web Scraper</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #60a3bc !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand text-warning fw-bold">
                Web Scraper
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="home.php" class="nav-item nav-link active text-primary fw-bold">HOME</a>
                    <a href="AliExpressProducts.php" class="nav-item nav-link text-white fw-bold">ALI EXP PRODCUTS</a>
                    <a href="DarazProducts.php" class="nav-item nav-link text-white fw-bold">DARAZ PRODUCTS</a>
                </div>
                <div class="navbar-nav ms-auto">
                    <a href="#" class="nav-item nav-link text-white fw-bold"><i class="fas fa-user" aria-hidden="true"></i>
                        <?php echo $_SESSION['name'] ?></a>
                    <a href="server/user_controller.php?action=logout" class="nav-item nav-link text-danger fw-bold">
                        LOGOUT</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
        <h3 class="text-white text-center mb-4">Products Available in Ali Express Database</h3>
        <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3" id="card">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

    <script>
        /*------------------------- Searching product from daraz page ---------------------------------------*/
        $(document).ready(function() {
            $.ajax({
                url: 'server/product_controller.php',
                method: 'POST',
                data: {
                    action: 'fetch',
                    site: 'aliexp'
                },
                dataType: 'json',
                success: function(response) {
                    var html = '';
                    if (response.status === 'success') {
                        productList = response.data;
                        for (var i = 0; i < productList.length; i++) {
                            var product = productList[i];
                            html += '<div class = "col"><div class = "card h-100 shadow-sm">';
                            html += '<img src="images/' + product.Image + '" class="card-img-top" alt="..."> ';
                            html += '<div class="card-body">';
                            html += '<div class="clearfix mb-3"><span class="float-start badge rounded-pill bg-info">' + product.Category + '</span><span class="float-end price-hp">' + product.Price + '</span> </div>';
                            html += '<h5 class="card-title">' + product.Product + '</h5>';
                            html += '</div></div></div>';
                        }
                        $('#card').empty();
                        $('#card').html(html);
                    } else {
                        $('#card').empty();
                        html += '<div class="alert alert-danger text-center fw-bold" role="alert">' + response.data + '</div>';
                        $('#card').html(html);
                    }
                },
                error: function(x, e) {
                    if (x.status == 0) {
                        alert('You are offline!!\n Please Check Your Network.');
                    } else if (x.status == 404) {
                        alert('Requested URL not found.');
                    } else if (x.status == 500) {
                        alert('Internel Server Error.');
                    } else if (e == 'parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if (e == 'timeout') {
                        alert('Request Time out.');
                    } else {
                        alert('Unknow Error.\n' + x.responseText);
                    }
                }
            });

            /*------------------------- End ---------------------------------------*/
        });
    </script>
</body>

</html>