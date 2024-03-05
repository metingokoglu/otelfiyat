const addButton = document.getElementById('addButton');
const addModal = document.getElementById('addModal');
const saveButton = document.getElementById('saveButton');
addButton.addEventListener('click', () => {
    addModal.style.display = 'block';
});

window.addEventListener('click', (event) => {
    if (event.target == addModal) {
        addModal.style.display = 'none';
    }
});
addButton.addEventListener('click', () => {
    addModal.style.display = 'block';
});

saveButton.addEventListener('click', () => {
    const hotelId = document.getElementById('hotel').value;
    const roomId = document.getElementById('room').value;
    addModal.style.display = 'none';
});



function updateRoomAndConcepts() {
    const hotelId = document.getElementById('hotel').value;
    const roomSelect = document.getElementById('room');
    roomSelect.innerHTML = '';
    fetch('api/rooms.php?hotel_id=' + hotelId)
        .then(response => response.json())
        .then(rooms => {
            // Her bir oda için seçenek oluştur
            rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = room.name;
                roomSelect.appendChild(option);
            });

            // Odalar listesi güncellendikten sonra concepts listesini de güncelle
            loadConcepts();
        });
}

function loadConcepts() {
    const hotelId = document.getElementById('hotel').value;
    const roomId = document.getElementById('room').value;
    const conceptSelect = document.getElementById('concept');
    conceptSelect.innerHTML = '';
    fetch('api/concepts.php?hotel_id=' + hotelId + '&room_id=' + roomId)
        .then(response => response.json())
        .then(concepts => {
            if (concepts.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Konsept Tanımlanmamış';
                conceptSelect.appendChild(option);
            } else {
                concepts.forEach(concept => {
                    const option = document.createElement('option');
                    option.value = concept.id;
                    option.textContent = concept.name;
                    conceptSelect.appendChild(option);
                });
            }
        });
}


document.getElementById("saveButton").addEventListener("click", function() {
    var hotelId = document.getElementById("hotel").value;
    var roomId = document.getElementById("room").value;
    var conceptId = document.getElementById("concept").value;
    var customerId = document.getElementById("customer").value;
    var totalNights = document.getElementById("total_nights").value;

    var formData = {
        hotel_id: hotelId,
        room_id: roomId,
        concept_id: conceptId,
        customer_id: customerId,
        total_nights: totalNights
    };
    // API'ye veriyi gönderme
    fetch('api/rezervations.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        location.reload();
    });
});


// API URL'si
const apiUrl = 'http://localhost/otelfiyat/api/rezervations.php';
const bookingTable = document.getElementById('bookingTable').getElementsByTagName('tbody')[0];
fetch(apiUrl)
  .then(response => {
    if (!response.ok) {
      throw new Error('HTTP error, status = ' + response.status);
    }
    return response.json();
  })
  .then(data => {
    // Her rezervasyon için bir satır oluştur
    data.forEach(booking => {
      const row = bookingTable.insertRow();
      row.innerHTML = `
        <td>${booking.id}</td>
        <td>${booking.customername}</td>
        <td>${booking.hotelname}</td>
        <td>${booking.roomname}</td>
        <td>${booking.conceptname}</td>
        <td>${booking.total_nights}</td>
        <td>${booking.price_per_night}</td>
        <td>${booking.total_price}</td>
        <td>
          <button onclick="deleteBooking(${booking.id})">Sil</button>
        </td>
      `;
    });
  })
  .catch(error => {
    console.error('Fetch error:', error);
  });

function deleteBooking(reservationId) {
    const id = reservationId;
    console.log(id)
    $.ajax({
        url:'api/rezervations.php',
        method :'DELETE',
        data: JSON.stringify({ id: id }),
        success:function(res){
            location.reload();
        },
        error:function(error){
            console.log(error)
        }
    })
}

// Tablodaki her bir "Sil" butonuna silme işlemi için olay dinleyici ekleme
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('deleteButton')) {
        const reservationId = event.target.getAttribute('data-reservation-id');
        deleteBooking(reservationId);
    }
});

