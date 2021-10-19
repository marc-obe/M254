<?php

session_start();

include('include/dbconnector.inc.php');

$error = $message = '';
// ID des Datensatzes wurde übergeben?
if (isset($_GET['id']) and is_numeric($_GET['id'])) {

    // ID User / Asset als Int speichern
    $id = intval($_GET['id']);

    // Gehört dieser Beitrag dem angemeldeten Benutzer?
    $query = "delete from tbl_witze where id = ? and benutzerId = ?";

    $stmt = $mysqli->prepare($query);

    if ($stmt === false) {
        $error .= 'prepare() failed ' . $mysqli->error . '<br />';
    }

    // Parameter an query binden
    if (!$stmt->bind_param("ii", $id, $_SESSION['userid'])){
    $error .= 'bind_param() failed ' . $mysqli->error . '<br />';
    }
    // Query ausführen
    if (!$stmt->execute()) {

        $error .= 'execute() failed ' . $mysqli->error . '<br />';

    }else {

        // Anzahl betroffener Zeilen, grösser als 0?
        if ($mysqli->affected_rows) {
            $message .= 'Datensatz erfolgreich gelöscht.<br>';
        }else {
            $error .= "Kein Datensatz in der Datenbank gefunden.<br>";
        }
    }

} else {
    $error .= "Keine Parameter übergeben.<br>";
}
header('Location: /meineWitze.php');


