<?php
include 'connexion.php';

$course_id = (int)$_GET['id'];

if ($course_id > 0) {
    $requete = "DELETE FROM courses WHERE course_id = $course_id";
    $execution = mysqli_query($connexion, $requete);

    if ($execution) {
        header("location: index.php?delete=1");
    } else {
        header("location: index.php?delete=0");
    }
} else {
    header("location: index.php");
}
?>