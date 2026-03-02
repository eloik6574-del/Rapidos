<?php
include 'connexion.php';

if (isset($_POST['submit'])) {
    $course_id = (int)$_POST['course_id'];

    if ($course_id > 0) {
        // Récupérer le chauffeur affecté pour le libérer
        $res = mysqli_query($connexion, "SELECT chauffeur_id FROM courses WHERE course_id = $course_id");
        $course = mysqli_fetch_assoc($res);
        $chauffeur_id = $course['chauffeur_id'];

        // Mise à jour du statut à terminée
        $requete = "UPDATE courses SET statut = 'terminée' WHERE course_id = $course_id AND statut = 'en cours'";
        $execution = mysqli_query($connexion, $requete);

        // Rendre le chauffeur disponible
        if ($chauffeur_id) {
            mysqli_query($connexion, "UPDATE chauffeurs SET disponible = 1 WHERE chauffeur_id = $chauffeur_id");
        }

        if ($execution && mysqli_affected_rows($connexion) > 0) {
            header("location: terminer_course.php?success=1");
        } else {
            header("location: terminer_course.php?error=1");
        }
    } else {
        header("location: terminer_course.php?error=1");
    }
} else {
    header("location: terminer_course.php");
}
?>