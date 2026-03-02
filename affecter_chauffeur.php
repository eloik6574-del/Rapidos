<?php
include "connexion.php";

// Récupérer les courses EN ATTENTE sans chauffeur
$req_courses = "SELECT course_id, point_depart, point_arrivee, date_heure
                FROM courses
                WHERE statut = 'en attente' AND chauffeur_id IS NULL
                ORDER BY date_heure ASC";
$res_courses = mysqli_query($connexion, $req_courses);

// Récupérer les chauffeurs DISPONIBLES
$req_chauffeurs = "SELECT chauffeur_id, nom, prenoms, telephone
                   FROM chauffeurs WHERE disponible = 1 ORDER BY nom ASC";
$res_chauffeurs = mysqli_query($connexion, $req_chauffeurs);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RAPIDO - Affecter un Chauffeur</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="fixed-top mb-3">
    <?php include('menu.php'); ?>
</div>

<div class="container mt-5 pt-5">
    <h4 class="pt-3 mb-3 text-primary fw-bold">Affecter un Chauffeur</h4>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Chauffeur affecté avec succès !
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            Une erreur est survenue. Veuillez réessayer.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($res_courses) > 0 && mysqli_num_rows($res_chauffeurs) > 0): ?>
        <form action="tr_affecter_chauffeur.php" method="post">
            <div class="mb-3">
                <label class="form-label fw-bold">Sélectionner la Course (en attente)</label>
                <select class="form-select" name="course_id" required>
                    <option value="">-- Choisir une course --</option>
                    <?php while ($course = mysqli_fetch_assoc($res_courses)): ?>
                        <option value="<?php echo $course['course_id']; ?>">
                            #<?php echo $course['course_id']; ?> :
                            <?php echo htmlspecialchars($course['point_depart']); ?> vers
                            <?php echo htmlspecialchars($course['point_arrivee']); ?>
                            (<?php echo $course['date_heure']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Sélectionner le Chauffeur disponible</label>
                <select class="form-select" name="chauffeur_id" required>
                    <option value="">-- Choisir un chauffeur --</option>
                    <?php while ($ch = mysqli_fetch_assoc($res_chauffeurs)): ?>
                        <option value="<?php echo $ch['chauffeur_id']; ?>">
                            <?php echo htmlspecialchars($ch['prenoms'] . " " . $ch['nom']); ?>
                            - Tel: <?php echo htmlspecialchars($ch['telephone']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Affecter le Chauffeur</button>
        </form>
    <?php elseif (mysqli_num_rows($res_courses) == 0): ?>
        <div class="alert alert-info">
            Aucune course en attente sans chauffeur.
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Aucun chauffeur disponible pour le moment.
        </div>
    <?php endif; ?>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>