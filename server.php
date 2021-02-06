<?php

include('./include/config.php');


if (isset($_GET['auth'])) {
    $auth = $_GET['auth'];

    if ($auth == 'login') {
        $type = $_GET['type'];
        if ($type == '1') {
            // otp login function will be here
            // echo "Login with OTP";
            $phone = $_POST['phone'];

            $query = "SELECT * FROM user_data WHERE phone = :phone";
            $statement = $connection->prepare($query);
            $statement->execute(
                array(
                    'phone' => $phone
                )
            );
            $rowCount = $statement->rowCount();
            if ($rowCount > 0) {
                // echo 'ok';
                $token = rand(100000, 999999);
                // $token = '123456';
                $otpProtected = md5($token);
                $field = array(
                    "sender_id" => "FSTSMS",
                    "language" => "english",
                    "route" => "qt",
                    "numbers" => $phone,
                    "message" => "43538",
                    "variables" => "{#BB#}",
                    "variables_values" => $token
                );
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($field),
                    CURLOPT_HTTPHEADER => array(
                        "authorization: YzovdVO34G9anBwrJ5I6pPUEF8ciLgetjRKblyD2MXCq71SfQuSXRKxdzOTgfM6rUaGbBJ5wQ3F0HYNv",
                        "cache-control: no-cache",
                        "accept: */*",
                        "content-type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    try {
                        $insert = "INSERT INTO otp_tokens(otp, phone, date) VALUE('$otpProtected','$phone', now())";
                        $connection->exec($insert);
                        echo "success";
                    } catch (PDOException $e) {
                        echo "Faield : " . $e->getMessage();
                    }
                }
            } else {
                echo 'User not found, please Sign Up !';
            }
        } else {
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $mdPassword = md5($password);

            if ($phone == '') {
                echo 'empty_phone';
            } elseif ($password == '') {
                echo 'empty_password';
            } else {
                $query = "SELECT * FROM user_data WHERE phone = :phone AND password = :password";
                $statement = $connection->prepare($query);
                $statement->execute(
                    array(
                        'phone' => $phone,
                        'password' => $mdPassword
                    )
                );
                $rowCount = $statement->rowCount();
                if ($rowCount > 0) {
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        setcookie('uid', $row['id'], time() + 3600);
                        echo "success";
                    }
                } else {
                    echo "invalid credientals";
                }
            }
        }
    } else if ($auth == 'register') {
        // register function here
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $cPassword = $_POST['cpassword'];
        $mdPassword = md5($cPassword);

        if ($name == '') {
            echo 'empty_name';
        } elseif ($email == '') {
            echo 'empty_email';
        } elseif ($phone == '') {
            echo 'empty_phone';
        } elseif ($password == '') {
            echo 'empty_password';
        } elseif ($cPassword == '') {
            echo 'empty_c_password';
        } elseif ($password != $cPassword) {
            echo 'password_error';
        } else {
            $query = "SELECT * FROM user_data WHERE phone = :phone";
            $statement = $connection->prepare($query);
            $statement->execute(
                array(
                    'phone' => $phone
                )
            );
            $rowCount = $statement->rowCount();
            if ($rowCount > 0) {
                echo 'user_already_exist';
            } else {
                try {
                    $insert = "INSERT INTO user_data(name, email, phone, wallet_balance, withdrawl_balance, gold_balance, silver_balance, password, date) VALUES('$name', '$email', '$phone', '0', '0', '0', '0', '$mdPassword', now())";
                    $connection->exec($insert);
                    $uid = $connection->lastInsertId();
                    setcookie('uid', $uid, time() + 3600);
                    echo 'success';
                } catch (PDOException $e) {
                    echo 'Failed : ' . $e->getMessage();
                }
            }
        }
    } elseif ($auth == 'verify') {
        $otp = $_POST['otp'];
        $otpProtected = md5($otp);
        $query = "SELECT * FROM otp_tokens WHERE otp = :otp AND used = :used";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'otp' => $otpProtected,
                'used' => 'NO'
            )
        );
        $rowCount = $statement->rowCount();
        if ($rowCount > 0) {
            // echo "success";
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                $phone = $row['phone'];
                $userQuery = "SELECT * FROM user_data WHERE phone = :phone";
                $statement = $connection->prepare($userQuery);
                $statement->execute(
                    array(
                        'phone' => $phone
                    )
                );
                $rowCount = $statement->rowCount();
                if ($rowCount > 0) {
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        $uid = $row['id'];
                        // setcookie('uid', $row['id'], time() + 3600);
                        try {
                            $update = "UPDATE otp_tokens SET used = 'YES' WHERE otp  = '$otpProtected'";
                            $connection->exec($update);
                            setcookie('uid', $row['id'], time() + 3600);
                            echo "success";
                        } catch (PDOException $e) {
                            echo "Faield : " . $e->getMessage();
                        }
                    }
                }
            }
        } else {
            echo "Inavlid OTP";
        }
    }
} elseif (isset($_GET['buy'])) {
    $buy = $_GET['buy'];
    if ($buy == 'gold') {
        // echo 'gold buy';
        $phone = $_POST['phone'];
        $asset = $_POST['product'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $balance = $_POST['balance'];
        $goldbalance = $_POST['gold'];
        $silverbalance = $_POST['silver'];

        echo "payment?phone=$phone&asset=$asset&quantity=$quantity&price=$price&balance=$balance&gold=$goldbalance&silver=$silverbalance";
    } else {
        echo 'silver buy';
    }
} elseif ($_GET['payment']) {
    $payment = $_GET['payment'];

    if ($payment == 'gold') {
        // echo 'Gold Purchas Success full';
        $user = $_POST['user'];
        $balance = $_POST['balance'];
        $goldbalance = $_POST['gold'];
        $silverbalance = $_POST['silver'];
        $quantity = $_POST['quantity'];
        $asset = $_POST['asset'];
        $amount = $_POST['amount'];
        $total = $_POST['total'];
        $payId = $_POST['pay_id'];
        $orderId = $_POST['order_id'];

        $newgold  = $goldbalance + $quantity;
        $newsilver = $silverbalance + $quantity;

        try {
            $insert = "INSERT INTO transections(user, asset, amount, total, pay_id, order_id, type , date) 
            VALUES('$user', '$asset', '$amount', '$total', '$payId', '$orderId', 'buy', now())";
            $connection->exec($insert);
            if ($asset == 'gold') {
                try {
                    $update = "UPDATE user_data SET gold_balance = '$newgold' WHERE phone = '$user'";
                    $connection->exec($update);
                    echo "success?user=$user&asset=$asset&total=$total&orderid=$orderId";
                } catch (PDOException $e) {
                    echo "Faield : " . $e->getMessage();
                }
            } else {
                try {
                    $update = "UPDATE user_data SET silver_balance = '$newsilver' WHERE phone = '$user'";
                    $connection->exec($update);
                    echo "success?user=$user&asset=$asset&total=$total&orderid=$orderId";
                } catch (PDOException $e) {
                    echo "Faield : " . $e->getMessage();
                }
            }
            // echo "success?user=$user&asset=$asset&total=$total&orderid=$orderId";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['withdraw'])) {
    $user = $_POST['user'];
    $balance = $_POST['balance'];
    $amount = $_POST['amount'];

    if ($balance > $amount) {
        $newBalance = $balance - $amount;
    } else {
        $newBalance = '0';
    }
    $transectionId = rand(10, 99);
    $transectionIdProtect = sha1($transectionId);

    $accountQuery = "SELECT * FROM accounts WHERE phone = :phone";
    $statement = $connection->prepare($accountQuery);
    $statement->execute(
        array(
            'phone' => $user
        )
    );

    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $account = $row['account'];
        $ifsc = $row['ifsc'];
        $banificary = $row['banificary'];
    }


    if ($amount > $balance) {
        echo 'You dont have enough balance';
    } else {
        try {
            $insert = "INSERT INTO transections(user, asset, amount, total, pay_id, order_id, type, date) 
            VALUES('$user', 'wallet', '$amount' , '$amount', '$transectionIdProtect', '$transectionIdProtect', 'withdraw', now())";
            $connection->exec($insert);
            try {
                $update = "UPDATE user_data SET withdrawl_balance = '$newBalance' WHERE phone  = '$user'";
                $connection->exec($update);
                // echo 'success';
                try {
                    $insert = "INSERT INTO withdrawls(user, account, ifsc, banificary, amount, date) 
                    VALUES('$user', '$account', '$ifsc', '$banificary', '$amount', now())";
                    $connection->exec($insert);
                    echo "success";
                } catch (PDOException $e) {
                    echo "Faield : " . $e->getMessage();
                }
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['update'])) {
    $update = $_GET['update'];
    if ($update == 'kyc') {
        // echo 'kyc edit response';
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $district = $_POST['district'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $pancard = $_POST['pancard'];
        $idcard = $_POST['idcard'];

        try {
            $update = "UPDATE user_data SET address = '$address' , district = '$district', city = '$city', state = '$state', pancard = '$pancard', idcard = '$idcard', profile_status = 'verified' WHERE phone = '$phone' ";
            $connection->exec($update);
            echo 'success';
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($update == 'profile') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        try {
            $update = "UPDATE user_data SET name = '$name', email = '$email' WHERE phone = '$phone'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($update == 'account') {
        $phone = $_POST['phone'];
        $account = $_POST['account'];
        $banificary = $_POST['banificary'];
        $ifsc = $_POST['ifsc'];

        try {
            $insert = "INSERT INTO accounts(phone, account, ifsc, banificary, date) 
            VALUES('$phone', '$account', '$ifsc', '$banificary', now())";
            $connection->exec($insert);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['sell'])) {
    // echo "sell";
    $goldprice = $_POST['goldprice'];
    $silverprice = $_POST['silverprice'];
    $phone = $_POST['phone'];
    $gold = $_POST['gold'];
    $silver = $_POST['silver'];
    $sproduct = $_POST['sproduct'];
    $squantity = $_POST['squantity'];
    $sprice = $_POST['sprice'];

    echo "confirm?goldprice=$goldprice&silverprice=$silverprice&phone=$phone&gold=$gold&silver=$silver&product=$sproduct&quantity=$squantity&price=$sprice";
} elseif (isset($_GET['trade'])) {
    // echo "trade";
    $user = $_POST['user'];
    $quantity = $_POST['quantity'];
    $asset = $_POST['asset'];
    $amount = $_POST['amount'];
    $charge = $_POST['charge'];
    $total = $_POST['total'];
    $gold = $_POST['gold'];
    $silver = $_POST['silver'];
    $balance = $_POST['balance'];

    $newbalance = $balance + $total;

    try {
        $insert = "INSERT INTO transections(user, asset, amount, total, pay_id, order_id, type , date) 
            VALUES('$user', '$asset', '$amount', '$total', 'none', 'none', 'sell', now())";
        $connection->exec($insert);
        if ($asset == 'gold') {
            try {
                $update = "UPDATE user_data SET gold_balance = '0', withdrawl_balance = '$newbalance' WHERE phone = '$user'";
                $connection->exec($update);
                echo "success?user=$user&asset=$asset&total=$total&orderid=$orderId";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        } else {
            try {
                $update = "UPDATE user_data SET silver_balance = '0', withdrawl_balance = '$newbalance' WHERE phone = '$user'";
                $connection->exec($update);
                echo "success?user=$user&asset=$asset&total=$total&orderid=$orderId";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
        }
    } catch (PDOException $e) {
        echo "Faield : " . $e->getMessage();
    }
} elseif (isset($_GET['contact'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $query = $_POST['query'];

    try {
        $insert = "INSERT INTO contacts(name, email, phone, query, date) 
        VALUES('$name', '$email', '$phone', '$query', now())";
        $connection->exec($insert);
        echo "success";
    } catch (PDOException $e) {
        echo "Faield : " . $e->getMessage();
    }
}
