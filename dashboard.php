<?php

include('./include/config.php');
include('./include/function.php');

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


if (login()) {

    $uid = $_COOKIE['uid'];

    $query = "SELECT * FROM user_data WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'id' => $uid
        )
    );
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $walletBalance = $row['wallet_balance'];
        $widthdrawlBalance  = $row['withdrawl_balance'];
        $goldBalance  = $row['gold_balance'];
        $silverBalance  = $row['silver_balance'];
        $profileStatus = $row['profile_status'];
    }

    // account details capture

    $account = "";
    $banificary = "";
    $ifsc = "";
    $hasaccount = "no";

    $accountQuery = "SELECT * FROM accounts WHERE phone = :phone";
    $statement = $connection->prepare($accountQuery);
    $statement->execute(
        array(
            'phone' => $phone
        )
    );

    $rowCount = $statement->rowCount();

    if ($rowCount > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $account = $row['account'];
            $ifsc = $row['ifsc'];
            $banificary = $row['banificary'];
            $hasaccount = 'yes';
        }
    }



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- bootstrap css -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="./css/dashboard.css">

        <title>Bullions - Dashboard</title>
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
                <img src="./assets/user.png" alt="profile">
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
                        <a href="dashboard" class="nav__link active">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="profile" class="nav__link">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__name">Profile</span>
                        </a>

                        <a href="wallet" class="nav__link">
                            <i class='bx bx-wallet-alt nav__icon'></i>
                            <span class="nav__name">Wallet</span>
                        </a>

                        <a href="trade" class="nav__link">
                            <i class='bx bx-trending-up nav__icon'></i>
                            <span class="nav__name">Buy & Sell</span>
                        </a>

                        <a href="transections" class="nav__link">
                            <i class='bx bx-transfer nav__icon'></i>
                            <span class="nav__name">Transections</span>
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
        <!-- main content -->
        <div class="container">
            <div class="row mt-5 py-3">
                <h5 class="text-white fw-bold mb-3">Overview</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-7 col-12">
                                            <img src="./assets/dashboard.svg" class="img-fluid" alt="dashboard">
                                        </div>
                                        <div class="col-lg-5 col-12 my-auto">
                                            <h5 class="text-center fw-bold my-5">Welcom <?php echo $name; ?> !</h5>
                                            <div class="overview">
                                                <h5 class="overview__title">Wallet Overview</h5>
                                                <br>
                                                <div class="overview__items"><i class='bx bxl-product-hunt icons'></i>&nbsp;Gold Balance <span><?php echo $goldBalance; ?></span></div>
                                                <div class="overview__items"><i class='bx bxl-product-hunt icons'></i>&nbsp;Silver Balance <span><?php echo $silverBalance ?></span></div>
                                                <div class="overview__items"><i class='bx bxs-wallet icons'></i>&nbsp;Wallet Balance <span class="money"><?php echo $walletBalance; ?></span></div>
                                                <div class="overview__items"><i class='bx bxs-wallet icons'></i>&nbsp;Withdrawl Balance <span class="money"><?php echo $widthdrawlBalance; ?></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="overview">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="card mb-2 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="text-center fw-bold"><i class="bx bxs-cart-add"></i>&nbsp;Quick Buy</h5>
                                    <br>
                                    <form action="#" id="buy-now" method="POST">
                                        <input type="hidden" name="goldprice" id="goldprice" value="<?php echo $goldPrice; ?>">
                                        <input type="hidden" name="silverprice" id="silverprice" value="<?php echo $silverPrice; ?>">
                                        <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
                                        <input type="hidden" name="profile" id="profile" value="<?php echo $profileStatus; ?>">
                                        <input type="hidden" name="balance" id="balance" value="<?php echo $walletBalance; ?>">
                                        <input type="hidden" name="gold" id="gold" value="<?php echo $goldBalance; ?>">
                                        <input type="hidden" name="silver" id="silver" value="<?php echo $silverBalance; ?>">
                                        <div class="form-group">
                                            <select name="product" class="form-control" id="product">
                                                <option value="" selected disabled>Asset</option>
                                                <option value="gold">Gold</option>
                                                <option value="silver">Silver</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" min="1" value="1" name="quantity" id="quantity" placeholder="Quantity">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="showprice" id="showprice" disabled placeholder="Price">
                                            <input type="hidden" name="price" id="price">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="buyNow()" class="btn btn-primary shadow form-control">Buy Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="card mb-2 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="text-center fw-bold"><i class="bx bxs-cart-download"></i>&nbsp;Quick Sell</h5>
                                    <br>
                                    <form action="#" id="quick-sell" method="POST">
                                        <input type="hidden" name="goldprice" id="goldprice" value="<?php echo $goldPrice; ?>">
                                        <input type="hidden" name="silverprice" id="silverprice" value="<?php echo $silverPrice; ?>">
                                        <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
                                        <input type="hidden" name="gold" id="gold" value="<?php echo $goldBalance; ?>">
                                        <input type="hidden" name="silver" id="silver" value="<?php echo $silverBalance; ?>">
                                        <div class="form-group">
                                            <select name="sproduct" class="form-control" id="sproduct">
                                                <option value="" selected disabled>Asset</option>
                                                <option value="gold">Gold</option>
                                                <option value="silver">Silver</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="showquantity" placeholder="Quantity" disabled>
                                            <input type="hidden" class="form-control" name="squantity" id="squantity" placeholder="Quantity">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="sshowprice" id="sshowprice" disabled placeholder="Price">
                                            <input type="hidden" name="sprice" id="sprice">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="quicksell()" class="btn btn-primary shadow form-control">Sell Now</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="card mb-2 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="text-center fw-bold"><i class="bx bxs-wallet"></i>&nbsp;Quick Withdrawl</h5>
                                    <br>
                                    <form action="#" id="quick-withdraw" method="POST">
                                        <input type="hidden" name="user" value="<?php echo $phone; ?>">
                                        <input type="hidden" name="profile" id="profile" value="<?php echo $profileStatus; ?>">
                                        <input type="hidden" name="hasaccount" id="hasaccount" value="<?php echo $hasaccount; ?>">
                                        <div class="form-group">
                                            <select name="product" class="form-control" id="product">
                                                <option value="gold">Bank Transfer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" value="<?php echo $widthdrawlBalance; ?>" disabled>
                                            <input type="hidden" name="balance" id="balance" class="form-control" value="<?php echo $widthdrawlBalance; ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="amount" id="amount" placeholder="Withdrawl amount">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="withdraw()" class="btn btn-primary shadow form-control">Withdraw</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="whatsapp-suppurt" target="_blank" href="https://wa.me/9876543210">
            <img src="assets/whatsapp.svg" height="50" width="50" alt="">
        </a>
        <!-- main content -->
        <!-- bootsrap js -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <!--===== MAIN JS =====-->
        <script src="./js/dashboard.js"></script>
        <script>
            // quick buy function start
            function buyNow() {
                var product = $('#product option:selected').val();
                var profileStatus = $('#prfile').val();
                if (product == '') {
                    alert('please choose a asset to buy !');
                } else {
                    $.ajax({
                        url: 'server.php?buy=gold',
                        type: 'post',
                        data: $('#buy-now').serialize(),
                        success: function(response) {
                            window.location.href = response;
                        }
                    });
                }
            }
            $('#product').change(function() {
                var output = $('#product option:selected').val();
                var goldPrice = $('#goldprice').val();
                var silverPrice = $('#silverprice').val();
                var quantity = $('#quantity').val();
                var goldAmount = quantity * goldPrice;
                var silverAmount = quantity * silverPrice;
                if (output == 'gold') {
                    $('#price').val(goldAmount);
                    $('#showprice').val(goldAmount);
                } else if (output == 'silver') {
                    $('#price').val(silverAmount);
                    $('#showprice').val(silverAmount);
                }
            });
            $('#quantity').change(function() {
                var quantity = $('#quantity').val();
                var product = $('#product option:selected').val();
                var goldPrice = $('#goldprice').val();
                var silverPrice = $('#silverprice').val();
                if (product == 'gold') {
                    finalAmount = goldPrice * quantity;
                    $('#price').val(finalAmount);
                    $('#showprice').val(finalAmount);
                } else if (product == 'silver') {
                    finalAmount = silverPrice * quantity;
                    $('#price').val(finalAmount);
                    $('#showprice').val(finalAmount);
                }
            });
            // quick buy function end

            // quic sell function start

            $('#sproduct').change(function() {
                var output = $('#sproduct option:selected').val();
                var goldbalance = $('#gold').val();
                var silverbalance = $('#silver').val();
                var goldprice = $('#goldprice').val();
                var silverprice = $('#silverprice').val();
                if (output == 'gold') {
                    var quantity = goldbalance;
                    var amount = goldbalance * goldprice;
                    $('#showquantity').val(quantity);
                    $('#squantity').val(quantity);
                    $('#sshowprice').val(amount);
                    $('#sprice').val(amount);
                } else {
                    var quantity = silverbalance;
                    var amount = silverbalance * silverprice;
                    $('#showquantity').val(quantity);
                    $('#squantity').val(quantity);
                    $('#sshowprice').val(amount);
                    $('#sprice').val(amount);
                }
            });

            function quicksell() {
                // alert('quick sell');
                var product = $('#sproduct option:selected').val();
                var quantity = $('#squantity').val();
                if (product) {
                    if (quantity > 0) {
                        $.ajax({
                            url: 'server.php?sell=product',
                            type: 'post',
                            data: $('#quick-sell').serialize(),
                            success: function(response) {
                                // alert(response);
                                window.location.href = response;
                            }
                        });
                    } else {
                        alert('Please add quantity ');
                    }
                } else {
                    alert('Please select sell asset !');
                }
            }

            // quic sell function end

            // withdrawl function start
            function withdraw() {
                // alert('withdraw process clicked');
                var amount = $('#amount').val();
                var profile = $('#profile').val();
                var hasaccount = $('#hasaccount').val();
                if (amount == '0' || amount == '') {
                    alert('Please fill withdrawl amount !');
                } else if (hasaccount == 'no') {
                    alert('Please update your withdrawl details in profile');
                } else if (profile == 'not_verified') {
                    alert('Please fill all profile details before request a withdraw !');
                } else {
                    $.ajax({
                        url: 'server.php?withdraw',
                        type: 'post',
                        data: $('#quick-withdraw').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('Withdrawl request successfuly recived !');
                                window.location.href = 'dashboard';
                            } else {
                                alert(response);
                            }
                        }
                    });
                }
            }
            // withdrawl function end
        </script>
    </body>

    </html>

<?php
} else {
    header('location:login?You have to login first');
}

?>