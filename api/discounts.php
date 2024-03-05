<?php

// Gelen isteği kontrol et
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gelen veriyi JSON formatında al
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Gelen verileri al
    $total_price = $data['total_price'];
    $district_id = $data['district_id'];
    $total_nights = $data['total_nights'];
    $concept_id = $data['concept_id'];
    
    // İndirim hesapla ve sonucu döndür
    $discounted_price = calculateDiscount($total_price, $district_id, $total_nights, $concept_id);
    
    // Sonucu JSON formatında döndür
    echo $discounted_price;

} else {
    // Desteklenmeyen HTTP metodu için hata döndür
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}
// İndirim hesaplayan fonksiyon
function calculateDiscount($total_price, $district_id, $total_nights, $concept_id) {
    $discounted_price = $total_price;

    // Toplam fiyat 20.000 TL veya daha fazlaysa %10 indirim uygula
    if ($total_price >= 20000) {
        $discounted_price *= 0.90; // %10 indirim
    } else if ($district_id == 1 && $total_nights >= 7) {
        $oneDayPrice = $total_price / $total_nights;
        $discounted_price = $total_price - $oneDayPrice;
    } else if ($district_id == 2 && $total_nights >= 2) {
        // Sabit bir indirim oranı uygula
        $discounted_price *= 0.75;
    } else if ($district_id == 3 && $total_nights >= 4) {
        $discounted_price *= 0.90; // %10 indirim
    }

    return $discounted_price;
}

?>
