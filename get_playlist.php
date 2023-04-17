<?php
require_once './includes.php';

  $playlist_id = 6;

  $conn = openDb();

  // Get playlist info
  $sql = "SELECT * FROM tracks, playlist_track, playlists WHERE tracks.TrackId = playlist_track.TrackId AND playlist_track.PlaylistId = playlists.PlaylistId AND playlists.playlistId = $playlist_id";
  $result = $conn->query($sql);
  $row = $result->fetch(PDO::FETCH_ASSOC);
  var_dump($row);
  // Get playlist tracks info


  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "Track: " . $row["track_name"] . ", Composer: " . $row["composer_name"] . "\n";
  }

  

