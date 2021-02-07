<?php

include('include/config.php');
include('include/function.php');

if (!setup()) {



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="../css/master.css">
        <title>Bullions - SignUp</title>
    </head>

    <body>
        <section class="login-wrapper">
            <div class="container">
                <div class="row py-5">
                    <div class="col-lg-6 col-12">
                        <img src="../assets/welcome.svg" alt="welcome" class="img-fluid">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card w-75 mx-auto">
                            <div class="card-body">
                                <h5 class="text-center fw-bold">Get Started !</h5>
                                <br>
                                <form action="#" id="signup-form" method="POST">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Adress">
                                    </div>
                                    <div class="form-group">
                                        <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="setup()" class="btn btn-secondary form-control">Sign Up</button>
                                    </div>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>
        <script>
            function setup() {
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var password = $('#password').val();
                var cpassword = $('#cpassword').val();

                if (name && email && phone & password && cpassword) {
                    if (password != cpassword) {
                        alert('Password mismatch');
                    } else {
                        $.ajax({
                            url: 'server.php?auth=setup',
                            type: 'post',
                            data: $('#signup-form').serialize(),
                            success: function(response) {
                                if (response == 'success') {
                                    alert('Setup successful !');
                                    window.location.href = "/admin-login/";
                                } else {
                                    alert(response);
                                }
                            }
                        });
                    }
                } else {
                    alert('You have to fill all details !');
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('location:login');
}
?>