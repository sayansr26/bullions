<?php
include('./include/config.php');
include('./include/function.php');


// fetch charges

$chargeQuery = "SELECT * FROM charges";
$statement = $connection->prepare($chargeQuery);
$statement->execute();

$result = $statement->fetchAll();

foreach ($result as $row) {
    $charge = $row['rate'];
    $charge = $charge / 100;
    $charge = $_GET['price'] * $charge;
    $total = $_GET['price'] - $charge;
    $chargeOrder = $row['rate'];

    // echo $chargeOrder;
}

// fetch get data

if (isset($_GET['goldprice'])) {
    $goldprice = $_GET['goldprice'];
    $silverprice = $_GET['silverprice'];
    $quantity = $_GET['quantity'];
    $user = $_GET['phone'];
    $goldbalance = $_GET['gold'];
    $silverbalance = $_GET['silver'];
    $asset = $_GET['product'];
    $amount = $_GET['price'];
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
    <title>Bullions - Confirm Sell</title>
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
                                <h5>Trade Overview</h5>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="user">User : </label>
                                <input type="text" class="form-control" value="<?php echo $user; ?>" disabled>
                                <input type="hidden" name="user" value="<?php echo $user; ?>">
                            </div>
                            <div class="form-group">
                                <label for="balance">Quantity : </label>
                                <input type="text" class="form-control" value="<?php echo $quantity; ?>" disabled>
                                <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Asset : </label>
                                <input type="text" class="form-control" value="<?php echo $asset; ?>" disabled>
                                <input type="hidden" name="asset" value="<?php echo $asset; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Price : </label>
                                <input type="text" class="form-control" value="<?php echo $amount; ?>" disabled>
                                <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Charges ( <?php echo $chargeOrder; ?>% ) : </label>
                                <input type="text" name="charge" class="form-control" value="<?php echo $charge; ?>" disabled>
                                <input type="hidden" id="total" name="total" value="<?php echo $total; ?>">
                                <input type="hidden" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
                                <input type="hidden" id="gold" name="gold" value="<?php echo $goldbalance; ?>">
                                <input type="hidden" id="silver" name="silver" value="<?php echo $silverbalance; ?>">
                                <input type="hidden" id="balance" name="balance" value="<?php echo $withdrawlBalance; ?>">
                            </div>
                            <div class="form-grou">
                                <h5 class="float-end fw-bold">Recived Amount : <?php echo $total; ?></h5>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="button" onclick="trade()" class="btn btn-primary form-control">Complete Trade</button>
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
    <script>
        function trade() {
            $.ajax({
                url: 'server.php?trade=1',
                type: 'post',
                data: $('#pay-data').serialize(),
                success: function(response) {
                    if (response.indexOf('success') != -1) {
                        // alert("redirect");
                        window.location.href = response;
                    } else {
                        alert(response);
                    }
                }
            });
        }
    </script>
</body>

</html>