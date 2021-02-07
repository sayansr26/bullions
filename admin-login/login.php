<?php

include('include/config.php');
include('include/function.php');

if (setup()) {



?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" href="../css/master.css">
        <title>Bullions - Admin Login</title>
    </head>

    <body>
        <section class="login-wrapper my-auto">
            <div class="container">
                <div class="row my-auto py-5">
                    <div class="col-lg-6 col-12">
                        <img src="../assets/welcome.svg" alt="welcome" class="img-fluid">
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card w-75 m-auto">
                            <div class="card-body">
                                <h5 class="text-center fw-bold">Welcome Back !</h5>
                                <br>
                                <form action="#" id="sign-in" method="POST">
                                    <div class="form-group">
                                        <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" onclick="login()" class="btn btn-secondary form-control">Login</button>
                                    </div>
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
            function login() {
                var phone = $('#phone').val();
                var password = $('#password').val();

                if (phone && password) {
                    $.ajax({
                        url: 'server.php?auth=login',
                        type: 'post',
                        data: $('#sign-in').serialize(),
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = "/admin-login/";
                            } else {
                                alert(response);
                            }
                        }
                    });
                } else {
                    alert('All fields are required !');
                }
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('location:setup?msg=setup your account');
}
?>