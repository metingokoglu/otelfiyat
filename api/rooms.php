<?php
require_once('../db/database.php');
// GET isteğinden gelen parametreleri al
$hotelId = $_GET['hotel_id'];


// SQL sorgusunu oluştur
$sql = "SELECT * FROM rooms WHERE hotel_id=$hotelId";

// Sorguyu çalıştır ve sonuçları al
$result = $conn->query($sql);

// Sonuçları JSON formatında döndür
if ($result->num_rows > 0) {
    // Boş bir dizi oluştur
    $rooms = array();

    // Sonuçları diziye dönüştür
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }

    // Diziyi JSON formatında yazdır
    echo json_encode($rooms);
} else {
    // Hiçbir sonuç bulunamadıysa boş JSON dizisi döndür
    echo json_encode(array());
}

// Veritabanı bağlantısını kapat
$conn->close();
?>