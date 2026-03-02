<?php
include 'connexion.php';

if (isset($_POST['submit'])) {
    $course_id = (int)$_POST['course_id'];
    $chauffeur_id = (int)$_POST['chauffeur_id'];

    if ($course_id > 0 && $chauffeur_id > 0) {
        // Mise à jour de la course
        $requete = "UPDATE courses 
                    SET chauffeur_id = $chauffeur_id, statut = 'en cours'
                    WHERE course_id = $course_id AND statut = 'en attente'";
        $execution = mysqli_query($connexion, $requete);

        // Mettre le chauffeur comme indisponible
        $req_chauff = "UPDATE chauffeurs SET disponible = 0 WHERE chauffeur_id = $chauffeur_id";
        mysqli_query($connexion, $req_chauff);

        if ($execution && mysqli_affected_rows($connexion) > 0) {
            header("location: affecter_chauffeur.php?success=1");
        } else {
            header("location: affecter_chauffeur.php?error=1");
        }
    } else {
        header("location: affecter_chauffeur.php?error=1");
    }
}
?>