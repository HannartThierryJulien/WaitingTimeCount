<?php

require_once('client.php');
require_once('actionsDBClient.php');

if (array_key_exists('ajouterClient', $_POST)) {

    $clientToAdd = new Client();
    $clientToAdd->setAttributesForInsert($_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["telephone"], $_POST["adresse"], $_POST["description"]);

    $actionsDBClient = new ActionsDBClient();
    $actionsDBClient->addClient($clientToAdd);

    header("Location: afficherClients.php");
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ajouter un client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Framework Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php
        include '../config/navBar.php';
        ?>
    </header>

    <main class="container">
        <h1 class="my-5">Ajouter un client</h1>
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>

            <div class="mb-3">
                <label for="mail" class="form-label">Mail :</label>
                <input type="email" class="form-control" id="mail" name="mail" required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone :</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" required>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse :</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" name="ajouterClient" class="btn">Ajouter</button>
            </div>
        </form>
    </main>

</body>


</html>