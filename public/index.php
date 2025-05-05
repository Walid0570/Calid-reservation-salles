<?php
require_once 'Reservation.php';

$reservation = new Reservation();
$message = "";

$salles = [];
$reservations = [];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $salle_id = isset($_POST['salle_id']) ? $_POST['salle_id'] : '';
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $date = isset($_POST['date_reservation']) ? $_POST['date_reservation'] : '';
        $heure_debut = isset($_POST['heure_debut']) ? $_POST['heure_debut'] : '';
        $heure_fin = isset($_POST['heure_fin']) ? $_POST['heure_fin'] : '';
        $motif = isset($_POST['motif']) ? $_POST['motif'] : '';

        $reservation->ajouterReservation($salle_id, $nom, $email, $date, $heure_debut, $heure_fin, $motif);
        header("Location: index.php");
        exit;
    }

    if (isset($_GET['delete'])) {
        $reservation->supprimerReservation((int) $_GET['delete']);
        header("Location: index.php?message=suppression");
        exit;
    }

    if (isset($_GET['filtre_date']) && !empty($_GET['filtre_date'])) {
        $reservations = $reservation->getReservationsByDate($_GET['filtre_date']);
    } else {
        $reservations = $reservation->getAllReservations();
    }

    $salles = $reservation->getSalles();
} catch (Exception $e) {
    $message = $e->getMessage();
    $reservations = $reservation->getAllReservations();
    $salles = $reservation->getSalles();
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation de salles</title>
    <link rel="stylesheet" href="./style.css?v=1">
</head>
<body>

<h1 class="logo"><span class="underline">C</span>alid</h1>
<h4>Entreprise contre les cyber-attaques !</h4>

<?php if (!empty($message)): ?>
    <p style="color:red; font-weight: bold;">✅ <?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<h2>Réserver une salle</h2>
<form method="POST">
    <label for="salle_id">Salle :</label>
    <select name="salle_id" required>
        <option value="">-- Choisir une salle --</option>
        <?php foreach ($salles as $salle): ?>
            <option value="<?= $salle['id'] ?>"><?= htmlspecialchars($salle['nom']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="nom">Nom :</label>
    <input type="text" name="nom" required>

    <label for="email">Email :</label>
    <input type="email" name="email" required>

    <label for="date_reservation">Date :</label>
    <input type="date" name="date_reservation" required>

    <label for="heure_debut">Heure début :</label>
    <input type="time" name="heure_debut" required>

    <label for="heure_fin">Heure fin :</label>
    <input type="time" name="heure_fin" required>

    <label for="motif">Motif :</label>
    <textarea name="motif" rows="2"></textarea>

    <input type="submit" value="Ajouter">
</form>

<form method="GET">
    <label for="filtre_date">Filtrer par date :</label>
    <input type="date" name="filtre_date" value="<?php echo isset($_GET['filtre_date']) ? htmlspecialchars($_GET['filtre_date']) : ''; ?>">
    <input type="submit" value="Filtrer">
</form>

<h2>Liste des réservations</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Salle</th>
        <th>Date</th>
        <th>Heure début</th>
        <th>Heure fin</th>
        <th>Motif</th>
        <th>Action</th>
    </tr>
    <?php foreach ($reservations as $res): ?>
        <tr>
            <td><?= $res['id'] ?></td>
            <td><?= htmlspecialchars($res['nom_utilisateur']) ?></td>
            <td><?= htmlspecialchars($res['email_utilisateur']) ?></td>
            <td><?= htmlspecialchars($res['salle_nom']) ?></td>
            <td><?= htmlspecialchars($res['date_reservation']) ?></td>
            <td><?= htmlspecialchars($res['heure_debut']) ?></td>
            <td><?= htmlspecialchars($res['heure_fin']) ?></td>
            <td><?= htmlspecialchars($res['motif']) ?></td>
            <td><a href="?delete=<?= $res['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
