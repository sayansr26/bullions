<?php

include('include/config.php');
include('include/function.php');


// get withdraw details

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM withdrawls WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->execute(
        array(
            'id' => $id
        )
    );

    $result = $statement->fetchAll();


    foreach ($result as $row) {
        $banificary  = $row['banificary'];
        $account  = $row['account'];
        $ifsc  = $row['ifsc'];
        $amount  = $row['amount'];
        $status  = $row['status'];
        $date  = $row['date'];
        $user  = $row['user'];
    }
}


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
        <link rel="stylesheet" href="../css/dashboard.css">

        <title>Bullions - User Profile</title>
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
                        <a href="/admin-login/" class="nav__link">
                            <i class='bx bx-grid-alt nav__icon'></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="users" class="nav__link">
                            <i class='bx bx-user nav__icon'></i>
                            <span class="nav__name">Users</span>
                        </a>

                        <a href="withdrawls" class="nav__link active">
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
        <!-- main content -->
        <div class="container">
            <div class="row mt-5 py-3">
                <h5 class="text-white fw-bold mb-3">Withdraw Details</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="#" method="POST" id="withdraw-form">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <h5 class="fw-bold">Account Details</h5>
                                        <hr class="w-25">
                                        <div class="input-group">
                                            <span class="input-group-text">Banificary Name :</span>
                                            <input type="text" name="banificary" id="banificary" value="<?php echo $banificary ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Account Number :</span>
                                            <input type="text" name="account" id="account" value="<?php echo $account ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">IFSC Code :</span>
                                            <input type="text" name="ifsc" id="ifsc" value="<?php echo $ifsc ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Amount Rs. :</span>
                                            <input type="text" name="amount" id="amount" value="<?php echo $amount ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Phone :</span>
                                            <input type="text" name="phone" id="phone" value="<?php echo $user ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Date :</span>
                                            <input type="datetime" name="date" id="date" value="<?php echo $date ?>" class="form-control" readonly>
                                            <span class="input-group-text"><i class='bx bx-clipboard'></i></span>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">Status :</span>
                                            <select name="status" id="status" class="form-control">
                                                <option selected value="<?php echo $status ?>"><?php echo $status ?></option>
                                                <option value="success">Success</option>
                                                <option value="faield">Faield</option>
                                            </select>
                                            <span class="input-group-text"><i class='bx bx-chevron-down'></i></span>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <button type="button" onclick="accept()" class="btn btn-primary form-control shadow">Accept Request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main content -->
        <!-- toast -->
        <div class="toast-container position-absolute top-0 end-0 p-3">

            <!-- Then put toasts within -->
            <div class="toast w-auto" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i style="font-size:15px;" class="bx bx-bell rounded me-2"></i>
                    <strong class="me-auto">Notification</strong>
                    <small class="text-muted">just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">

                </div>
            </div>
        </div>
        <!-- toast -->
        <!-- bootsrap js -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <!--===== MAIN JS =====-->
        <script src="../js/dashboard.js"></script>
        <script>
            function accept() {
                var status = $('#status option:selected').val();

                if (status == 'pending' || status == 'success') {
                    $.ajax({
                        url: 'server.php?withdraw=1',
                        type: 'post',
                        data: $('#withdraw-form').serialize(),
                        success: function(response) {
                            // alert(response);
                            if (response == 'success') {
                                $('.toast-body').html('Withdrawl request accepted successful !');
                                $('#toast').toast('show');
                                setTimeout(function() {
                                    window.location.href = "withdrawls";
                                }, 2000);
                            } else {
                                $('.toast-body').html(response);
                                $('#toast').toast('show');
                            }
                        }
                    });
                } else if (status == 'faield') {
                    $.ajax({
                        url: 'server.php?withdraw=2',
                        type: 'post',
                        data: $('#withdraw-form').serialize(),
                        success: function(response) {
                            // alert(response);
                            if (response == 'success') {
                                $('.toast-body').html('Withdrawl request accepted successful !');
                                $('#toast').toast('show');
                                setTimeout(function() {
                                    window.location.href = "withdrawls";
                                }, 2000);
                            } else {
                                $('.toast-body').html(response);
                                $('#toast').toast('show');
                            }
                        }
                    });
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('location:login?You have to login first');
}

?>