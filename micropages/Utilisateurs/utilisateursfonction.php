
<?php

//fonction pour ajouter un utilisateur
function inserer_utilisateur($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from utilisateur where loginuser='" . $reg["1"]['login'] . "' and passuser='" . sha1($reg["1"]['pass1']) . "'") or die(mysqli_error($con));
        $row = mysqli_num_rows($req);
        if ($row == 0) {
            $nomP = addslashes($reg["1"]['nom']);
            $prenomP = addslashes($reg["1"]['prenom']);
            $log = NULL;
            if ($reg["1"]['photo'] != NULL) {

// on va vérifier que la nouvelle utilisateur n'existe pas déja
                if (!is_dir("microupload/profil/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("microupload/profil/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                    if (is_dir("microupload/profil/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photo']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photo']['name']));

                        $log = $reg["1"]['photo']['name'];
                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                        $pagp = 'micropages/utilisateurs/ajouter_utilisateur/ajout_utilisateur';
                        die('<meta http-equiv="refresh" content="6 ; URL=' . $url  . '?page=' . base64_encode($pagp) . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre utilisateur </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['photo']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photo']['name']));

                    $log = $reg["1"]['photo']['name'];
                }
            } else {
                if ($reg["1"]['genre'] == "Monsieur") {
                    $log = "masculin.png";
                } else {
                    $log = "feminin.png";
                }
            }

            $con->query("insert into utilisateur(nomuser, prenomuser,emailuser, genreuser, roleuser, cniuser,teluser, "
                            . "loginuser, passuser,photouser,dateAjoutuser ) values( '$nomP', "
                            . "'$prenomP', '" . $reg["1"]['email'] . "', '" . $reg["1"]['genre'] . "', '" . addslashes($reg["1"]['role']) . "', '" . $reg["1"]['cni'] . "', '" . $reg["1"]['tel'] . "', "
                            . "'" . $reg["1"]['login'] . "','" . sha1($reg["1"]['pass1']) . "', '" . $log . "', NOW())") or die(mysqli_error($con));

            unset($_SESSION['formutilisateur']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'micropages/Utilisateurs/lister_utilisateur';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'micropages/Utilisateurs/ajouter_utilisateur/ajout_utilisateur';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les utilisateurs
function lister_utilisateur($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from utilisateur ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td>
                <img class="img-rounded" style="width: 50px;" src="microupload/profil/<?php print nl2br(htmlspecialchars($recuser["photouser"])); ?>"> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomuser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenomuser"])) ?></td>          
            <td><?php print nl2br(htmlspecialchars($recuser["emailuser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["genreuser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["teluser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["cniuser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["roleuser"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["loginuser"])) ?></td>
            <td>
                <?php
                if (($recuser["roleuser"] != "administrateur")) {
                    if ($_SESSION["iduser"] != $recuser["iduser"]) {
                        if ($recuser["etatuser"]) {
                            ?>
                            <a href='<?= $url; ?>?page=<?php echo base64_encode('micropages/Utilisateurs/utilisateur_ajax'); ?>&idutilisateur=<?php echo $recuser["iduser"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cet Utilisateur ?'));">
                                <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a href="<?= $url; ?>?page=<?php echo base64_encode('micropages/Utilisateurs/utilisateur_ajax'); ?>&idutilisateur=<?php echo $recuser["iduser"]; ?>&activer=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cet Utilisateur ?'));">
                                <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                            </a>
                            <?php
                        }
                    } else {
                        if ($recuser["etatuser"]) {
                            ?>
                            <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                            <?php
                        } else {
                            ?>
                            <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                            <?php
                        }
                    }
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateAjoutuser"])) ?></td>
            <td>
                <?php
                if (($recuser["roleuser"] != "administrateur")) {
                    ?>
                    <a href="<?= $url; ?>?page=<?php echo base64_encode('micropages/Utilisateurs/editer_utilisateur/edit_utilisateur'); ?>&idutilisateur=<?php echo $recuser["iduser"]; ?>" >
                        <span title="Modifier cette utilisateur" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    &nbsp;&nbsp;
                    <a href='<?= $url; ?>?page=<?php echo base64_encode('micropages/Utilisateurs/utilisateur_ajax'); ?>&idutilisateur=<?php echo $recuser["iduser"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette utilisateur ?'));" >
                        <span title="Supprimer cette utilisateur " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_utilisateur($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from utilisateur where loginuser='" . $reg["1"]['logine'] . "' and passuser='" . sha1($reg["1"]['pass1e']) . "'") or die(mysqli_error($con));
        $row = mysqli_num_rows($req);
        $nomP = addslashes($reg["1"]['nome']);
        $prenomP = addslashes($reg["1"]['prenome']);
        $pa = NULL;
        if ($reg["1"]['pass1e'] != NULL) {
            $pa = sha1($reg["1"]['pass1e']);
        }
        if ($row == 0) {
            $log = NULL;
            if ($reg["1"]['photoe'] != NULL) {

// on va vérifier que la nouvelle utilisateur n'existe pas déja
                if (!is_dir("microupload/profil/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("microupload/profil/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                    if (is_dir("microupload/profil/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                        $log = $reg["1"]['photoe']['name'];
                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                        $pagp = 'micropages/utilisateur/editer_utilisateur/edit_utilisateur';
                        die('<meta http-equiv="refresh" content="6 ; URL=' . indexadmin . php . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre utilisateur </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                    $log = $reg["1"]['photoe']['name'];
                }
            }

            if ($log != NULL) {
                if ($pa != NULL) {
                    $con->query("update utilisateur set  nomuser='$nomP', "
                                    . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . "teluser='" . $reg["1"]['tele'] . "' , loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                } else {
                    $con->query("update utilisateur set  nomuser='$nomP', "
                                    . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . "teluser='" . $reg["1"]['tele'] . "' , loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                }
            } else {
                if ($pa != NULL) {
                    $con->query("update utilisateur set  nomuser='$nomP', "
                                    . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . "teluser='" . $reg["1"]['tele'] . "' , loginuser='" . $reg["1"]['logine'] . "', motdepasseuser='" . $pa . "' "
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                } else {
                    $con->query("update utilisateur set  nomuser='$nomP', "
                                    . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . "teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "' "
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                }
            }

            unset($_SESSION['formutilisateure']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'micropages/Utilisateurs/lister_utilisateur';
            die('<meta http-equiv="refresh" content="3 ; URL=' .  $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["iduser"] == $reg["1"]["idutilisateur"]) {
                $log = NULL;
                if ($reg["1"]['photoe'] != NULL) {

// on va vérifier que la nouvelle utilisateur n'existe pas déja
                    if (!is_dir("microupload/profil/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                        @mkdir("smicroupload/profil/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                        if (is_dir("microupload/profil/")) {
// On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                            $log = $reg["1"]['photoe']['name'];
                        } else {
                            echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'micropages/Utilisateurs/editer_utilisateur/edit_utilisateur';
                            die('<meta http-equiv="refresh" content="6 ; URL=' .  $url . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre utilisateur </br> Veuillez contacter votre administrateur</p>";
                        }
                    } else {

// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                        $log = $reg["1"]['photoe']['name'];
                    }
                }

                if ($log != NULL) {
                    if ($pa != NULL) {
                        $con->query("update utilisateur set  nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                        . "teluser='" . $reg["1"]['tele'] . "' , loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    } else {
                        $con->query("update utilisateur set  nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                        . "teluser='" . $reg["1"]['tele'] . "' , loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    }
                } else {
                    if ($pa != NULL) {
                        $con->query("update utilisateur set  nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                        . "teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "' "
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    } else {
                        $con->query("update utilisateur set  nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "', genreuser='" . $reg["1"]['genree'] . "', roleuser='" . addslashes($reg["1"]['rolee']) . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                        . "teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "' "
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    }
                }

                unset($_SESSION['formutilisateure']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'micropages/Utilisateurs/lister_utilisateur';
                die('<meta http-equiv="refresh" content="3 ; URL=' .  $url. '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'micropages/Utilisateurs/editer_utilisateur/edit_utilisateur';
                die('<meta http-equiv="refresh" content="3 ; URL=' .  $url . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
            }
        }
    }
}

function update_utilisateur_profil($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from utilisateur where loginuser='" . $reg["1"]['logine'] . "' and passuser='" . sha1($reg["1"]['pass1e']) . "'") or die(mysqli_error($con));
        $row = mysqli_num_rows($req);
        $nomP = addslashes($reg["1"]['nome']);
        $prenomP = addslashes($reg["1"]['prenome']);
        $pa = NULL;
        if ($reg["1"]['pass1e'] != NULL) {
            $pa = sha1($reg["1"]['pass1e']);
        }
        if ($row == 0) {
            $log = NULL;
            if ($reg["1"]['photoe'] != NULL) {

// on va vérifier que la nouvelle utilisateur n'existe pas déja
                if (!is_dir("microupload/profil/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                    @mkdir("microupload/profil/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                    if (is_dir("microupload/profil/")) {
// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                        $log = $reg["1"]['photoe']['name'];
                    } else {
                        echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                        $pagp = 'micropages/Utilisateurs/editer_profil/edit_profilutilisateur';
                        die('<meta http-equiv="refresh" content="6 ; URL=' .  $url . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre utilisateur </br> Veuillez contacter votre administrateur</p>";
                    }
                } else {

// On peut valider le fichier et le stocker définitivement
                    move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                    $log = $reg["1"]['photoe']['name'];
                }
            }

            if ($log != NULL) {
                if ($pa != NULL) {
                    $con->query("update utilisateur set nomuser='$nomP', prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . " teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));

                    $_SESSION["nomuser"] = $nomP;
                    $_SESSION["prenomuser"] = $prenomP;
                    $_SESSION["emailuser"] = $reg["1"]['emaile'];
                    $_SESSION["teluser"] = $reg["1"]['tele'];
                    $_SESSION["loginuser"] = $reg["1"]['logine'];
                    $_SESSION["passworduser"] = $pa;
                    $_SESSION["photouser"] = $log;
                } else {
                    $con->query("update utilisateur set nomuser='$nomP', prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . " teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));

                    $_SESSION["nomuser"] = $nomP;
                    $_SESSION["prenomuser"] = $prenomP;
                    $_SESSION["emailuser"] = $reg["1"]['emaile'];
                    $_SESSION["teluser"] = $reg["1"]['tele'];
                    $_SESSION["loginuser"] = $reg["1"]['logine'];
                    $_SESSION["photouser"] = $log;
                }
            } else {
                if ($pa != NULL) {
                    $con->query("update utilisateur set nomuser='$nomP', prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . " teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "',passuser='" . $pa . "' "
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));

                    $_SESSION["nomuser"] = $nomP;
                    $_SESSION["prenomuser"] = $prenomP;
                    $_SESSION["emailuser"] = $reg["1"]['emaile'];
                    $_SESSION["teluser"] = $reg["1"]['tele'];
                    $_SESSION["loginuser"] = $reg["1"]['logine'];
                    $_SESSION["passworduser"] = $pa;
                } else {
                    $con->query("update utilisateur set nomuser='$nomP', prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                    . " teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "' "
                                    . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));

                    $_SESSION["nomuser"] = $nomP;
                    $_SESSION["prenomuser"] = $prenomP;
                    $_SESSION["emailuser"] = $reg["1"]['emaile'];
                    $_SESSION["teluser"] = $reg["1"]['tele'];
                    $_SESSION["loginuser"] = $reg["1"]['logine'];
                }
            }

            unset($_SESSION['formutilisateurep']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'micropages/Utilisateurs/infouser';
            die('<meta http-equiv="refresh" content="3 ; URL=' .  $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["iduser"] == $reg["1"]["idutilisateur"]) {
                $log = NULL;
                if ($reg["1"]['photoe'] != NULL) {

// on va vérifier que la nouvelle utilisateur n'existe pas déja
                    if (!is_dir("microupload/profil/")) {
// puis on créer les 1 dossier, qui contiendra les originaux 
// avec tous les droits ( écriture, lecture , suppression )
                        @mkdir("microupload/profil/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                        if (is_dir("microupload/profil/")) {
// On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                            $log = $reg["1"]['photoe']['name'];
                        } else {
                            echo "<script language='javascript'>$('div.creationdoc').show('slow').delay(8000).hide('slow');</script>";
                            $pagp = 'micropages/Utilisateurs/editer_profil/edit_profilutilisateur';
                            die('<meta http-equiv="refresh" content="6 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
//                        echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre utilisateur </br> Veuillez contacter votre administrateur</p>";
                        }
                    } else {

// On peut valider le fichier et le stocker définitivement
                        move_uploaded_file($reg["1"]['photoe']['tmp_name'], "microupload/profil/" . basename($reg["1"]['photoe']['name']));

                        $log = $reg["1"]['photoe']['name'];
                    }
                }

                if ($log != NULL) {
                    if ($pa != NULL) {
                        $con->query("update utilisateur set nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', "
                                        . " teluser='" . $reg["1"]['tele'] . "', loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "', photouser='" . $log . "'"
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    } else {
                        $con->query("update utilisateur set nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', teluser='" . $reg["1"]['tele'] . "', "
                                        . "loginuser='" . $reg["1"]['logine'] . "', photouser='" . $log . "'"
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    }
                } else {
                    if ($pa != NULL) {
                        $con->query("update utilisateur set nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', teluser='" . $reg["1"]['tele'] . "', "
                                        . "loginuser='" . $reg["1"]['logine'] . "', passuser='" . $pa . "' "
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    } else {
                        $con->query("update utilisateur set nomuser='$nomP', "
                                        . "prenomuser='$prenomP', emailuser='" . $reg["1"]['emaile'] . "',genreuser='" . $reg["1"]['genree'] . "', cniuser='" . $reg["1"]['cnie'] . "', teluser='" . $reg["1"]['tele'] . "', "
                                        . "loginuser='" . $reg["1"]['logine'] . "' "
                                        . " where iduser='" . $reg["1"]['idutilisateur'] . "'") or die(mysqli_error($con));
                    }
                }

                unset($_SESSION['formutilisateurep']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'micropages/Utilisateurs/infouser';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page= $pagp ">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'micropages/Utilisateurs/editer_profil/edit_profilutilisateur';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idutilisateur=' . $reg["1"]["idutilisateur"] . '">');
            }
        }
    }
}
