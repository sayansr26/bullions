<?php
include('./include/config.php');
include('./include/function.php');
require_once('./vendors/razorpay-php/Razorpay.php');
// get payment details

if (isset($_GET['phone'])) {
    $user = $_GET['phone'];
    $asset = $_GET['asset'];
    $quantity = $_GET['quantity'];
    $price = $_GET['price'];
    $balance = $_GET['balance'];
    $goldbalance = $_GET['gold'];
    $silverbalance = $_GET['silver'];

    if ($balance > 0) {
        $total = ($price - $balance);
    } else {
        $total = $price;
    }
}

$razorpayAmount = $total * 100;

// razorpay process

use Razorpay\Api\Api;

if ($total > 0) {
    $keyId = 'rzp_test_5vgRViRUnh5nEv';
    $secretKey = 'ktbqY9KlYVEnkixP6yjKCFai';
    $api = new Api($keyId, $secretKey);
    $order = $api->order->create(array(
        'amount' => $razorpayAmount,
        'payment_capture' => 1,
        'currency' => 'INR'
    ));
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
        $profileStatus = $row['profile_status'];
        $walletBalance = $row['wallet_balance'];
        $withdrawlBalance = $row['withdrawl_balance'];
    }
}

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
    <link rel="stylesheet" href="./css/master.css">
    <title>Bullions - Payment</title>
</head>

<style>
    #loading {
        position: fixed;
        width: 100%;
        height: 100vh;
        background: #1B1E26 url('https://media.giphy.com/media/11FuEnXyGsXFba/giphy.gif') no-repeat center center;
        z-index: 99999;
    }
</style>

<body>
    <div style="display: none;" id="loading"></div>
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
    <div class="container">
        <div class="row my-5 py-5">
            <div class="col-lg-6 col-12">
                <img src="./assets/shop.svg" alt="shop" class="img-fluid">
            </div>
            <div class="col-lg-4 offset-lg-2 col-12">
                <div class="card shadow product">
                    <div class="card-body">
                        <form action="#" id="pay-data" method="POST">
                            <div class="product__title">
                                <i class='bx bxs-cart-add'></i>
                                <h5>Purchase Overview</h5>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="user">User : </label>
                                <input type="text" class="form-control" value="<?php echo $user; ?>" disabled>
                                <input type="hidden" name="user" value="<?php echo $user; ?>">
                            </div>
                            <div class="form-group">
                                <label for="balance">Balance : </label>
                                <input type="text" class="form-control" value="<?php echo $balance; ?>" disabled>
                                <input type="hidden" name="balance" value="<?php echo $balance; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Asset : </label>
                                <input type="text" class="form-control" value="<?php echo $asset; ?>" disabled>
                                <input type="hidden" name="asset" value="<?php echo $asset; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Price : </label>
                                <input type="text" class="form-control" value="<?php echo $price; ?>" disabled>
                                <input type="hidden" name="amount" value="<?php echo $price; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Charges : </label>
                                <input type="text" name="charge" class="form-control" value="<?php echo '0'; ?>" disabled>
                                <input type="hidden" id="pay_id" name="pay_id">
                                <input type="hidden" id="order_id" name="order_id">
                                <input type="hidden" id="total" name="total" value="<?php echo $total; ?>">
                                <input type="hidden" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
                                <input type="hidden" id="gold" name="gold" value="<?php echo $goldbalance; ?>">
                                <input type="hidden" id="silver" name="silver" value="<?php echo $silverbalance; ?>">
                            </div>
                            <div class="form-grou">
                                <h5 class="float-end fw-bold">Total : <?php echo $total; ?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary form-control" id='rzp-button1'>Complete Purchase</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="footer">
        <?php include('./components/footer.php') ?>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "<?php echo $keyId; ?>", // Enter the Key ID generated from the Dashboard
            "amount": "<?php echo $order->amount; ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Bullions",
            "description": "Purchase Gold & Silver",
            "image": "https://picsum.photos/500",
            "order_id": "<?php echo $order->id ?>",
            "handler": function(response) {
                // alert(response.razorpay_payment_id);
                $('#pay_id').val(response.razorpay_payment_id);
                $('#order_id').val(response.razorpay_order_id);
                $('#loading').show();
                $.ajax({
                    url: 'server.php?payment=gold',
                    type: 'post',
                    data: $('#pay-data').serialize(),
                    success: function(respo) {
                        // alert(respo);
                        if (respo.indexOf('success') != -1) {
                            // alert("redirect");
                            window.location.href = respo;
                        } else {
                            alert(respo);
                        }
                    }
                });
            },
            "prefill": {
                "name": "<?php echo $name; ?>",
                "email": "<?php echo $email; ?>",
                "contact": "<?php echo $phone; ?>"
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#ffd700"
            },
            "method": {
                "netbanking": "0",
                "card": "0",
                "upi": "0",
                "wallet": "1",
                "emi": "1",
                "paylater": "1"
            }

        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            alert(response.error.code);
            alert(response.error.description);
            alert(response.error.source);
            alert(response.error.step);
            alert(response.error.reason);
            alert(response.error.metadata.order_id);
            alert(response.error.metadata.payment_id);
        });
        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            // $('#loading').show();
            e.preventDefault();
        }
    </script>
</body>

</html>