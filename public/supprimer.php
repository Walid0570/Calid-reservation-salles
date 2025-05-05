<?php
require_once __DIR__ . '/Reservation.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $reservation = new Reservation();
    $resultat = $reservation->supprimerReservation($id);

    if ($resultat) {
        header('Location: index.php?message=Suppression réussie');
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID non spécifié.";
}
?>
