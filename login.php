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


if (!login()) {



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="./css/master.css">
        <title>Bullions - Login</title>
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-theme-trans">
                <div class="container-fluid">
                    <a href="/" class="navbar-brand">Bullions</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a href="#" class="nav-link gold-text">Gold&nbsp;&nbsp;<span class="text-white text-price"><?php echo $goldPrice; ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link silver-text">Silver&nbsp;&nbsp;<span class="text-white text-price"><?php echo $silverPrice; ?></span></a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <?php

                            if (login()) {
                                echo "
                            <li class='nav-item'>
                                <a href='dashboard' class='nav-link btn btn-primary btn-sm'>Go To Dashboard</a>
                            </li>
                        ";
                            } else {
                                echo "
                            <li class='nav-item'>
                                <a href='login' class='nav-link btn btn-primary btn-sm'>Sign In</a>
                            </li>
                        ";
                            }


                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <section class="login-wrapper">
            <div class="container">
                <div class="row my-5 py-5">
                    <div class="col-lg-6 col-12">
                        <img src="./assets/welcome.svg" alt="welcome" class="img-fluid">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card w-75 mx-auto">
                            <div class="card-body">
                                <h5 class="text-center fw-bold">Welcome Back !</h5>
                                <br>
                                <form action="#" id="sign-in-otp" method="POST">
                                    <div class="form-group">
                                        <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="loginOTP()" class="btn btn-secondary form-control">Get OTP</button>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <span onclick="passwordLogin()" class="signup-link">Login With Password</span></p>
                                    </div>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <a href="signup" class="signup-link">Sign Up</a></p>
                                    </div>
                                </form>
                                <form style="display: none;" action="#" id="sign-in-verify" method="POST">
                                    <div class="form-group">
                                        <input type="password" id="otp" name="otp" class="form-control" placeholder="Enter OTP">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="verifyOTP()" class="btn btn-secondary form-control">Verify OTP</button>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <span onclick="passwordLogin()" class="signup-link">Login With Password</span></p>
                                    </div>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <a href="signup" class="signup-link">Sign Up</a></p>
                                    </div>
                                </form>
                                <form style="display: none;" action="#" id="sign-in-password" method="POST">
                                    <div class="form-group">
                                        <input type="phone" name="phone" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="login()" class="btn btn-secondary form-control">Login</button>
                                    </div>
                                    <hr>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <span class="signup-link">Login With Password</span></p>
                                    </div>
                                    <div class="form-group text-center">
                                        <p>Trouble With OTP ? <a href="signup" class="signup-link">Sign Up</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <a class="whatsapp-suppurt" target="_blank" href="https://wa.me/9876543210">
            <img src="assets/whatsapp.svg" height="50" width="50" alt="">
        </a>
        <section class="footer">
            <?php include('./components/footer.php') ?>
        </section>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>
        <script>
            function passwordLogin() {
                $('#sign-in-otp').fadeOut(100);
                $('#sign-in-verify').fadeOut(100);
                $('#sign-in-password').delay(100).fadeIn(100);
            }

            function login() {
                $.ajax({
                    url: 'server.php?auth=login&type=2',
                    type: 'POST',
                    data: $('#sign-in-password').serialize(),
                    success: function(response) {
                        if (response == 'success') {
                            window.location.href = 'dashboard';
                        } else {
                            alert(response);
                        }
                    }
                });
            }

            function loginOTP() {
                var phone = $('#phone').val();
                if (phone) {
                    $.ajax({
                        url: 'server.php?auth=login&type=1',
                        type: 'post',
                        data: $('#sign-in-otp').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                alert('OTP Send successfuly !');
                                $('#sign-in-otp').fadeOut(100);
                                $('#sign-in-password').fadeOut(100);
                                $('#sign-in-verify').delay(100).fadeIn(100);
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('Phone number is required');
                }
            }

            function verifyOTP() {
                var otp = $('#otp').val();
                if (otp) {
                    $.ajax({
                        url: 'server.php?auth=verify',
                        type: 'post',
                        data: $('#sign-in-verify').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                windwo.location.href = 'dashboard';
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('Plese Enter OTP !');
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('location:dashboard');
}

?>