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
                    <a href="#" class="nav-item nav-link text-white fw-bold">ALI EXP PRODCUTS</a>
                    <a href="#" class="nav-item nav-link text-white fw-bold">DARAZ PRODUCTS</a>
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

    <div class="container mt-3 mb-5">
        <form class="mb-3" method="POST" action="server/product_controller.php">
            <div class="input-group">
                <input type="hidden" name="page" id="page" value="aliexp">
                <span class="input-group-text" id="search">Ali Express</span>
                <input type="text" class="form-control" id="aliexp_product" name="aliexp_product" aria-describedby="search" placeholder="Search Product from Ali Express" required>
                <span class="input-group-text" id="search"><button type="submit" class="btn btn-md btn-success" name="submit">Search</button></span>
            </div>
        </form>
        <form id="darazForm">
            <div class="input-group">
                <input type="hidden" name="page" id="page" value="daraz">
                <span class="input-group-text" id="search">Daraz</span>
                <input type="text" class="form-control" id="daraz_product" name="daraz_product" aria-describedby="search" placeholder="Search Product from Daraz" required>
                <span class="input-group-text" id="search"><button type="submit" class="btn btn-md btn-success" name="submit">Search</button></span>
            </div>
        </form>
    </div>
    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative;">
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

            $('#darazForm').submit(function(e) {
                if ($.trim($('#daraz_product').val()) == '') {
                    alert('Input can not be left blank');
                } else {
                    e.preventDefault();
                    var formData = $(this).serializeArray();
                    $.ajax({
                        url: 'server/product_controller.php',
                        method: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            var html = '';
                            if (response.status === 'success') {
                                productList = response.data;
                                for (var i = 0; i < productList.length; i++) {
                                    var product = productList[i];
                                    html += '<div class = "col"><div class = "card h-100 shadow-sm">';
                                    html += '<img src="images/' + product.Image + '" class="card-img-top" alt="..." id="prod_img"> ';
                                    html += '<div class="card-body">';
                                    html += '<div class="clearfix mb-3">Price<span class="float-end price-hp" id="prod_price">' + product.Price + '&euro;</span> </div>';
                                    html += '<h5 class="card-title" id="prod_name">' + product.Product + '</h5>';
                                    html += '<div class="text-center my-4"> <button class="btn btn-warning" id="addToDatabase">Add To Database</button> </div>';
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
                }

            });



            /*------------------------- Adding product to database ---------------------------------------*/

            $(document).on('click', '#addToDatabase', function() {
                let product = $('#prod_name').text();
                let price = $('#prod_price').text();
                let image = $('#prod_img').attr('src');
                let category = prompt("Please Assign Category to this Product", "Category Name");
                alert(category);
            });







            /*------------------------- End ---------------------------------------*/
        });
    </script>
</body>

</html>