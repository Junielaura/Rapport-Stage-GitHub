<?php
if (isset($_SESSION['formutilisateur']) && $_SESSION['formutilisateur'] != NULL) {
    inserer_utilisateur($_SESSION['formutilisateur'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>