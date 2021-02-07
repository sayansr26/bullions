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
        $profileStatus = $row['profile_status'];
        $walletBalance = $row['wallet_balance'];
        $withdrawlBalance = $row['withdrawl_balance'];
    }
}


// user query 


if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $asset = $_GET['asset'];
    $total = $_GET['total'];
    $orderId = $_GET['orderid'];
    $type = $_GET['type'];
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
    <title>Bullions - Ppayment Success</title>
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
            <div class="col-lg-4 col-12">
                <div class="card shadow product">
                    <div class="card-body">
                        <div class="product__title">
                            <h5>Payment Success !</h5>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="#">User : </label>
                            <input type="text" class="form-control" value="<?php echo $user; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="#">Asset : </label>
                            <input type="text" class="form-control" value="<?php echo $asset; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="#">Amount : </label>
                            <input type="text" class="form-control" value="<?php echo $total; ?>" readonly>
                        </div>
                        <?php

                        if ($type == 'buy') {
                            echo "
                                    <div class='form-group'>
                                        <label for='#'>Order Id : </label>
                                        <input type='text' class='form-control' value='$orderId' readonly>
                                    </div>
                                    <div class='form-group'>
                                        <a href='trade' class='btn btn-primary form-control shadow'>Sell Now</a>
                                    </div>
                                ";
                        } else {
                            echo "
                                    <div class='form-group'>
                                        <a href='wallet' class='btn btn-primary form-control shadow'>Go To Wallet</a>
                                    </div>
                                ";
                        }

                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-4 col-12">
                <img src="./assets/success.svg" alt="success" class="img-fluid">
            </div>
        </div>
    </div>
    <section class="footer">
        <?php include('./components/footer.php') ?>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>