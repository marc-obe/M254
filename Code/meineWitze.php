<?php

// TODO - Session starten
session_start();

// Datenbankverbindung
include('include/dbconnector.inc.php');

// variablen initialisieren
$error = $message = '';

// TODO -  Wenn personalisierte Session: Begrüssen des Benutzers mit Benutzernamen
if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
    $message .= "Wilkommen ".$_SESSION['username'];
}else {
// TODO - wenn keine Personalisierte Session
    $error .= "Sie sind nicht angemeldet, melden Sie sich bitte auf der  <a href='login.php'>Login-Seite</a> an.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meine Schadensfälle</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/aa92474866.js" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">LB 3 M254</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

            <?php
            if (isset($_SESSION['loggedin']) and $_SESSION['loggedin']) {
                echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="passwort.php">Passwort ändern</a></li>';
            }else {
                header('Location: index.php');
            }
            ?>
        </ul>
    </div>
</nav>
<div class="container">
    <h1>Meine Schadensfälle</h1>
    <div>
        <a href="witzHinzufuegen.php">Schaden melden</a>
    </div>
    <?php
    $query = "SELECT id,titel, inhalt from tbl_witze where benutzerId = ?";

    // Query vorbereiten
    $stmt = $mysqli->prepare($query);

    if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }
    // Parameter an Query binden
    if (!$stmt->bind_param("i", $_SESSION['userid'])) {
        $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    // Query ausführen
    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $mysqli->error . '<br />';
    }
    // Daten auslesen
    $result = $stmt->get_result();

    // Userdaten lesen
    while($row = $result->fetch_assoc()) {
        echo '<h2>'. $row["titel"] .'</h2> <p>'.$row["inhalt"].'</p><a href="bearbeiten.php?id='.$row["id"].'">bearbeiten</a> </BLOCKQUOTE> <a href="loeschen.php?id='.$row["id"].'">löschen</a>';
    }


    ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
