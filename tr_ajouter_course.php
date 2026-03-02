<?php
include 'connexion.php';

if (isset($_POST['submit'])) {
    $point_depart = mysqli_real_escape_string($connexion, trim($_POST['point_depart']));
    $point_arrivee = mysqli_real_escape_string($connexion, trim($_POST['point_arrivee']));
    $date_heure = mysqli_real_escape_string($connexion, $_POST['date_heure']);

    $chemin = null;

    if (isset($_FILES['image_vehicule']) && $_FILES['image_vehicule']['error'] == 0) {
        $image_vehicule = $_FILES['image_vehicule']['name'];
        $extention = explode(".", $image_vehicule);
        $vraiExtension = strtolower(end($extention));
        $tablExt = ['jpg','jpeg','png','gif'];

        if (in_array($vraiExtension, $tablExt)) {
            if (!is_dir('image')) mkdir('image', 0755, true);
            $nomFichier = date("Y-m-d_H-i-s") . "_" . rand(1000,9999);
            $vraiNomFichier = $nomFichier . "." . $vraiExtension;
            $chemin = "image/" . $vraiNomFichier;
            move_uploaded_file($_FILES['image_vehicule']['tmp_name'], $chemin);
        }
    }

    if (!empty($point_depart) && !empty($point_arrivee) && !empty($date_heure)) {
        $requete = "INSERT INTO courses (point_depart, point_arrivee, date_heure, statut, image_vehicule)
                    VALUES ('$point_depart', '$point_arrivee', '$date_heure', 'en attente', '$chemin')";
        $execution = mysqli_query($connexion, $requete);

        if ($execution) header("location: ajouter_course.php?success=1");
        else header("location: ajouter_course.php?error=1");
    } else {
        header("location: ajouter_course.php?error=1");
    }
} else {
    header("location: ajouter_course.php");
}
?>