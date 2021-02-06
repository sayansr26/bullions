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
        $goldBalace = $row['gold_balance'];
        $silverBalance = $row['silver_balance'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="./css/master.css">
    <title>Bullions</title>
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
    <section class="hero">
        <div class="container">
            <div class="row py-5">
                <h1 class="text-center text-white">Buy Gold & Silver At Best Rate</h1>
                <div class="col-lg-6 col-10 mx-auto my-5">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-3"><i class="fas fa-cart-plus"></i>&nbsp;Quick Buy</h3>
                            <br>
                            <form action="#" id="buy-now" method="POST">
                                <input type="hidden" name="goldprice" id="goldprice" value="<?php echo $goldPrice; ?>">
                                <input type="hidden" name="silverprice" id="silverprice" value="<?php echo $silverPrice; ?>">
                                <input type="hidden" name="phone" id="phone" value="<?php echo $phone; ?>">
                                <input type="hidden" name="profile" id="profile" value="<?php echo $profileStatus; ?>">
                                <input type="hidden" name="balance" id="balance" value="<?php echo $walletBalance; ?>">
                                <input type="hidden" name="gold" id="gold" value="<?php echo $goldBalance; ?>">
                                <input type="hidden" name="silver" id="silver" value="<?php echo $silverBalance; ?>">
                                <div class="row">
                                    <div class="col-lg-4 col-12">
                                        <div class="form-pill">
                                            <i class="fab fa-product-hunt"></i>
                                            <select name="product" id="product">
                                                <option value="" selected disabled>Asset</option>
                                                <option value="gold">Gold</option>
                                                <option value="silver">Silver</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-pill">
                                            <i class="fas fa-cube"></i>
                                            <input type="number" name="quantity" min="1" value="1" id="quantity" placeholder="Quantity">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <div class="form-pill">
                                            <i class="fas fa-rupee-sign"></i>
                                            <input type="number" name="showprice" id="showprice" disabled placeholder="Price">
                                            <input type="hidden" name="price" id="price">
                                        </div>
                                    </div>
                                    <?php
                                    if (login()) {
                                        echo "
                                                <div class='col-8 mx-auto my-5'>
                                                    <button type='button' onclick='buyNow()' class='btn btn-primary shadow form-control'>Buy Now</button>
                                                </div>
                                            ";
                                    } else {
                                        echo "
                                                <div class='col-8 mx-auto my-5'>
                                                    <a href='login' class='btn btn-primary shadow form-control'>Buy Now</a>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="how-it-works">
        <div class="container">
            <div class="feature-badge">
                <h1>
                    <i class="fas fa-arrow-circle-down"></i>
                </h1>
            </div>
            <h3 class="text-center text-white fw-bold">How it works</h3>
            <div class="row py-5">
                <div class="col-12">
                    <div class="stepper-container-horizontal">
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <div class="content">
                                    <h1>
                                        <i class="fas fa-user-circle"></i>
                                    </h1>
                                </div>
                                <h5 class="text-center text-white fw-bold">Step 1</h5>
                                <p class="text-center text-light">Create an account</p>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="content">
                                    <h1>
                                        <i class="fas fa-edit"></i>
                                    </h1>
                                </div>
                                <h5 class="text-center text-white fw-bold">Step 2</h5>
                                <p class="text-center text-light">Fill basic details</p>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="content">
                                    <h1>
                                        <i class="fas fa-luggage-cart"></i>
                                    </h1>
                                </div>
                                <h5 class="text-center text-white fw-bold">Step 3</h5>
                                <p class="text-center text-light">Create an account</p>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="content">
                                    <h1>
                                        <i class="fas fa-wallet"></i>
                                    </h1>
                                </div>
                                <h5 class="text-center text-white fw-bold">Step 4</h5>
                                <p class="text-center text-light">Withdraw money</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <div class="feature-badge">
                <h1>
                    <i class="fas fa-arrow-circle-down"></i>
                </h1>
            </div>
            <h3 class="text-center text-white mb-5 fw-bold">What our customers say</h3>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./assets/image.jpg" alt="imag1" class="rounded-circle shadow client-img mx-auto d-block">
                        <p class="client-description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione tenetur voluptas eos praesentium nemo assumenda aut esse molestiae rerum eius.</p>
                        <h3 class="client-name">John Doe</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/image2.jpg" alt="imag1" class="rounded-circle shadow client-img mx-auto d-block">
                        <p class="client-description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione tenetur voluptas eos praesentium nemo assumenda aut esse molestiae rerum eius.</p>
                        <h3 class="client-name">John Doe</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="./assets/image3.jpg" alt="imag1" class="rounded-circle shadow client-img mx-auto d-block">
                        <p class="client-description">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione tenetur voluptas eos praesentium nemo assumenda aut esse molestiae rerum eius.</p>
                        <h3 class="client-name">John Doe</h3>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
    </section>
    <section class="contact">
        <div class="container">
            <div class="feature-badge">
                <h1>
                    <i class="fas fa-arrow-circle-down"></i>
                </h1>
            </div>
            <h3 class="text-center text-white fw-bold">Contact</h3>
            <div class="row py-5">
                <div class="col-lg-6 col-12">
                    <img src="./assets/contact.png" alt="contact" class="img-fluid my-auto">
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card w-75 mx-auto">
                        <div class="card-body">
                            <h5 class="text-center">Get In Touch</h5>
                            <br>
                            <form action="#" method="POST" id="contact">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Full Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="form-group">
                                    <textarea name="query" id="query" class="form-control" cols="30" placeholder="Your query" rows="3"></textarea>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button type="button" onclick="contact()" class="btn btn-secondary form-control">
                                        Send &nbsp;<i class="fas fa-share"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="footer">
        <?php include('./components/footer.php') ?>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"></script>
    <script>
        function buyNow() {
            var product = $('#product option:selected').val();
            var profileStatus = $('#prfile').val();
            if (product == '') {
                alert('please choose a asset to buy !');
            } else {
                $.ajax({
                    url: 'server.php?buy=gold',
                    type: 'post',
                    data: $('#buy-now').serialize(),
                    success: function(response) {
                        window.location.href = response;
                    }
                });
            }
        }
        $('#product').change(function() {
            var output = $('#product option:selected').val();
            var goldPrice = $('#goldprice').val();
            var silverPrice = $('#silverprice').val();
            var quantity = $('#quantity').val();
            var goldAmount = quantity * goldPrice;
            var silverAmount = quantity * silverPrice;
            if (output == 'gold') {
                $('#price').val(goldAmount);
                $('#showprice').val(goldAmount);
            } else if (output == 'silver') {
                $('#price').val(silverAmount);
                $('#showprice').val(silverAmount);
            }
        });
        $('#quantity').change(function() {
            var quantity = $('#quantity').val();
            var product = $('#product option:selected').val();
            var goldPrice = $('#goldprice').val();
            var silverPrice = $('#silverprice').val();
            if (product == 'gold') {
                finalAmount = goldPrice * quantity;
                $('#price').val(finalAmount);
                $('#showprice').val(finalAmount);
            } else if (product == 'silver') {
                finalAmount = silverPrice * quantity;
                $('#price').val(finalAmount);
                $('#showprice').val(finalAmount);
            }
        });

        // contact
        function contact() {
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var query = $('#query').val();

            if (name && email && phone && query) {
                $.ajax({
                    url: 'server.php?contact=1',
                    type: 'post',
                    data: $('#contact').serialize(),
                    success: function(response) {
                        if (response == 'success') {
                            $('#name').val('');
                            $('#phone').val('');
                            $('#email').val('');
                            $('#query').val('');

                            alert('Thank for using our support system, we will geet back to you asap !');
                        } else {
                            alert(response);
                        }
                    }
                });
            } else {
                alert('Please fill all details !');
            }
        }
    </script>
</body>

</html>