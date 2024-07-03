<?php
session_start();
ob_start();
include('microconnexion/connexion.php');
include('./microincludes/fonctionglobale.php');

include './microincludes/get_url.php';
//include 'microsms/envoyersmsbon.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title> micro</title>
        <link rel="stylesheet" type="text/css" href="style1.css">
        <link rel="stylesheet" href="microcss/bootstrap.min.css">
        <link rel="stylesheet" href="microcss/styleupload.css">
        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="micross/font-awesome.min.css">
         <!-- owl.carousel CSS
                    ============================================ -->
         <link rel="stylesheet" href="microcss/owl.carousel.css">
         <link rel="stylesheet" href="microcss/owl.theme.css">
         <link rel="stylesheet" href="microcss/oowl.transitions.css">
        <!-- animate CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/animate.css">
        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/normalize.css">
        <!-- meanmenu icon CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/meanmenu.min.css">
        <!-- main CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/main.css">
        <!-- morrisjs CSS
             ============================================ -->
        <link rel="stylesheet" href="microcss/morrisjs/morris.css">
        <!-- mCustomScrollbar CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- metisMenu CSS
                    ============================================ -->
        <link rel="stylesheet" href="microcss/metisMenu/metisMenu.min.css">
        <link rel="stylesheet" href="microcss/metisMenu/metisMenu-vertical.css">
        <!-- educate icon CSS
                  ============================================ -->
        <link rel="stylesheet" href="microcss/educate-custon-icon.css">
        <!-- calendar CSS
                   ============================================ -->
        <link rel="stylesheet" href="microcss/calendar/fullcalendar.min.css">
        <link rel="stylesheet" href="microcss/calendar/fullcalendar.print.min.css">
        <!-- normalize CSS
                   ============================================ -->
        <link rel="stylesheet" href="microcss/data-table/bootstrap-table.css">
        <link rel="stylesheet" href="microcss/data-table/bootstrap-editable.css">
        <!-- style CSS ============================================ -->

        <link rel="stylesheet" href="microcss/responsive.css">
        <link rel="stylesheet" href="style1.css">
        <!--Pour previsualiser les images du dossier-->
        <script src="sotcocogjs/jquery.imagebox.js"></script>
        <!-- jquery
                   ============================================ -->
        <script src="microjs/vendor/jquery-1.12.4.min.js"></script>
        <!-- modernizr JS
                   ============================================ -->
        <script src="microjs/vendor/modernizr-2.8.3.min.js"></script>
        <!-- validation des formulaires -->
        <link href="microplugin/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
        <link type="text/css" rel="stylesheet" href="microcss/bootstrap-fileupload.min.css"/><!--pour la confirmation des fichier et images-->
        <!--Pour previsualiser les images du dossier-->
        <script src="microjs/jquery.imagebox.js"></script>
         <!-- les dates -->
         <link rel="stylesheet" href="microplugin/datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!--<link rel="stylesheet" href="plugin/datetimepicker/css/bootstrap-combined.min.css">-->

        

        <script src="microeditor/ckeditor.js"></script>
        <script src="microckfinder/ckfinder.js"></script>
        <style>
            body{
                font-family: Book Antiqua !important;
            }
            thead th{
                white-space: nowrap;
            }
            .panel-heading{
                padding: 1px;
            }
        </style>
        
        <style>
            th{
                text-transform: uppercase;
                text-align: center;
            }
        </style>
    </head>



    </head>
    <?php
    if (!($_SESSION["loginuser"]) || !($_SESSION["passworduser"]) || (!$_SESSION["etatuser"]) || ($_SESSION["roleuser"] != "administrateur")) {
        header("location:index.php");
    }
    ?>
    <body>
        <?php include('./microincludes/navbar.php'); ?>
        <div class="container-fluid" style="padding-top: 50px; margin-left: 0px;"  >
            <?php
            include './micropages/Utilisateurs/utilisateursfonction.php';
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="javascript:history.go(-1)" class="btn btn-sm pull-left btn-primary" >
                                <i class="glyphicon glyphicon-backward"></i> Pr&eacute;cedant</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="products">
                            <?php include './microincludes/alertjs.php'; ?>
                            <?php
                            if (isset($_REQUEST["page"])) {
                                $page = base64_decode($_REQUEST["page"]) . ".php";
                                if (file_exists($page)) {
                                    include ($page);
                                } else {
                                    echo 'Page nom disponible sur le serveur';
                                }
                            } else {
                                include './microincludes/accueil.php';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->

        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p><span style="text-align: center"> © 2024, tous droits réservés.</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="microjs/bootstrap.min.js"></script>
        <!-- validation des formulaires -->
        <script src="microplugin/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
        <script src="microplugin/bootstrapvalidator/js/language/fr_FR.js"></script>
        <script src="microjs/bootstrap-fileupload.js"></script>
         <!-- wow JS
                    ============================================ -->
         <script src="microjs/wow.min.js"></script>
        <!-- price-slider JS
                    ============================================ -->
        <script src="microjs/jquery-price-slider.js"></script>
         <!-- owl.carousel JS
                    ============================================ -->
         <script src="microjs/owl.carousel.min.js"></script>
        <!-- data table JS
                   ============================================ -->
        <script src="microjs/data-table/bootstrap-table.js"></script>
        <script src="microjs/data-table/tableExport.js"></script>
        <script src="microjs/data-table/data-table-active.js"></script>
        <script src="microjs/data-table/bootstrap-table-editable.js"></script>
        <script src="microjs/data-table/bootstrap-editable.js"></script>
        <script src="microjs/data-table/bootstrap-table-resizable.js"></script>
        <script src="microjs/data-table/colResizable-1.5.source.js"></script>
        <script src="microjs/data-table/bootstrap-table-export.js"></script>
        <!-- sticky JS
                    ============================================ -->
        <script src="microjs/jquery.sticky.js"></script>
        <!-- scrollUp JS
                    ============================================ -->
        <script src="microjs/jquery.scrollUp.min.js"></script>
          <!-- counterup JS
                    ============================================ -->
          <script src="microjs/counterup/jquery.counterup.min.js"></script>
          <script src="microjs/counterup/waypoints.min.js"></script>
          <script src="microjs/counterup/counterup-active.js"></script>
           <!-- morrisjs JS
                    ============================================ -->
           <script src="microjs/morrisjs/raphael-min.js"></script>
           <script src="microjs/morrisjs/morris.js"></script>
           <script src="microjs/morrisjs/morris-active.js"></script>
        <!-- morrisjs JS
                    ============================================ -->
        <script src="microjs/sparkline/jquery.sparkline.min.js"></script>
        <script src="microjs/sparkline/jquery.charts-sparkline.js"></script>
        <script src="microjs/sparkline/sparkline-active.js"></script>
        <!-- calendar JS
                   ============================================ -->
        <script src="microjs/calendar/moment.min.js"></script>
        <script src="microjs/calendar/fullcalendar.min.js"></script>
        <script src="microjs/calendar/fullcalendar-active.js"></script>
        <!-- plugins JS
                    ============================================ -->
        <script src="microjs/plugins.js"></script>
        <!-- main JS
                   ============================================ -->
        <script src="microjs/main.js"></script>

    <!--<script src = "microjs/jquery.js"></script>
    <script src="microjs/bootstrap.min.js"></script>
    <script src="microjs/holder.js"></script>-->
        <!-- mCustomScrollbar JS
                  ============================================ -->
        <script src="microjs/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="microjs/scrollbar/mCustomScrollbar-active.js"></script>
         <!-- metisMenu JS
                    ============================================ -->
         <script src="microjs/metisMenu/metisMenu.min.js"></script>
         <script src="microjs/metisMenu/metisMenu-active.js"></script>
        <!-- les dates -->
        <script src="microplugin/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="microplugin/datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
        <script src="microplugin/moment/moment.min.js"></script>

        <script src="microjs/scriptajax.js"></script>
    </body>
</html>

<!-- bootstrap JS
            ============================================ -->

<?php
ob_end_flush();
?>
