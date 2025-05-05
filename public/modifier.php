<?php
require_once __DIR__ . '/Reservation.php';

$reservation = new Reservation();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $reservation->getReservationById($id);

    if (!$res) {
        echo "Réservation introuvable.";
        exit();
    }
} else {
    echo "ID manquant.";
    exit();
}

// Si formulaire envoyé
if (isset($_POST['nom']) && isset($_POST['date_reservation'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $date = $_POST['date_reservation'];

    $resultat = $reservation->modifierReservation($id, $nom, $date);

    if ($resultat) {
        header('Location: index.php?message=Modification réussie');
        exit();
    } else {
        echo "Erreur lors de la modification.";
    }
}
?>

<!-- Formulaire HTML pour modifier -->
<h1>Modifier une réservation</h1>
<form method="POST">
    <input type="text" name="nom" value="<?= htmlspecialchars($res['nom']) ?>" required><br><br>
    <input type="date" name="date_reservation" value="<?= htmlspecialchars($res['date_reservation']) ?>" required><br><br>
    <button type="submit">Modifier</button>
</form>
