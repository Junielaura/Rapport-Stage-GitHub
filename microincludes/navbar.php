

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap-3.0.0/dist/css/bootstrap.css">
</head>
<body>
    <div class="container-fluid well"><!--debut entete -->

        <!-- <div class=" row"> -->
        <div class="col-md-1 col-lg-1 col-sm-2 col-xs-2">
            <?php
            if (($_SESSION["roleuser"] == "administrateur")) {
                ?><br>
                <?php
            }
            ?>

        </div>
        <!-- Fixed navbar -->
        <!-- <div class="navbar navbar-inverse navbar-fixed-top">-->
        <!--<div class="container">-->
        <nav class="navbar navbar-dark bg-primary " >
            <style>
                .laura{
                    background-color:#4169E1;
                    color: black; /* Couleur du texte */
                }
            </style>
            <!-- Navbar content -->
            <!-- <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                 </button>
                                         </div>-->
            <div class="navbar-collapse collapse laura">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a href="indexadmin.php"  class="nav-link area" style="padding-left: 5px; padding-right: 5px; color: white" >Accueil</a></li>
                    <?php
                    if (($_SESSION["roleuser"] == "administrateur")) {
                        ?>
                        <li class="nav-item"><a href="indexadmin.php?page=<?php echo base64_encode('micropages/Utilisateurs/lister_utilisateur'); ?>" class="nav-link area" style="padding-left: 5px; padding-right: 5px; color: white">Utilisateurs</a>
                        </li>
                        <?php
                    } else {
                        
                    }
                    ?>

                    <div class="header-right-info pull-right">
                        <ul class="nav navbar-nav mai-top-nav header-right-menu">
                            <li class="dropdown">
                            <li class="nav-item" style="margin-left: 900px">
                                <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <span class="admin-name"><img src="microupload/profil/<?php echo $_SESSION["photouser"]; ?>" alt="" /></span><span class="admin-name" style="color:white"><?php echo $_SESSION["nomuser"]; ?></span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                   <!-- <span class="admin-name"><img src="microupload/profil/<?php echo $_SESSION["photouser"]; ?>" alt="" /></span> -->
                                    <li><a href="indexadmin.php?page=<?php echo base64_encode('micropages/Utilisateurs/infouser'); ?>" ><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Mon profil</a></li>
                                </ul>
                                <ul
                                    <li><a href="javascript:deconnexion();"><span class="edu-icon edu-author-log-ic"style="color: white" >D&eacute;connexion</span></a>
                                    </li>
                                </ul>
                            </li>                         
                        </ul>
                    </div>

                </ul>
            </div><!--/.nav-collapse -->
        </nav>
    </div>
    

