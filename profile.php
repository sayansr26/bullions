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
        $profile = $row['profile_status'];
        $address = $row['address'];
        $state = $row['state'];
        $city = $row['city'];
        $district = $row['district'];
        $pancard = $row['pancard'];
        $idcard = $row['idcard'];

        if ($profileStatus == 'not_verified') {
            $profileStatus = "<span class='text-danger'><i class='bx bx-user-x'></i>&nbsp;Not Verified</span>";
        } else {
            $profileStatus = "<span class='text-success'><i class='bx bx-user-check'></i>&nbsp;Verified</span>";
        }
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

        <title>Bullions - User Profile</title>
    </head>

    <body id="body-pd">
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="header__pricebox">
                <a href="#" class="nav-link gold-text">Gold&nbsp;&nbsp;<span class="text-white text-price"><?php echo $goldPrice; ?></span></a>
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

                        <a href="profile" class="nav__link active">
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
                <h5 class="text-white fw-bold mb-3">Profile</h5>
                <div class="overview">
                    <div class="row">
                        <div class="col-lg-4 col-12 my-auto">
                            <div class="card my-5 my-lg-0">
                                <div class="card-body">
                                    <div class="profile-card">
                                        <img src="./assets/user.png" alt="user" class="img-fluid">
                                        <div class="profile-details">
                                            <h5><?php echo $name; ?></h5>
                                            <span><?php echo $email; ?></span>
                                            <span><?php echo $phone; ?></span>
                                            <?php echo $profileStatus; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="basic-details">
                                <h5 class="text-white fw-bold">Basic Details <span onclick="profileedit()" class="custom-icon-button float-end me-5"><i class='bx bx-edit'></i></span></h5>
                                <hr>
                                <form action="#" id="basic-details" method="POST">
                                    <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" placeholder="Full Name" class="form-control" value="<?php echo $name; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" placeholder="Email Address" class="form-control" value="<?php echo $email; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="phone" name="phone" id="phone" placeholder="Phone Number" class="form-control" value="<?php echo $phone; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <button id="profilebutton" onclick="updateprofile()" type="button" style="display: none;" class="btn btn-primary form-control shadow">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                            <div class="kyc-details">
                                <h5 class="text-white fw-bold">Kyc Details <span onclick="keceditunlock()" class="custom-icon-button float-end me-5"><i class='bx bx-edit'></i></span></h5>
                                <hr>
                                <form action="#" id="kyc-details" method="POST">
                                    <input type="hidden" name="profile" id="profile" value="<?php echo $profile; ?>">
                                    <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" name="address" id="address" class="form-control" value="<?php echo $address; ?>" placeholder="Enter your address" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <div class="form-group">
                                                <input type="text" name="district" id="district" class="form-control" value="<?php echo $district; ?>" placeholder="Your district name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <div class="form-group">
                                                <input type="text" name="city" id="city" class="form-control" value="<?php echo $city; ?>" placeholder="You city name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <div class="form-group">
                                                <input type="text" name="state" id="state" class="form-control" value="<?php echo $state; ?>" placeholder="Your state name" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <input type="text" name="pancard" id="pancard" class="form-control" value="<?php echo $pancard; ?>" placeholder="Your PANCARD Number" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group">
                                                <input type="text" name="idcard" id="idcard" class="form-control" value="<?php echo $idcard; ?>" placeholder="Your ID Card Number" disabled>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button id="kycbutton" type="button" onclick="updatekyc()" style="display: none;" class="btn btn-primary form-control shadow">Update KYC Details</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="account-details">
                                <h5 class="text-white fw-bold">Withdraw Details <span onclick="accountedit()" class="custom-icon-button float-end me-5"><i class='bx bx-edit'></i></span></h5>
                                <hr>
                                <form action="#" id="account-details" method="POST">
                                    <input type="hidden" name="phone" value="<?php echo $phone; ?>">
                                    <input type="hidden" name="hasaccount" id="hasaccount" value="<?php echo $hasaccount; ?>">
                                    <?php
                                    if ($hasaccount == 'no') {
                                        echo "
                                                <div class='form-group'>
                                                    <input type='text' name='banificary' id='banificary' placeholder='Banificary' class='form-control' value='' disabled>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='text' name='account' id='account' placeholder='Account Number' class='form-control' value='' disabled>
                                                </div>
                                                <div id='confirmaccount' style='display: none;' class='form-group'>
                                                    <input type='text' name='caccount' id='caccount' placeholder='Cofirm Account Number' class='form-control' value='' disabled>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='text' name='ifsc' id='ifsc' placeholder='IFSC Code' class='form-control' value='' disabled>
                                                </div>
                                            ";
                                    } else {
                                        echo "
                                                <div class='form-group'>
                                                    <input type='text' name='banificary' id='banificary' placeholder='Banificary' class='form-control' value='$banificary' disabled>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='text' name='account' id='account' placeholder='Account Number' class='form-control' value='$account' disabled>
                                                </div>
                                                <div id='confirmaccount' style='display: none;' class='form-group'>
                                                    <input type='text' name='caccount' id='caccount' placeholder='Cofirm Account Number' class='form-control' value='' disabled>
                                                </div>
                                                <div class='form-group'>
                                                    <input type='text' name='ifsc' id='ifsc' placeholder='IFSC Code' class='form-control' value='$ifsc' disabled>
                                                </div>
                                            ";
                                    }
                                    ?>
                                    <div class="form-group">
                                        <button id="accountbutton" onclick="updateaacount()" type="button" style="display: none;" class="btn btn-primary form-control shadow">Update Account Details</button>
                                    </div>
                                </form>
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
            // kyc edit system
            function keceditunlock() {
                // alert('Kyc unlocked');

                var profile = $('#profile').val();
                if (profile == 'not_verified') {
                    $('#address').removeAttr('disabled');
                    $('#address').val('');
                    $('#district').removeAttr('disabled');
                    $('#district').val('');
                    $('#state').removeAttr('disabled');
                    $('#state').val('');
                    $('#city').removeAttr('disabled');
                    $('#city').val('');
                    $('#pancard').removeAttr('disabled');
                    $('#pancard').val('');
                    $('#idcard').removeAttr('disabled');
                    $('#idcard').val('');
                    $('#address').focus();
                    $('#kycbutton').fadeIn(500);
                } else {
                    alert('You cant edit your KYC details');
                }
            }

            // profile details edit system

            function profileedit() {
                // alert('Profile edit clicked');
                $('#name').removeAttr('disabled');
                $('#email').removeAttr('disabled');
                $('#name').focus();
                $('#profilebutton').fadeIn(500);
            }

            // update kyc details 

            function updatekyc() {
                var address = $('#address').val();
                var district = $('#district').val();
                var city = $('#city').val();
                var state = $('#state').val();
                var pancard = $('#pancard').val();
                var idcard = $('#idcard').val();

                if (address && district && city && state && pancard && idcard) {
                    // alert('Good');
                    $.ajax({
                        url: 'server.php?update=kyc',
                        type: 'post',
                        data: $('#kyc-details').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('All details updated successfuly !');
                                window.location.href = 'profile';
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('All fields are required');
                }
            }

            // function for update profile

            function updateprofile() {
                var name = $('#name').val();
                var email = $('#email').val();

                if (name && email) {
                    $.ajax({
                        url: 'server.php?update=profile',
                        type: 'post',
                        data: $('#basic-details').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('Details updated successfuly !');
                                window.location.href = 'profile';
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('Please enter name and email');
                }
            }

            // account edit function 

            function accountedit() {
                // alert('Account edit clicked');
                var hasaccount = $('#hasaccount').val();
                if (hasaccount == 'no') {
                    $('#banificary').removeAttr('disabled');
                    $('#account').removeAttr('disabled');
                    $('#caccount').removeAttr('disabled');
                    $('#ifsc').removeAttr('disabled');
                    $('#banificary').focus();
                    $('#accountbutton').fadeIn(500);
                    $('#confirmaccount').fadeIn(500);
                } else {
                    alert('You cant edit account details, contact admin !');
                }
            }

            // update account function

            function updateaacount() {
                var account = $('#account').val();
                var caccount = $('#caccount').val();
                var ifsc = $('#ifsc').val();
                var banificary = $('#banificary').val();

                if (account && caccount && ifsc && banificary) {

                    if (account != caccount) {
                        alert('Account mismatch !');
                    } else {
                        // alert('Good');
                        $.ajax({
                            url: 'server.php?update=account',
                            type: 'post',
                            data: $('#account-details').serialize(),
                            success: function(response) {
                                // alert(response);
                                if (response == 'success') {
                                    alert('Details added sucessfuly !');
                                    window.location.href = 'profile';
                                } else {
                                    alert(response);
                                }
                            }
                        });
                    }
                } else {
                    alert('All details are required !');
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