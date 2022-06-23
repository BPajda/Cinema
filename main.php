<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>php_sad</title>
    <style>
        body {
            background-color: darkslategrey
        }

        #header {
            position: absolute;
            top: 0%;
            left: 0%;
            height: 30%;
            width: 100%;
            background-color: darkviolet;
        }

        #title {
            position: absolute;
            top: 20%;
            left: 30%;
            font-size: 80px;
            color: whitesmoke
        }

        .link {
            font-size: 50px;
            color: whitesmoke
        }

        .link:visited {
            color: whitesmoke;
        }

        #reg {
            position: absolute;
            top: 5%;
            left: 90%;
        }

        #login {
            position: absolute;
            top: 5%;
            left: 80%;
        }

        #logout {
            position: absolute;
            top: 5%;
            left: 90%;
        }

        #res {
            position: absolute;
            top: 5%;
            left: 40%;
        }

        #filmadd {
            position: absolute;
            top: 5%;
            left: 5%;
        }

        #seans {
            position: absolute;
            top: 5%;
            left: 20%;
        }
    </style>
</head>

<body>
    <div id="header">
        <h1 id="title">KINO DOMINO</h1>
        <?php

        if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
            if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
        ?>
                <a href="filmAdd.php" id="filmadd" class="link">Add Film</a>
                <a href="createSens.php" id="seans" class="link">Create Seans</a>

            <?php
            }

            ?>
            <a href="reservation.php" id="res" class="link">reservation</a>
            <a href="logout.php" id="logout" class="link">logout</a>
        <?php

        } else {
        ?>
            <a href="reservation.php" id="res" class="link">reservation</a>
            <a href="register.php" id="reg" class="link">register</a>
            <a href="login.php" id="login" class="link">login</a>
        <?php
        }


        ?>
    </div>


</body>

</html>