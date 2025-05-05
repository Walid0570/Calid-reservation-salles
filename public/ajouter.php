<?php
// public/ajouter.php

require_once 'database.php';
require_once 'Reservation.php';

// D'abord, on crée une instance de Database
$db = new Database();
$pdo = $db->pdo; // On récupère la propriété pdo

// Ensuite, on crée une instance de Reservation
$reservation = new Reservation($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $date_reservation = $_POST['date_reservation'];

    if ($reservation->ajouterReservation($nom, $date_reservation)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Erreur lors de l'ajout de la réservation.";
    }
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $date = isset($_POST['date_reservation']) ? $_POST['date_reservation'] : '';

    if (!empty($nom) && !empty($date)) {
        $ajout = $reservation->ajouterReservation($nom, $date);
        if ($ajout) {
            header("Location: index.php?success=1");
            exit;
        } else {
            $message = "⚠️ Une réservation pour '$nom' à la date '$date' existe déjà.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une réservation</title>
</head>
<body>
<h1>Ajouter une réservation</h1>

<form action="ajouter.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br><br>

    <label for="date_reservation">Date de réservation :</label>
    <input type="date" name="date_reservation" id="date_reservation" required><br><br>

    <button type="submit">Ajouter</button>
</form>

<br>
<a href="index.php">Retour à la liste</a>
</body>
</html>
