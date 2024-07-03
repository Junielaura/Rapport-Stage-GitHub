<?php
session_start();
ob_start();
?>
<!DOCTYPE html>


<html>
    <head>
        <meta charset="UTF-8">
        <title>MICROFINANCE</title>
        <link rel="stylesheet" type="text/css" href="bootstrap-3.0.0/dist/css/bootstrap.css">
        <link href="microcss/login.css" rel="stylesheet" type="text/css">
        <style>
            body{
                font-family: Book Antiqua !important;
                padding-top: 40px;


            }
        </style>
    </head>
    <?php
    include('microconnexion/connexion.php');
    if (isset($_GET["locks"])) {
        //session_unregister("login");
        session_unset();
        session_destroy();
        header("Location:./");
        exit();
    }
    ?>
    <body>
        <?php
        if (isset($_POST['con'])) {
            $loginv = addslashes($_POST["loginv"]);
            $passv = sha1(addslashes($_POST["passwordv"]));
            $re = $con->query("select * from utilisateur as u where u.loginuser='" . $loginv . "' and u.passuser='" . $passv . "'") or die(mysqli_error($con));
            $req = mysqli_num_rows($re);
            if ($req == 0) {
                echo"<script language='javascript'>alert('Information non valide')</script>";
            } else {


                $r = mysqli_fetch_assoc($re);
                $_SESSION["iduser"] = $r["iduser"];
                $_SESSION["nomuser"] = $r["nomuser"];
                $_SESSION["prenomuser"] = $r["prenomuser"];
                $_SESSION["emailuser"] = $r["emailuser"];
                $_SESSION["genreuser"] = $r["genreuser"];
                $_SESSION["roleuser"] = $r["roleuser"];
                $_SESSION["cniuser"] = $r["cniuser"];
                $_SESSION["etatuser"] = $r["etatuser"];
                $_SESSION["dateAjoutuser"] = $r["dateAjoutuser"];
                $_SESSION["loginuser"] = $r["loginuser"];
                $_SESSION["passworduser"] = $r["passuser"];
                $_SESSION["teluser"] = $r["teluser"];
                $_SESSION["photouser"] = $r["photouser"];


//                if (isset($_SESSION["etatuser"]) && ($_SESSION["loginuser"])) {

                if (($_SESSION["roleuser"] == "administrateur") && ($_SESSION["etatuser"]) == 1) {

                    header("Location:indexadmin.php");
                } else {
                    echo"<script language='javascript'>alert('Utilisateur inactive !!')</script>";
                }
            }
        }

//        if (isset($_SESSION['loginuser']) && isset($_SESSION['passworduser']) && ($_SESSION["etatuser"])) {
//            if ($_SESSION["roleuser"] == "Administrateur") {
//                header("Location:indexadmin.php");
//            } else {
//                header("Location:indexuser.php");
//            }
//        }
        ?>
        <div class="container">

            <form method="post" action="#" class="form-signin">
                <h2 class="form-signin-heading">PAGE CONNEXION</h2>
                <input type="text" class="form-control" required="" name="loginv" placeholder="identifiant" autofocus><br>
                <input type="password" class="form-control" required="" name="passwordv" placeholder="mot de passe"><br>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="con">connexion</button>
            </form>

        </div> <!-- /container -->

    </body>
</html>
<?php
ob_end_flush();
?>
