<?php
session_start();
$zmienna = "";
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
    header("Location: ./main.php");
} else {


    if (isset($_POST["log"], $_POST["pas"])) {

        $conn = mysqli_connect("localhost", "root", "", 'kino');
        if ($conn->connect_errno) die("zesrales sie");
        $log = $_POST["log"];
        $pas = $_POST["pas"];

        if (mb_strlen($log, "UTF-8") > 2 && mb_strlen($pas, "UTF-8") > 2) {
            $check = mysqli_query($conn, "SELECT * FROM users WHERE login='$log'");
            $odp = mysqli_fetch_all($check, MYSQLI_ASSOC);
            if (count($odp) == 0) {

                $zmienna = "taki użyszkodnik nie istnieje";
            } else {
                $logged = false;
                foreach ($odp as $e) {
                    if (md5($pas) == $e["password"]) {
                        $logged = true;
                        $_SESSION["logged"] = true;
                        $_SESSION["user_id"] = $e["id"];
                        $_SESSION["admin"] = $e["admin"];
                    }
                    break;
                }
                if ($logged == true) {
                    $zmienna = "zalogowano";
                    header("Location: ./main.php");
                } else {
                    $zmienna = "błędne hasło";
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            background-color: darkslategrey;
            color: whitesmoke
        }

        form {
            position: absolute;
            top: 10%;
            left: 20%;
            height: 600px;
            width: 800px;
            border: darkmagenta solid 5px;
            text-align: center;
            font-size: 50px;
            background-color: darkviolet
        }

        .inp {
            font-size: 50px
        }

        #accept {
            font-size: 50px
        }
    </style>
</head>

<body>
    <form method="POST">
        <h1>LOGOWANIE</h1>
        <label>
            login: <input type="text" name="log" class="inp">
        </label>
        <br>
        <br>
        <label>
            hasło: <input type="password" name="pas" class="inp">
        </label>
        <br>
        <br>
        <input type="submit" value="login" id="accept">
    </form>
    <?php echo $zmienna; ?>

</body>

</html>