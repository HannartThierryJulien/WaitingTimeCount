<?php

require_once('client.php');
require_once('actionsDBClient.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $actionsDBClient = new ActionsDBClient();
    $client = $actionsDBClient->getClientById($id);
}

if (isset($_POST['submit'])) {

    $newClient = new Client();
    $newClient->setAllAttributes($_POST["id"], $_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["telephone"], $_POST["adresse"], $_POST["description"]);

    $actionsDBClient = new ActionsDBClient();
    $actionsDBClient->updateClient($newClient);

    header("Location: afficherClients.php");
    exit;
}

?>

<!-- ------------------------------------------------------------------- -->
<!-- ------------------------------------------------------------------- -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modifier un client</title>
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

    <main class="container my-5">
        <h1 class="mb-4">Modifier un client</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $client->getId(); ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php echo $client->getNom(); ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo $client->getPrenom(); ?>"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Mail :</label>
                <input type="text" id="mail" name="mail" value="<?php echo $client->getMail(); ?>" class="form-control">
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo $client->getTelephone(); ?>"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse :</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo $client->getAdresse(); ?>"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea id="description" name="description"
                    class="form-control"><?php echo $client->getDescription(); ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn">Enregistrer les modifications</button>
            </div>
        </form>
    </main>

</body>

</html>