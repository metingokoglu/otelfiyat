<?php
require_once('../db/database.php');


// HTTP metodu kontrolü
$method = $_SERVER['REQUEST_METHOD'];

// Rezervasyonları listeleme
if ($method == 'GET') {
    // Tüm rezervasyonları al
    $sql = "select r.id,h.`name` as hotelname,c.`name` as customername,con.`name` as conceptname ,rm.`name` as roomname, total_nights,
            price_per_night,total_price from reservations r left join customers c on c.id = r.customer_id left join hotels h on h.id = r.hotel_id left join concepts con on con.id =r.concept_id
            left join rooms rm on rm.id = r.room_id";
    $result = $conn->query($sql);

    $reservations = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }

    // JSON formatında rezervasyonları döndür
    header('Content-Type: application/json');
    echo json_encode($reservations);
}

// Yeni rezervasyon ekleme
elseif ($method == 'POST') {
    $price_per_night=0;
    $open_for_sale=0;
    $discountprice=0;
    // POST verilerini al
    $data = json_decode(file_get_contents("php://input"), true);
    // Yeni rezervasyonu veritabanına ekle
    $customer_id = $data['customer_id'];
    $hotel_id = $data['hotel_id'];
    $room_id = $data['room_id'];
    $concept_id = $data['concept_id'];
    $total_nights = $data['total_nights'];
    

    $conceptsData = $conn->query('select * from concepts');
    foreach ($conceptsData as $item) {
        if($item['hotel_id'] == $hotel_id and $item['room_id']==$room_id and $concept_id == $item['id']){
            $price_per_night=$item['price'];
            $open_for_sale = $item['open_for_sale'];
        }
    }
    $total_price = $total_nights * $price_per_night;
    $hotels = $conn->query('select * from hotels where id='.$hotel_id);
    if($hotels->num_rows>0){
        $hotel = $hotels->fetch_assoc();
        $district_id=$hotel['district_id'];
    }
    $data = array(
        'total_price' => $total_price,
        'district_id' => $district_id,
        'total_nights' => $total_nights,
        'concept_id' => $concept_id
    );

    $url = 'http://localhost/otelfiyat/api/discounts.php';
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array('Content-Type: application/json')
    ));
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'CURL Hatası: ' . curl_error($ch);
    } else {
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status !== 200) {
            echo 'HTTP Hatası: ' . $http_status;
        } else {
            $discountprice=$response;
        }
    }
    
    // CURL kapat
    curl_close($ch);
    
    if($open_for_sale ==1){
        $sql = "INSERT INTO reservations (customer_id, hotel_id, room_id, concept_id, total_nights, price_per_night,total_price)
            VALUES ('$customer_id', '$hotel_id', '$room_id', '$concept_id', '$total_nights', '$price_per_night','$discountprice')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode($data);
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    }else{
        echo "Kosept Satışa Uygun Değil.";
    }
    
}
elseif ($method == 'PUT') {
    // Veriyi al
    $data = json_decode(file_get_contents("php://input"), true);
    $reservation_id = $data['id'];
    $customer_id = $data['customer_id'];
    $hotel_id = $data['hotel_id'];
    $room_id = $data['room_id'];
    $concept_id = $data['concept_id'];
    $total_nights = $data['total_nights'];

    // Güncelleme sorgusunu hazırla
    $sql = "UPDATE reservations SET customer_id='$customer_id', hotel_id='$hotel_id', room_id='$room_id', concept_id='$concept_id', total_nights='$total_nights' WHERE id='$reservation_id'";

    // Sorguyu çalıştır
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Rezervasyon başarıyla güncellendi']);
    } else {
        http_response_code(500); // İsteği yanıtlayan sunucu hatası
        echo json_encode(['message' => 'Güncelleme işlemi sırasında bir hata oluştu']);
    }
}
// Rezervasyon silme
elseif ($method == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $reservation_id = $data['id'];
    // Rezervasyonu veritabanından sil
    $sql = "DELETE FROM reservations WHERE id='$reservation_id'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Rezervasyon başarıyla silindi']);
    } else {
        http_response_code(500); // İsteği yanıtlayan sunucu hatası
        echo json_encode(['message' => 'Silme işlemi sırasında bir hata oluştu']);
    }
}



// Veritabanı bağlantısını kapat
$conn->close();
?>
