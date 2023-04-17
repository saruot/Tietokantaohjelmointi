<?php
require_once './includes.php';

  $playlistId = ''; // Tähän määriteltäisiin frontendistä tai jostain muualta haettavan soittolistan ID joka haettaisiin esim $_POST['parametri'] metodilla ja määriteltäisiin muuttujaan.

  $conn = openDb();

$sql = "SELECT * FROM playlists WHERE PlaylistId = '$playlistId'";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "Playlist Name: " . $row["Name"] . "<br>";

    $sql = "SELECT t.Name AS TrackName, t.Composer, a.Title AS AlbumTitle
            FROM playlist_track pt
            INNER JOIN tracks t ON pt.TrackId = t.TrackId
            INNER JOIN albums a ON t.AlbumId = a.AlbumId
            WHERE pt.PlaylistId = '$playlistId'";
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        echo "Tracks:<br>";
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "  <b>" . $row["TrackName"] . "</b>" . " <br> (Composer: " . $row["Composer"] . ", Album: " . $row["AlbumTitle"] . ")<br>";
        }
    } else {
        echo "No tracks found in playlist.";
    }
} else {
    echo "Playlist not found.";
}