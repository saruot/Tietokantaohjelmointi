<?php
    require_once './includes.php';


    $conn = openDb();

    $artist_id = 12; // Tähän määriteltäisiin frontendistä tai jostain muualta haettava artisti_id, joka haettaisiin esim $_POST['parametri'] metodilla ja määriteltäisiin muuttujaan.

    $sql = "SELECT * FROM artists WHERE ArtistId = $artist_id";
    $result = $conn->query($sql);

    if ($result->rowCount() == 0) {
        die("Artist not found.");
    }

    $row = $result->fetch(PDO::FETCH_ASSOC);
    $artist_name = $row['Name'];

    $sql = "SELECT albums.Title AS AlbumTitle, tracks.Name AS SongName
            FROM albums
            JOIN artists ON artists.ArtistId = albums.ArtistId
            JOIN tracks ON tracks.AlbumId = albums.AlbumId
            WHERE artists.ArtistId = $artist_id
            ORDER BY albums.Title ASC, tracks.Name ASC";

    $result = $conn->query($sql);

    if ($result->rowCount() == 0) {
        die("No albums or songs found for artist.");
    }

    $albums = array();
    $current_album = "";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $album_title = $row['AlbumTitle'];
        $song_name = $row['SongName'];

        if ($current_album != $album_title) {
            $current_album = $album_title;
            $albums[$current_album] = array();
        }

        array_push($albums[$current_album], $song_name);
    }

    $data = array(
        "artist_name" => $artist_name,
        "albums" => $albums
    );

    $json = json_encode($data);

    echo $json;