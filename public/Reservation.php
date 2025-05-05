<?php
require_once __DIR__ . '/database.php';

class Reservation
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->pdo;
    }

    public function ajouterReservation($salle_id, $nom, $email, $date, $heure_debut, $heure_fin, $motif)
    {
        if (empty($salle_id) || empty($nom) || empty($email) || empty($date) || empty($heure_debut) || empty($heure_fin)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // Vérifier s'il y a déjà une réservation pour cette salle à ce moment-là
        $sql = "
            SELECT COUNT(*) FROM reservations
            WHERE salle_id = ? AND date_reservation = ?
            AND (
                (heure_debut < ? AND heure_fin > ?) OR
                (heure_debut >= ? AND heure_debut < ?)
            )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$salle_id, $date, $heure_fin, $heure_debut, $heure_debut, $heure_fin]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            throw new Exception("La salle est déjà réservée à cette date et à cet horaire.");
        }

        // Insérer la réservation
        $stmt = $this->pdo->prepare("
            INSERT INTO reservations (salle_id, nom_utilisateur, email_utilisateur, date_reservation, heure_debut, heure_fin, motif)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([$salle_id, $nom, $email, $date, $heure_debut, $heure_fin, $motif]);
    }

    public function supprimerReservation($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllReservations()
    {
        $sql = "
            SELECT r.*, s.nom AS salle_nom 
            FROM reservations r
            JOIN salle s ON r.salle_id = s.id
            ORDER BY date_reservation, heure_debut
        ";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservationsByDate($date)
    {
        $sql = "
            SELECT r.*, s.nom AS salle_nom 
            FROM reservations r
            JOIN salle s ON r.salle_id = s.id
            WHERE r.date_reservation = ?
            ORDER BY r.heure_debut
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalles()
    {
        return $this->pdo->query("SELECT * FROM salle")->fetchAll(PDO::FETCH_ASSOC);
    }
}
