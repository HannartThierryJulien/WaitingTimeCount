<?php

require_once('facture.php');
require_once('actionsDBFacture.php');

if (array_key_exists('ajouterFacture', $_POST)) {

    $factureToAdd = new Facture();
    if (isset($_POST['payee'])) {
        $payee = 1;
    } else {
        $payee = 0;
    }

    $factureToAdd->setAttributesForInsert($_POST["idClient"], $_POST["idsPrestations"], $payee, $_POST["tva"]);

    $actionsDBFacture = new ActionsDBFacture();
    $actionsDBFacture->addFacture($factureToAdd);

    header("Location: afficherFactures.php");
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ajouter une facture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!--Javascript JQuerry-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
    <!-- Javascript Custom-->
    <script>
        function loadPrestations(clientId) {
            // Envoie une requête AJAX pour récupérer les prestations du client sélectionné
            $.ajax({
                url: 'createPrestationsColumnsForTable.php',
                type: 'POST',
                data: { clientId: clientId },
                success: function (response) {
                    // Met à jour le tableau avec les données récupérées
                    $("#tablePrestations tbody").html(response);
                },
                error: function () {
                    alert("Une erreur est survenue lors de la récupération des prestations.");
                }
            });
        }

        $(document).ready(function () {
            const idsPrestationsInput = document.getElementById("idsPrestations");

            idsPrestationsInput.addEventListener("blur", () => {
                const idsPrestations = idsPrestationsInput.value.trim();

                if (!idsPrestations.match(/^(\d+(, ?\d+)*)?$/)) {
                    alert("Veuillez entrer une liste d'entiers séparés par des virgules (ex: 2, 5, 8)");
                    idsPrestationsInput.value = "";
                }
            });
        }); // Ajout de la parenthèse fermante ici


    </script>
</head>

<body>
    <header>
        <?php include '../config/navBar.php'; ?>
    </header>

    <main class="container py-5">
        <h1 class="mb-5">Ajouter une facture</h1>

        <form method="post" class="mb-5">
            <div class="mb-3">
                <label for="clientsList" class="form-label">Client :</label>
                <select class="form-select" id="clientsList" name="idClient" onchange="loadPrestations(this.value)"
                    required>
                    <option disabled selected value>Sélectionner un client</option>
                    <?php
                    require_once('../client/client.php');
                    require_once('../client/actionsDBClient.php');

                    $actionsDBClient = new ActionsDBClient();
                    $clients = $actionsDBClient->getClients();

                    foreach ($clients as $client) {
                        ?>
                        <option value="<?php echo $client->getId(); ?>"><?php echo $client->getNom() . " " . $client->getPrenom(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="idsPrestations" class="form-label">Ids prestations :</label>
                <input type="text" class="form-control" id="idsPrestations" name="idsPrestations" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="payee" name="payee">
                <label class="form-check-label" for="payee">Payée ?</label>
            </div>

            <div class="mb-3">
                <label for="tva" class="form-label">TVA :</label>
                <input type="number" class="form-control" id="tva" name="tva" min="1" required>
            </div>

            <button type="submit" name="ajouterFacture" class="btn">Ajouter</button>
        </form>

        <div id="tablePrestations" class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Client</th>
                        <th scope="col">Nom tarif</th>
                        <th scope="col">Montant tarif</th>
                        <th scope="col">Durée</th>
                        <th scope="col">Facturée</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>


</html>

<html>