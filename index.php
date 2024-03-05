<?php require_once('db/database.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervasyon Yönetimi</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
</head>
<body>

<!-- Rezervasyon Ekle Modalı -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <h2>Yeni Rezervasyon Ekle</h2>
        <label for="hotel">Otel Seçiniz:</label>
        <select id="hotel" onclick="updateRoomAndConcepts();">
            <?php
            $hotels = $conn->query('select * from hotels');
            foreach ($hotels as $hotel) {
                echo '<option value="' . $hotel['id'] . '">' . $hotel['name'] . '</option>';
            }
            ?>
        </select>
        <label for="room">Oda Seçiniz:</label>
        <select id="room" onchange="loadConcepts()">
            <?php
            $rooms = $conn->query('select * from rooms');
            foreach ($rooms as $room) {
                if($room['hotel_id']==1){
                    echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
                }
            }
            ?>
        </select>
        <label for="concept">Konsept Seçiniz:</label>
        <select id="concept">
            <?php
            $concepts = $conn->query('select * from concepts');
            foreach ($concepts as $concept) {
                if($concept['hotel_id']==1 and $concept['room_id']==1 ){
                    echo '<option value="' . $concept['id'] . '">' . $concept['name'] . '</option>';
                }
            }
            ?>
        </select>
        <label for="customer">Müşteri Seçiniz:</label>
        <select id="customer">
            <?php
            $customers = $conn->query('select * from customers');
            foreach ($customers as $customer) {
                echo '<option value="' . $customer['id'] . '">' . $customer['name'] . '</option>';
            }
            ?>
        </select>
        <label for="night">Kalınacak Gece Sayısı:</label>
        <input type="number" id="total_nights" name="total_nights" />
        <button id="saveButton">Kaydet</button>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>Rezervasyonu Düzenle</h2>
        <input type="hidden" id="reservationId"> <!-- Rezervasyon ID'si saklanacak -->
        <label for="hotel">Otel Seçiniz:</label>
        <select id="hotel" onclick="updateRoomAndConceptsEdit();">
            <?php
            $hotels = $conn->query('select * from hotels');
            foreach ($hotels as $hotel) {
                echo '<option value="' . $hotel['id'] . '">' . $hotel['name'] . '</option>';
            }
            ?>
        </select>
        <label for="room">Oda Seçiniz:</label>
        <select id="room" onchange="loadConceptsEdit()">
        <?php
            $rooms = $conn->query('select * from rooms');
            foreach ($rooms as $room) {
                if($room['hotel_id']==1){
                    echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
                }
            }
            ?>
        </select>
        <label for="concept">Konsept Seçiniz:</label>
        <select id="concept">
        <?php
            $concepts = $conn->query('select * from concepts');
            foreach ($concepts as $concept) {
                if($concept['hotel_id']==1 and $concept['room_id']==1 ){
                    echo '<option value="' . $concept['id'] . '">' . $concept['name'] . '</option>';
                }
            }
            ?>
        </select>
        <label for="customer">Müşteri Seçiniz:</label>
        <select id="customer">
        <?php
            $customers = $conn->query('select * from customers');
            foreach ($customers as $customer) {
                echo '<option value="' . $customer['id'] . '">' . $customer['name'] . '</option>';
            }
            ?>
        </select>
        <label for="night">Kalınacak Gece Sayısı:</label>
        <input type="number" id="total_nights" name="total_nights" />
        <button id="updateButton">Güncelle</button> <!-- Kaydet butonu güncelleme butonu olarak değiştirildi -->
    </div>
</div>
<div class="container">
    <h2>Rezervasyon Yönetimi</h2>
    <button id="addButton">Yeni Rezervasyon Ekle</button>
    <table id="bookingTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Müşteri ID</th>
                <th>Otel ID</th>
                <th>Oda ID</th>
                <th>Konsept ID</th>
                <th>Toplam Geceler</th>
                <th>Gecelik Fiyat</th>
                <th>Toplam Fiyat</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script src="js/script.js"></script>


</body>
</html>
