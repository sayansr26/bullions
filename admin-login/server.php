<?php

include('include/config.php');

if (isset($_GET['auth'])) {
    $auth = $_GET['auth'];

    // check auth type

    if ($auth == 'setup') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $md5Password = md5($password);

        try {
            $insert = "INSERT INTO admin_users(name, email, phone, password, date) 
            VALUES('$name', '$email', '$phone', '$md5Password', now())";
            $connection->exec($insert);
            $aid = $connection->lastInsertId();
            try {
                $insert = "INSERT INTO admin_setup(configured, date) VALUES('YES', now())";
                $connection->exec($insert);
                setcookie('aid', $aid, time() + 3600);
                echo "success";
            } catch (PDOException $e) {
                echo "Faield : " . $e->getMessage();
            }
            // setcookie('aid', $aid, time() + 3600);
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($auth == 'login') {
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $md5Password = md5($password);

        $query = "SELECT * FROM admin_users WHERE phone = :phone";
        $statement = $connection->prepare($query);
        $statement->execute(
            array(
                'phone' => $phone
            )
        );
        $rowCount = $statement->rowCount();

        if ($rowCount > 0) {
            $result = $statement->fetchAll();
            foreach ($result as $row) {
                if ($row['password'] == $md5Password) {
                    $aid = $row['id'];

                    setcookie('aid', $aid, time() + 3600);
                    echo "success";
                } else {
                    echo "invalid password !";
                }
            }
        } else {
            echo "Inavlid phone";
        }
    }
} elseif (isset($_GET['update'])) {
    $update = $_GET['update'];

    // check update process

    if ($update == 'price') {
        $price = $_POST['price'];
        $product = $_POST['product'];

        try {
            $update = "UPDATE product_rate SET price = '$price' WHERE product = '$product'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } elseif ($update = 'charge') {
        $rate = $_POST['rate'];

        try {
            $update = "UPDATE charges SET rate = '$rate' WHERE id = '1'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
} elseif (isset($_GET['withdraw'])) {
    $withdraw = $_GET['withdraw'];

    // get type 

    if ($withdraw == '1') {
        $id = $_POST['id'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];
        $status = 'success';


        try {
            $update = "UPDATE withdrawls SET status = '$status' WHERE id = '$id'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    } else {
        $id = $_POST['id'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];
        $status = $_POST['status'];


        try {
            $update = "UPDATE withdrawls SET status = '$status' WHERE id = '$id'";
            $connection->exec($update);
            echo "success";
        } catch (PDOException $e) {
            echo "Faield : " . $e->getMessage();
        }
    }
}
