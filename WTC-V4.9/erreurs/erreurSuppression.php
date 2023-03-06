<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Erreur suppression</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS et Javascript Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- CSS Custom-->
    <link href="../config/global.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <?php
    include '../config/navBar.php';
    ?>

    <!-- Contenu principal -->
    <main class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-danger">
                    <div class="card-header bg-danger text-white">
                        <h1 class="card-title mb-0">Erreur suppression</h1>
                    </div>
                    <div class="card-body">
                        <h2 class="card-text">Pour pouvoir supprimer cet élément, vous devez d'abord supprimer tous les
                            autres éléments avec qui il est lié.</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>