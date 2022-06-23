<?php
session_start();
$zmienna = "";
if (isset($_POST["film"])) {
    $zmienna = "ez szmato ";
    $conn = mysqli_connect("localhost", "root", "", 'kino');
    if ($conn->connect_errno) die("zesrales sie");
    $film = $_POST["film"];

    if (mb_strlen($film, "UTF-8") > 0) {
        $check = mysqli_query($conn, "SELECT * FROM movies WHERE film='$film'");
        $odp = mysqli_fetch_all($check, MYSQLI_ASSOC);
        if (count($odp) != 0) {

            $zmienna = "taki film już istnieje";
        } else {
            $prep = mysqli_prepare($conn, "INSERT INTO movies(film) VALUES(?)");
            @mysqli_stmt_bind_param($prep, "s", $film);
            mysqli_stmt_execute($prep);
            header("Location: ./main.php");
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
    <title>filmAdd</title>
    <style>
        body {
            background-color: darkslategrey;
            color: whitesmoke
        }

        form {
            position: absolute;
            top: 10%;
            left: 20%;
            height: 500px;
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
        <h1>ADD FILM</h1>
        <label>
            name: <input type="text" name="film" class="inp">
        </label>
        <br>
        <br>
        <input type="submit" value="dodaj" id="accept">
    </form>

</body>

</html>