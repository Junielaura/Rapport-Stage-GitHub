<?php
if (isset($_SESSION['formutilisateurep']) && $_SESSION['formutilisateurep'] != NULL) {
    update_utilisateur_profil($_SESSION['formutilisateurep'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>                                                                                                                                                                                                                                                                        