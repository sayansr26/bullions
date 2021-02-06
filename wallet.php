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

        <title>Bullions - User Wallet</title>
    </head>

    <body id="body-pd">
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="header__pricebox">
                <a href="#" class="nav-link gold-text">Gold&nbsp;&nbsp;<span class="text-white text-price"><?php echo $goldPrice ?></span></a>
                <a href="#" class="nav-link silver-text">Silver&nbsp;&nbsp;<span class="text-white text-price"><?php echo $silverPrice ?></span></a>
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
                        <a href="dashboard" class="nav__link">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="profile" class="nav__link">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__name">Profile</span>
                        </a>

                        <a href="wallet" class="nav__link active">
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
        <div class="container wallet">
            <div class="row mt-5 py-3">
                <h5 class="text-white fw-bold mb-3">Wallet</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="card my-5 my-lg-0">
                                <div class="card-body">
                                    <img src="./assets/wallet.svg" alt="wallet" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <h5 class="text-white fw-bold">Welcome <?php echo $name; ?> !</h5>
                            <hr>
                            <br>
                            <h6 class="text-white"><strong>Wallet Blance : </strong>&nbsp;<span class="text-price"><?php echo $walletBalance; ?></span></h6>
                            <h6 class="text-white"><strong>Withdrawl Blance : </strong>&nbsp;<span class="text-price"><?php echo $widthdrawlBalance; ?></span></h6>
                            <h6 class="text-white"><strong>Gold Blance : </strong>&nbsp;<span><?php echo $goldBalance; ?> grams</span></h6>
                            <h6 class="text-white"><strong>Silver Blance : </strong>&nbsp;<span><?php echo $silverBalance; ?> grams</span></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="overview">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-12">
                                            <img src="./assets/transfer.svg" alt="transfer" class="img-fluid">
                                        </div>
                                        <div class="col-lg-8 col-12 custom-border">
                                            <h5 class="fw-bold">Request an withdrawl !</h5>
                                            <br>
                                            <form action="#" id="withdraw-form" method="POST">
                                                <input type="hidden" name="user" value="<?php echo $phone; ?>">
                                                <input type="hidden" name="profile" id="profile" value="<?php echo $profileStatus; ?>">
                                                <input type="hidden" name="hasaccount" id="hasaccount" value="<?php echo $hasaccount; ?>">
                                                <div class="form-group">
                                                    <input type="number" class="form-control" value="<?php echo $widthdrawlBalance; ?>" disabled>
                                                    <input type="hidden" name="balance" id="balance" class="form-control" value="<?php echo $widthdrawlBalance; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" name="amount" id="amount" placeholder="Withdrawl amount">
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <button type="button" onclick="withdraw()" class="btn btn-primary form-control">Withdraw</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content -->
        <!-- bootsrap js -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <!--===== MAIN JS =====-->
        <script src="./js/dashboard.js"></script>
        <script>
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
                        data: $('#withdraw-form').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('Withdrawl request successfuly recived !');
                                window.location.href = 'wallet';
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