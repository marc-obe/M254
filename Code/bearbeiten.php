<?php

session_start();

// Datenbankverbindung
include('include/dbconnector.inc.php');

// Initialisierung
$error = $message =  '';
$titel = $inhalt=  '';

// ID des Datensatzes übergeben?
if (isset($_GET['id']) and is_numeric($_GET['id'])) {

// ID User / Asset als Int speichern
$id = intval($_GET['id']);

$query = "SELECT titel, inhalt from tbl_witze where id = ?";

// Query vorbereiten
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    $error .= 'prepare() failed ' . $mysqli->error . '<br />';
}
// Parameter an Query binden
if (!$stmt->bind_param("i", $id)) {
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
}
// Query ausführen
if (!$stmt->execute()) {
    $error .= 'execute() failed ' . $mysqli->error . '<br />';
}
// Daten auslesen
$result = $stmt->get_result();

// Userdaten lesen
if($row = $result->fetch_assoc()) {
    $titel = $row['titel'];
    $inhalt = $row['inhalt'];
}






// User ID als Int speichern
$user_id = intval($_SESSION['userid']);

// kein Fehler vorhanden?
if (empty($error)) {
    // Query vorbereiten
    $query = "UPDATE tbl_witze SET titel = ?, inhalt = ? WHERE id = ? and benutzerId = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    // Parameter an Query binden
    if (!$stmt->bind_param("ssii", $titel, $inhalt, $id, $user_id)) {
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';

}// Query ausführen
    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    header('Location: /meineWitze.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projektarbeit</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Projektarbeit</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php

            // TODO - wenn Session personalisiert
            if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
                echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="meineWitze.php">meine Witze</a></li>';
            }else {
                header('Location: /index.php');
            }
            ?>
        </ul>
    </div>
</nav>
<div class="container">
    <h1>Witz bearbeiten</h1>
    <?php
    // Ausgabe der Fehlermeldungen
    if (!empty($error)) {
        echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
    } else if (!empty($message)) {
        echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
    }
    ?>
    <form action="" method="post">
        <!-- titel -->
        <div class="form-group">
            <label for="titel">Titel *</label>
            <input type="text" name="titel" class="form-control" id="titel" value="<?php echo $titel ?>" placeholder="Geben Sie den Titel an." maxlength="30" required="true">
        </div>
        <!-- Inhalt -->
        <div class="form-group">
            <label for="inhalt">Inhalt *</label>
            <input type="text" name="inhalt" class="form-control" id="inhalt" value="<?php echo $inhalt ?>" placeholder="Geben Sie den Witz ein" maxlength="255" required="true">
        </div>

        <!-- Send / Reset -->
        <button type="submit" name="button" value="submit" class="btn btn-info">Ändern</button>
        <button type="reset" name="button" value="reset" class="btn btn-warning">Reset</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
