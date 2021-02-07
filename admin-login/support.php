<?php

include('include/config.php');
include('include/function.php');


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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../css/dashboard.css">
        <title>Bullions - Admin</title>
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

                        <a href="withdrawls" class="nav__link">
                            <i class='bx bx-wallet-alt nav__icon'></i>
                            <span class="nav__name">Withdrawls</span>
                        </a>

                        <a href="trade" class="nav__link">
                            <i class='bx bx-trending-up nav__icon'></i>
                            <span class="nav__name">Trades</span>
                        </a>

                        <a href="support" class="nav__link active">
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
        <div class="container">
            <div class="row py-5">
                <h5 class="text-white fw-bold">Contacts <span class="search-box float-end"><input type="search" placeholder="Search" name="search" id="search"></span></h5>
                <div class="overview">
                    <div class="row">
                        <?php

                        $query = "SELECT * FROM contacts ORDER BY id DESC";
                        $statement = $connection->prepare($query);
                        $statement->execute();

                        $rowCount = $statement->rowCount();

                        if ($rowCount > 0) {
                            // echo "Data";
                            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                $name = $row['name'];
                                $email = $row['email'];
                                $phone = $row['phone'];
                                $date = $row['date'];
                                $query = $row['query'];
                                $id = $row['id'];

                                echo "
                                            <div class='col-12'>
                                                <div class='card my-3 user'>
                                                <div class='card-body'>
                                                        <div class='row'>
                                                            <div class='col-lg-4 col-12 d-flex justify-content-center align-items-center'>
                                                                <i class='bx bx-support mx-auto my-auto' style='color:#333333; font-size: 10rem;'></i>
                                                            </div>
                                                            <div class='col-lg-8 col-12'>
                                                                <h5 class='fw-bold'>$name</h5>
                                                                <h5>$phone</h5>
                                                                <h5>$email</h5>
                                                                <h5>$date</h5>
                                                                <p>$query</p>
                                                                <br>
                                                                <a href='#' class='advance-button shadow'>View&nbsp;&nbsp;<i class='bx bx-right-arrow-alt'></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    ";
                            }
                        } else {
                            echo "<h5 class='text-center'>No data found !</h5>";
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="../js/dashboard.js"></script>

    </body>

    </html>

<?php
} else {
    header('location:login?msg=You have to login first');
}
?>