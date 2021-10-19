<?php

// TODO - Sessionhandling starten
session_start();
// Datenbankverbindung
include('include/dbconnector.inc.php');

// Initialisierung
$error = $message =  '';
$titel = $inhalt=  '';

// Wurden Daten mit "POST" gesendet?
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Titel ausgefüllt?
    if (isset($_POST['titel'])) {
        //trim and sanitize
        $titel = htmlspecialchars(trim($_POST['titel']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($titel) || strlen($titel) > 30) {
            $error .= "Geben Sie bitte einen korrekten Titel ein.(maximal 30 Zeichen)<br />";
        }
    } else {
        $error .= "Geben Sie bitte einen Titel ein.<br />";
    }

    // Inhalt ausgefüllt?
    if (isset($_POST['inhalt'])) {
        //trim and sanitize
        $inhalt = htmlspecialchars(trim($_POST['inhalt']));

        //mindestens 1 Zeichen und maximal 30 Zeichen lang
        if (empty($inhalt) || strlen($inhalt) > 255) {
            $error .= "Geben Sie bitte einen korrekten Inhalt ein. (maximal 255 Zeichen)<br />";
        }
    } else {
        $error .= "Geben Sie bitte einen Witz ein.<br />";
    }

    // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank
    if (empty($error)) {
        // Query erstellen
        $query = "Insert into tbl_witze (titel,inhalt,benutzerId) values (?,?,?)";

        // Query vorbereiten
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $mysqli->error . '<br />';
        }

        // Parameter an Query binden
        if (!$stmt->bind_param('ssi', $titel, $inhalt, $_SESSION['userid'])) {
            $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
        }

        // Query ausführen
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $mysqli->error . '<br />';
        }

        // kein Fehler!
        if (empty($error)) {
            $message .= "Der Witz wurde erfolgreich hochgeladen!<br/ >";
            // Felder leeren und Weiterleitung auf anderes Script: z.B. Login!
            $titel = $inhalt=  '';
            // Weiterleiten auf login.php
            header('Location: meineWitze.php');
            // beenden des Scriptes
            exit();
        }
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
    <h1>Witz erstellen</h1>
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
        <button type="submit" name="button" value="submit" class="btn btn-info">Erstellen</button>
        <button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>