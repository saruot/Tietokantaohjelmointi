<?php
    require_once './includes.php';

    $artist_id = ''; // Tähän määriteltäisiin frontendistä tai jostain muualta poistettava ID joka haettaisiin esim $_POST['parametri'] metodilla ja määriteltäisiin muuttujaan.
    $db = openDb();

    $db->beginTransaction();

    try {
        $stmt = $db->prepare('DELETE FROM invoice_items WHERE TrackId IN (SELECT TrackId FROM tracks WHERE AlbumId IN (SELECT AlbumId FROM albums WHERE ArtistId = :artist_id))');
        $stmt->execute(array(':artist_id' => $artist_id));
        
        $stmt = $db->prepare('DELETE playlist_track  FROM playlist_track JOIN tracks ON playlist_track.TrackId = tracks.TrackId WHERE tracks.AlbumId IN (SELECT AlbumId FROM albums WHERE ArtistId = :artist_id)');
        $stmt->execute(array(':artist_id' => $artist_id));
        
        $stmt = $db->prepare('DELETE FROM tracks WHERE AlbumId IN (SELECT AlbumId FROM albums WHERE ArtistId = :artist_id)');
        $stmt->execute(array(':artist_id' => $artist_id));
        
        $stmt = $db->prepare('DELETE FROM albums WHERE ArtistId = :artist_id');
        $stmt->execute(array(':artist_id' => $artist_id));
        
        $stmt = $db->prepare('DELETE FROM artists WHERE ArtistId = :artist_id');
        $stmt->execute(array(':artist_id' => $artist_id));
        
        $db->commit();
        
        echo "Artist and related data deleted successfully.";
    } catch (PDOException $e) {
        // rollback the transaction if there's any error
        $db->rollback();
        echo "Error deleting artist: " . $e->getMessage();
    }