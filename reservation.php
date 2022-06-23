<?php
session_start();
$zmienna = "";
$conn = mysqli_connect("localhost", "root", "", 'kino');
if ($conn->connect_errno) die("zesrales sie");
if (isset($_POST['sit'])) {

    for ($i = 0; $i < count($_POST['sit']); $i++) {
        $user_id = intval($_SESSION['user_id']);
        $hair = intval($_POST['sit'][$i]);
        $seans_id = intval($_POST['seansID']);



        $prep = mysqli_prepare($conn, "INSERT INTO rez(id_seans, id_user, id_chair) VALUES(?,?,?)");
        mysqli_stmt_bind_param($prep, "iii", $seans_id, $user_id, $hair);
        mysqli_stmt_execute($prep);
    }
    header("Location: ./main.php");
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

        .chosen {
            position: absolute;
            height: 75px;
            width: 100%;
            top: 0%;
            left: 0%;
            border: darkmagenta solid 5px;
            text-align: center;

            background-color: darkviolet
        }

        .seans {
            font-size: 50px
        }

        .sel {
            font-size: 35px
        }

        .accept {
            font-size: 35px
        }

        .chairs {
            position: absolute;
            height: calc(100%-125px);
            width: 1125px;
            top: calc(0% + 100px);
            left: 20%;
            border: darkmagenta solid 5px;
            text-align: center;

            background-color: darkviolet
        }

        .screen {
            position: relative;
            font-size: 30px;
            height: 50px;
            width: 100px;
            left: 45%
        }

        .chairrow {
            display: flex;
            flex-direction: row;


        }

        .chairrow input {
            width: 50px;
            height: 50px;


        }

        .sub {
            font-size: 30px;
        }

        /* .dis {
            background-color: darkmagenta
        } */

        /* input[type="checkbox"]:disabled+label::before {
            background-color: darkmagenta;
        } */
    </style>
</head>

<body>
    <form method="POST" class="chosen">

        <label class='seans'>
            seans: <select name="seans" class="sel">
                <?php
                $sel = mysqli_query($conn, "SELECT seans.id, seans.day, seans.hour, movies.film FROM seans INNER JOIN movies ON seans.id_film=movies.id");
                $tab = mysqli_fetch_all($sel, MYSQLI_ASSOC);
                foreach ($tab as $e) {
                    $id = $e['id'];
                    $film = $e['film'];
                    $day = $e['day'];
                    $time = $e['hour'];
                    if (isset($_POST['seans']) && $_POST['seans'] == $id) {

                        echo "<option value='$id' selected='selected'>$film - $day - $time</option>";
                    } else {
                        echo "<option value='$id'>$film - $day - $time</option>";
                    }
                }

                ?>
            </select>

        </label>

        <input type="submit" value="wybierz" class="accept">
    </form>
    <form method="POST" class="chairs">
        <div class="screen">Screen</div>
        <?php
        if (isset($_POST["seans"])) {

            $seansID = intval($_POST["seans"]);

            $sel = mysqli_query($conn, "SELECT * FROM chairs ");
            $chairs = mysqli_fetch_all($sel, MYSQLI_ASSOC);

            $sel = mysqli_query($conn, "SELECT * FROM rez WHERE id_seans=$seansID ");
            $reservs = mysqli_fetch_all($sel, MYSQLI_ASSOC);

            $lastrow = '';
            for ($i = 0; $i < count($chairs); $i++) {
                if ($lastrow != $chairs[$i]['x']) {
                    if ($i != 0) {
                        echo "</div>";
                    }
                    echo "<div class='chairrow'>";
                    $lastrow = $chairs[$i]['x'];
                }
                $chair_id = $chairs[$i]['id'];
                $toDis = false;
                foreach ($reservs as $e) {
                    if ($e['id_chair'] == $chair_id) {
                        $toDis = true;
                        break;
                    }
                }
                if ($toDis) {
                    echo "<input type='checkbox' value='$chair_id' class='dis' name='sit[]' disabled />";
                } else {
                    echo "<input type='checkbox' value='$chair_id' class='dis' name='sit[]'/>";
                }
            }
            echo "</div>";
            echo "<input type='hidden' name='seansID' value='$seansID'/>";
        }
        ?>
        <?php
        if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {

        ?><input type="submit" value="zatwierdz" class="sub" /><?php
                                                            }
                                                                ?>
    </form>

</body>

</html>