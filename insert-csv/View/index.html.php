<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">UploadFile</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div style="z-index: 1080" aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-absolute top-0 end-0 p-3">
            <div id="toast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Insertion du fichier réussie !
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <h1>Test technique GAC</h1>
    </div>
    <div class="container mt-3 p-5 card">
        <form id="insertForm" action="/" method="post" class="form-example" enctype="multipart/form-data">
            <div class="row">
                <div class="alert alert-warning" role="alert">
                    Attention, un truncate est réalisé avant l'insertion du fichier.
                </div>
                <p>
                    <em>Le fichier sera splitté (chunk) pour l'envoi par morceaux de 1Mo</em>
                </p>
            </div>
            <div class="row mt-2">
                <div class="mb-3 form-check">
                    <label for="file" class="form-label">Fichier à insérer: </label>
                    <input type="file" name="file" id="file" required accept=".csv" class="form-control">
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-primary btn-lg" name="submit" value="Insérer">Envoyer le fichier</button>
            </div>
            <div class="row">
                <div id="progress-div" class="mt-2 d-none">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Durée totale réelle des appels</div>
                    <div class="card-body">
                        <h5 class="card-title"><?=number_format($totalTimeAllCalls, 0, ".", " "); ?> heures</h5>
                        <p class="card-text">Effectués après le 15/02/2012 inclus</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Nombre total des SMS</div>
                    <div class="card-body">
                        <h5 class="card-title"><?=number_format($totalNumberSms, 0, ".", " "); ?> SMS</h5>
                        <p class="card-text">Pas de condition de date</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3 mb-5 card">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Classement</th>
                    <th scope="col">Numéro Abonné</th>
                    <th scope="col">Volume Facturé</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($topTenDataBilled)) { ?>
                <tr class="no-data">
                    <td colspan="3">Aucune donnée</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($topTenDataBilled as $key => $row) { ?>
                    <tr>
                        <td><strong><?php echo $key + 1;?></strong></td>
                        <td><?php echo $row['numero_abonne'];?></td>
                        <td><?php echo number_format($row['duree_facturee'], 0, ".", " ");?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <footer class="footer mt-auto py-3 bg-primary">
        <div class="container">
            <span class="text-white">Réalisé par Clément WOJDASZKA</span>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/js/upload.js"></script>
</body>
</html>