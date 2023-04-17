<?php
    require_once './includes.php';

    $pdo = openDb();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $artist_name = 'testi';    // NÄIDEN KAIKKIEN ARVOT SAATAISIIN  $_POST['parametri'] METODILLA FRONTENDISTÄ 
    $album_name = 'testi';
    $song_titles = ['testi'];
    $media_type_id = 3;
    $milliseconds = 123123;
    $unitprice = 0.99;

    $pdo->beginTransaction();

    try {

        // Insert the new artist
        $stmt = $pdo->prepare("INSERT INTO artists (name) VALUES (:name)");
        $stmt->execute(array(':name' => $artist_name));
        $artist_id = $pdo->lastInsertId();
    
        // Insert the new album
        $stmt = $pdo->prepare("INSERT INTO albums (title, artistId) VALUES (:title, :artist_id)");
        $stmt->execute(array(':title' => $album_name, ':artist_id' => $artist_id));
        $album_id = $pdo->lastInsertId();
    
        // Insert the new songs
        foreach ($song_titles as $title) {
          $stmt = $pdo->prepare("INSERT INTO tracks (name, albumId, mediaTypeId, milliseconds, unitprice) VALUES (:name, :album_id, :media_type_id, :milliseconds, :unitprice)");
          $stmt->execute(array(':name' => $title, ':album_id' => $album_id, ':media_type_id' => $media_type_id, ':milliseconds' => $milliseconds, ':unitprice' => $unitprice));
        }
    
        // Commit the transaction
        $pdo->commit();
    
        // Return a success message
        echo json_encode(array('message' => 'New artist, album and songs added successfully.'));
    
      } catch (PDOException $e) {
    
        // Rollback the transaction
        $pdo->rollback();
    
        // Return an error message
        echo json_encode(array('message' => 'Error adding new artist, album and songs: ' . $e->getMessage()));
      }
    }  else {
        echo json_encode(array('message' => 'HTTP method not allowed.'));
      }