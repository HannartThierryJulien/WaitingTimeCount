<?php

require_once('tarif.php');
require_once('actionsDBTarif.php');

if (isset($_GET['idTarifASupprimer'])) {
    $actionsDBTarif = new ActionsDBTarif();
    $actionsDBTarif->deleteTarif($_GET['idTarifASupprimer']);
    header('Location: afficherTarifs.php');
} else if (!empty($_GET['idTarifASupprimer'])) {
    echo "L'id du tarif à supprimer n'est pas valide.";
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Afficher tarifs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
    <script>
        function confirmSuppression(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce tarif ?")) {
                window.location.href = "afficherTarifs.php?idTarifASupprimer=" + id;
            }
        }
    </script>
</head>

<body>
    <header>
        <?php
        include '../config/navBar.php';
        ?>
    </header>

    <main class="container mt-5">
        <div class="row">
            <?php
            require_once('tarif.php');
            require_once('actionsDBTarif.php');

            $actionsDBTarif = new ActionsDBTarif();
            $tarifs = $actionsDBTarif->getTarifs();

            // Code pour récupérer les clients depuis le tableau d'objets
            foreach ($tarifs as $tarif) {
                ?>
                <div class="col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $tarif->getNom(); ?>
                            </h5>
                            <p class="card-text">
                                <strong>Id :</strong>
                                <?php echo $tarif->getId(); ?><br>
                                <strong>Montant par heure :</strong>
                                <?php echo $tarif->getMontantParHeure() . "€/h"; ?><br>
                                <strong>Description :</strong>
                                <?php echo $tarif->getDescription(); ?>
                            </p>
                            <button type="button" class="btn"
                                onclick="confirmSuppression(<?php echo $tarif->getId(); ?>)">Supprimer</button>
                            <a href="modifierTarif.php?id=<?php echo $tarif->getId(); ?>"
                                class="btn">Modifier</a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

</body>

</html>