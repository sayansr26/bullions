<?php

include('include/config.php');
include('include/function.php');


// fetch the product prices

$goldQuery = "SELECT * FROM product_rate WHERE product = :product1";
$silverQuery = "SELECT * FROM product_rate WHERE product = :product2";
$statement1 = $connection->prepare($goldQuery);
$statement2 = $connection->prepare($silverQuery);
$statement1->execute(
    array(
        'product1' => 'gold'
    )
);
$statement2->execute(
    array(
        'product2' => 'silver'
    )
);

$result1 = $statement1->fetchAll();
$result2 = $statement2->fetchAll();

foreach ($result1 as $row1) {
    $goldPrice = $row1['price'];
}

foreach ($result2 as $row2) {
    $silverPrice = $row2['price'];
    // echo $silverPrice;
}

// details for overview

$goldBuyQuery = "SELECT * FROM transections WHERE asset = 'gold' AND type = 'buy'";
$goldSellQuery = "SELECT * FROM transections WHERE asset = 'gold' AND type = 'sell'";
$silverBuyQuery = "SELECT * FROM transections WHERE asset = 'silver' AND type = 'buy'";
$silverSellQuery = "SELECT * FROM transections WHERE asset = 'silver' AND type = 'sell'";

$goldBuyStatement = $connection->prepare($goldBuyQuery);
$goldSellStatement = $connection->prepare($goldSellQuery);
$silverBuyStatement = $connection->prepare($silverBuyQuery);
$silverSellStatement = $connection->prepare($silverSellQuery);


$goldBuyCount = $goldBuyStatement->rowCount();
$goldSellCount = $goldSellStatement->rowCount();
$silverBuyCount = $silverBuyStatement->rowCount();
$silverSellCount = $silverSellStatement->rowCount();


// charge query 

$chargeQuery = "SELECT * FROM charges";
$statement = $connection->prepare($chargeQuery);
$statement->execute();

$result = $statement->fetchAll();

foreach ($result as $row) {
    $rate = $row['rate'];
}

if (login()) {



?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../css/dashboard.css">
        <title>Bullions - Admin</title>
    </head>

    <body id="body-pd">
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="header__pricebox">
                <a href="#" class="nav-link gold-text">Gold&nbsp;&nbsp;<span class="text-white text-price"><?php echo $goldPrice; ?></span></a>
                <a href="#" class="nav-link silver-text">Silver&nbsp;&nbsp;<span class="text-white text-price"><?php echo $silverPrice; ?></span></a>
            </div>
            <div class="header__img">
                <img src="../assets/user.png" alt="profile">
            </div>
        </header>

        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a href="/" class="nav__logo">
                        <i class='bx bxl-redux nav__logo-icon'></i>
                        <span class="nav__logo-name">Bullions</span>
                    </a>

                    <div class="nav__list">
                        <a href="/admin-login/" class="nav__link active">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="users" class="nav__link">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__name">Users</span>
                        </a>

                        <a href="withdrawls" class="nav__link">
                            <i class='bx bx-wallet-alt nav__icon'></i>
                            <span class="nav__name">Withdrawls</span>
                        </a>

                        <a href="trade" class="nav__link">
                            <i class='bx bx-trending-up nav__icon'></i>
                            <span class="nav__name">Trades</span>
                        </a>

                        <a href="support" class="nav__link">
                            <i class='bx bx-support nav__icon'></i>
                            <span class="nav__name">Support</span>
                        </a>
                    </div>
                </div>

                <a href="logout" class="nav__link">
                    <i class='bx bx-log-out nav__icon'></i>
                    <span class="nav__name">Log Out</span>
                </a>
            </nav>
        </div>
        <!-- main content start -->
        <div class="container">
            <div class="row py-5">
                <h5 class="text-white fw-bold">Overview</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-lg-3 col-12">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <div class="admin-card__hero">
                                        <h1 class="admin-card__hero-icon"><i class='bx bxs-cube-alt'></i></h1><span class="admin-card__hero-text"><?php echo $goldSellCount; ?></span>
                                    </div>
                                    <hr>
                                    <p class="admin-card__desc">Total Gold Sell <span class="float-end text-danger"><i class='bx bxs-down-arrow-circle'></i></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <div class="admin-card__hero">
                                        <h1 class="admin-card__hero-icon"><i class='bx bxs-cube-alt'></i></h1><span class="admin-card__hero-text"><?php echo $silverSellCount; ?></span>
                                    </div>
                                    <hr>
                                    <p class="admin-card__desc">Total Silver Sell <span class="float-end text-danger"><i class='bx bxs-down-arrow-circle'></i></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <div class="admin-card__hero">
                                        <h1 class="admin-card__hero-icon"><i class='bx bxs-cube-alt'></i></h1><span class="admin-card__hero-text"><?php echo $goldBuyCount; ?></span>
                                    </div>
                                    <hr>
                                    <p class="admin-card__desc">Total Gold Buy <span class="float-end text-success"><i class='bx bxs-up-arrow-circle'></i></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12">
                            <div class="card admin-card">
                                <div class="card-body">
                                    <div class="admin-card__hero">
                                        <h1 class="admin-card__hero-icon"><i class='bx bxs-cube-alt'></i></h1><span class="admin-card__hero-text"><?php echo $silverBuyCount; ?></span>
                                    </div>
                                    <hr>
                                    <p class="admin-card__desc">Total Silver Buy <span class="float-end text-success"><i class='bx bxs-up-arrow-circle'></i></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="text-white my-3 fw-bold">Quick Setup</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">Setup Charges</h5>
                                    <hr>
                                    <form action="#" id="charge-form" method="POST">
                                        <div class="form-group">
                                            <select name="currency" id="currency" class="form-control">
                                                <option value="inr">INR</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="rate" id="rate" class="form-control" value="<?php echo $rate; ?>" placeholder="Rate">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="updaterate()" class="btn btn-primary shadow form-control">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bold">Setup Product Rate</h5>
                                    <hr>
                                    <form action="#" id="product-form" method="POST">
                                        <input type="hidden" name="goldprice" id="goldprice" value="<?php echo $goldPrice; ?>">
                                        <input type="hidden" name="silverprice" id="silverprice" value="<?php echo $silverPrice; ?>">
                                        <div class="form-group">
                                            <select name="product" id="product" class="form-control">
                                                <option value="" selected disabled>Choose Asset</option>
                                                <option value="gold">Gold</option>
                                                <option value="silver">Silver</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="price" id="price" class="form-control" placeholder="Price">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="updateprice()" class="btn btn-primary shadow form-control">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content end -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="../js/dashboard.js"></script>
        <script>
            // product price change function

            $('#product').change(function() {
                var output = $('#product option:selected').val();
                var goldPrice = $('#goldprice').val();
                var silverPrice = $('#silverprice').val();

                if (output == 'gold') {
                    $('#price').val(goldPrice);
                } else if (output == 'silver') {
                    $('#price').val(silverPrice);
                }
            });

            function updateprice() {
                var product = $('#product option:selected').val();
                var price = $('#price').val();

                if (product && price) {
                    $.ajax({
                        url: 'server.php?update=price',
                        type: 'post',
                        data: $('#product-form').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('Product price updated successfuly !');
                                window.location.href = "/admin-login/";
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('Select all fields !');
                }
            }

            // update charges
            function updaterate() {
                var rate = $('#rate').val();

                if (rate) {
                    $.ajax({
                        url: 'server.php?update=charge',
                        type: 'post',
                        data: $('#charge-form').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('Charges updated successfuly !');
                                window.location.href = "/admin-login/";
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('Fill all details');
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('location:login?msg=You have to login first');
}
?>