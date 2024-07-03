
function deconnexion() {
    var gtk = confirm("Vous serez d\351connect\351 apr\350s confirmation !!!");
    if (gtk == true) {
        window.open("index.php?locks", "_self", false);
    } else {
        alert('D\351connexion annul\351e');
    }
}
