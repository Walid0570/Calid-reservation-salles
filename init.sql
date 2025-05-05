-- Création de la base
DROP DATABASE IF EXISTS reservation_salles;
CREATE DATABASE reservation_salles;
USE reservation_salles;

-- Table : salle
CREATE TABLE salle (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       nom VARCHAR(100) NOT NULL,
                       capacite INT NOT NULL,
                       equipements TEXT,
                       disponible BOOLEAN DEFAULT TRUE
);

-- Table : reservations
CREATE TABLE reservations (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              salle_id INT NOT NULL,
                              nom_utilisateur VARCHAR(100) NOT NULL,
                              email_utilisateur VARCHAR(150) NOT NULL,
                              date_reservation DATE NOT NULL,
                              heure_debut TIME NOT NULL,
                              heure_fin TIME NOT NULL,
                              motif TEXT,
                              materiel TEXT,
                              FOREIGN KEY (salle_id) REFERENCES salle(id) ON DELETE CASCADE
);

-- Données de test
INSERT INTO salle (nom, capacite, equipements) VALUES
                                                   ('Salle Alpha', 10, 'TV, Tableau blanc'),
                                                   ('Salle Beta', 20, 'Projecteur, Prise HDMI');

INSERT INTO reservations (
    salle_id, nom_utilisateur, email_utilisateur, date_reservation, heure_debut, heure_fin, motif, materiel
) VALUES (
             1, 'Karim B', 'karim@example.com', '2025-05-03', '14:00', '16:00', 'Réunion commerciale', 'Projecteur'
         );
