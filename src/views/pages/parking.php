<style>
    /* HEADER */
    .parking-header {
        text-align: center;
        background: linear-gradient(rgba(0, 51, 102, 0.9), rgba(0, 51, 102, 0.7)), url('<?php echo BASE_URL; ?>/images/manaoag-seal.png');
        background-size: cover; background-position: center; color: white;
        padding: 60px 20px; margin-bottom: 40px; border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .parking-header h2 { font-size: 3.5em; font-weight: 800; margin: 0; }

    /* GRID */
    .parking-container {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px; max-width: 1200px; margin: 0 auto 60px; padding: 0 20px;
    }
    .parking-card {
        background: white; border-radius: 12px; overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: transform 0.3s;
        cursor: pointer; border: 1px solid #eee;
    }
    .parking-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

    .pk-img-box { position: relative; height: 180px; overflow: hidden; }
    .pk-img-box img { width: 100%; height: 100%; object-fit: cover; }
    
    .pk-badge {
        position: absolute; top: 10px; left: 10px;
        background: rgba(0, 51, 102, 0.9); color: white;
        padding: 4px 10px; border-radius: 4px; font-size: 0.8em; font-weight: bold;
    }

    .pk-details { padding: 20px; }
    .pk-details h3 { margin: 0 0 10px; color: #333; font-size: 1.3em; }
    .pk-info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9em; color: #555; }
    .pk-info-row i { color: #007bff; width: 20px; }

    /* MODAL (Reused from Spots) */
    .spot-modal {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.8); align-items: center; justify-content: center;
    }
    .spot-modal-content {
        background: #fff; width: 90%; max-width: 1000px; height: 70vh;
        border-radius: 12px; overflow: hidden; display: flex; position: relative;
    }
    .modal-close-btn {
        position: absolute; top: 15px; right: 20px; font-size: 30px; color: #333;
        cursor: pointer; z-index: 10; background: rgba(255,255,255,0.8);
        width: 40px; height: 40px; border-radius: 50%; text-align: center; line-height: 40px;
    }
    .modal-left { flex: 1; padding: 30px; overflow-y: auto; }
    .modal-right { flex: 1.5; background: #eee; } /* Mas malaki map para sa parking */
    .modal-map-frame { width: 100%; height: 100%; border: none; }

    @media (max-width: 768px) { .spot-modal-content { flex-direction: column; height: 90vh; } }
</style>

<div class="parking-header">
    <h2>Parking Areas</h2>
    <p>Find a safe spot for your vehicle.</p>
</div>

<div class="parking-container">
    <?php if (empty($parking_areas)): ?>
        <p style="text-align:center; width:100%; color:#777;">No parking areas found.</p>
    <?php else: ?>
        <?php foreach ($parking_areas as $park): ?>
            <div class="parking-card" onclick='openParkingModal(<?php echo json_encode($park); ?>)'>
                <div class="pk-img-box">
                    <span class="pk-badge">OPEN 24/7</span> <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($park['image_url'] ?? 'default.png'); ?>" alt="Parking">
                </div>
                <div class="pk-details">
                    <h3><?php echo htmlspecialchars($park['name']); ?></h3>
                    <div class="pk-info-row">
                        <span><i class="fa-solid fa-money-bill"></i> <?php echo htmlspecialchars($park['fees']); ?></span>
                    </div>
                    <div class="pk-info-row">
                        <span><i class="fa-solid fa-clock"></i> <?php echo htmlspecialchars($park['operating_hours']); ?></span>
                    </div>
                    <div class="pk-info-row">
                        <span><i class="fa-solid fa-map-pin"></i> Tap to view map</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="parkingModal" class="spot-modal">
    <div class="spot-modal-content">
        <span class="modal-close-btn" onclick="closeParkingModal()">×</span>
        
        <div class="modal-left">
            <h2 id="pkTitle" style="color:#003366; margin-top:0;"></h2>
            <hr style="border:0; border-top:1px solid #eee; margin:15px 0;">
            
            <p><strong><i class="fa-solid fa-location-dot"></i> Address:</strong> <span id="pkAddress"></span></p>
            <p><strong><i class="fa-solid fa-money-bill-wave"></i> Fees:</strong> <span id="pkFees"></span></p>
            <p><strong><i class="fa-regular fa-clock"></i> Hours:</strong> <span id="pkHours"></span></p>
            
            <div style="background:#f9f9f9; padding:15px; border-radius:8px; margin-top:20px;">
                <strong>Description:</strong>
                <p id="pkDesc" style="margin-bottom:0; color:#555;"></p>
            </div>
        </div>

        <div class="modal-right">
            <iframe id="pkMap" class="modal-map-frame" src="" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
</div>

<script>
function openParkingModal(park) {
    document.getElementById('pkTitle').innerText = park.name;
    document.getElementById('pkAddress').innerText = park.address;
    document.getElementById('pkFees').innerText = park.fees;
    document.getElementById('pkHours').innerText = park.operating_hours;
    document.getElementById('pkDesc').innerText = park.description;

    // Map Logic
    const mapFrame = document.getElementById('pkMap');
    if (park.gmap_link && park.gmap_link.includes("embed")) {
        mapFrame.src = park.gmap_link;
    } else {
        const searchQuery = encodeURIComponent(park.name + " " + park.address + " Manaoag");
        mapFrame.src = "https://maps.google.com/maps?q=" + searchQuery + "&t=h&z=19&ie=UTF8&iwloc=&output=embed";
    }

    document.getElementById('parkingModal').style.display = "flex";
}

function closeParkingModal() {
    document.getElementById('parkingModal').style.display = "none";
    document.getElementById('pkMap').src = "";
}
</script>