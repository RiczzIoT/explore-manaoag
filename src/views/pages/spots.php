<style>
    /* HEADER & FILTER STYLES */
    .gallery-header {
        text-align: center;
        background: linear-gradient(rgba(0, 51, 102, 0.9), rgba(0, 51, 102, 0.7)), url('<?php echo BASE_URL; ?>/images/manaoag-seal.png');
        background-size: cover; background-position: center; color: white;
        padding: 60px 20px; margin-bottom: 30px; border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .gallery-header h2 { font-size: 3.5em; font-weight: 800; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }

    .filter-container { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; padding: 0 20px; }
    .filter-btn {
        background-color: white; border: 2px solid #003366; color: #003366;
        padding: 8px 20px; border-radius: 50px; cursor: pointer; font-weight: 600;
        transition: all 0.3s ease; font-size: 0.95em;
    }
    .filter-btn:hover, .filter-btn.active {
        background-color: #003366; color: white; transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,51,102,0.2);
    }

    /* MASONRY GRID */
    .gallery-container {
        max-width: 1400px; margin: 0 auto; padding: 0 20px 60px;
        columns: 3 300px; column-gap: 20px;
    }
    .gallery-item {
        break-inside: avoid; background: #fff; border-radius: 15px; margin-bottom: 20px;
        overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative;
        cursor: pointer; animation: fadeIn 0.5s ease; border: 1px solid #eee;
    }
    .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
    .gallery-img-wrapper img { width: 100%; height: auto; display: block; }
    
    .category-badge {
        position: absolute; top: 15px; left: 15px; background: rgba(255, 255, 255, 0.95);
        color: #003366; padding: 5px 12px; border-radius: 20px; font-size: 0.75em;
        font-weight: 800; text-transform: uppercase; letter-spacing: 1px; z-index: 2;
    }
    
    /* CARD SAVE BUTTON */
    .card-save-btn {
        position: absolute; top: 15px; right: 15px;
        background: rgba(255, 255, 255, 0.9); color: #dc3545;
        border: none; border-radius: 50%; width: 40px; height: 40px;
        font-size: 1.2em; cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center;
        transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .card-save-btn:hover { transform: scale(1.1); background: white; }
    .card-save-btn.saved { background: #dc3545; color: white; }

    .view-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 51, 102, 0.6); opacity: 0; transition: opacity 0.3s;
        display: flex; align-items: center; justify-content: center; z-index: 1;
    }
    .gallery-item:hover .view-overlay { opacity: 1; }
    .view-text { color: white; font-weight: bold; border: 2px solid white; padding: 10px 20px; border-radius: 30px; }

    .gallery-details { padding: 20px; }
    .gallery-details h3 { font-size: 1.4em; color: #222; margin: 0 0 5px; font-weight: 700; }
    .gallery-details .address { font-size: 0.9em; color: #666; display: flex; gap: 5px; align-items: center; }

    /* --- SPLIT MODAL WITH SLIDER --- */
    .spot-modal {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.8); align-items: center; justify-content: center;
    }
    .spot-modal-content {
        background: #fff; width: 90%; max-width: 1100px; height: 80vh;
        border-radius: 12px; overflow: hidden; display: flex; position: relative;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .modal-close-btn {
        position: absolute; top: 15px; right: 20px; font-size: 30px; color: #333;
        cursor: pointer; z-index: 10; background: rgba(255,255,255,0.8);
        width: 40px; height: 40px; border-radius: 50%; text-align: center; line-height: 40px;
    }
    
    /* LEFT SIDE */
    .modal-left {
        flex: 1; background: #000; display: flex; flex-direction: column;
        position: relative; 
    }
    .modal-hero-img { width: 100%; height: 100%; object-fit: contain; }
    
    .slider-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        background: rgba(255,255,255,0.2); color: white; border: none;
        padding: 15px; cursor: pointer; font-size: 1.5em; border-radius: 50%;
        transition: background 0.3s; user-select: none; z-index: 5;
    }
    .slider-btn:hover { background: rgba(255,255,255,0.5); }
    .prev-btn { left: 10px; }
    .next-btn { right: 10px; }
    
    /* MODAL INFO OVERLAY (Dito natin ilalagay ang heart) */
    .modal-info-overlay {
        position: absolute; bottom: 0; left: 0; width: 100%;
        background: rgba(0,0,0,0.8); color: white; padding: 25px;
        box-sizing: border-box; z-index: 6;
    }
    
    .modal-header-row {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;
    }
    
    /* Modal Save Button */
    .modal-save-btn {
        background: transparent; border: 2px solid white; color: white;
        width: 45px; height: 45px; border-radius: 50%; cursor: pointer;
        font-size: 1.2em; transition: 0.2s; display: flex; align-items: center; justify-content: center;
    }
    .modal-save-btn:hover { background: white; color: #dc3545; border-color: white; }
    .modal-save-btn.saved { background: #dc3545; color: white; border-color: #dc3545; }

    .modal-info-overlay h2 { margin: 0; font-size: 1.8em; text-shadow: 1px 1px 3px black; }
    .modal-info-overlay p { margin: 5px 0; font-size: 0.95em; opacity: 0.9; }

    /* RIGHT SIDE: MAP */
    .modal-right { flex: 1; position: relative; }
    .modal-map-frame { width: 100%; height: 100%; border: none; }

    @media (max-width: 900px) {
        .spot-modal-content { flex-direction: column; height: 90vh; }
        .modal-left { height: 55%; }
        .modal-right { height: 45%; }
        .gallery-container { columns: 1; }
    }
</style>

<div class="gallery-header">
    <h2>Places to Go</h2>
    <p>Tap a card to view gallery and map.</p>
</div>

<div class="filter-container">
    <button class="filter-btn active" onclick="filterSelection('all')">All Spots</button>
    <button class="filter-btn" onclick="filterSelection('Religious')">Religious</button>
    <button class="filter-btn" onclick="filterSelection('Resort')">Resorts</button>
    <button class="filter-btn" onclick="filterSelection('Nature')">Nature</button>
    <button class="filter-btn" onclick="filterSelection('Hotel')">Hotels</button>
    <button class="filter-btn" onclick="filterSelection('Restaurant')">Restaurants</button>
    <button class="filter-btn" onclick="filterSelection('Historical')">Historical</button>
</div>

<div class="gallery-container" id="gallery-grid">
    <?php if (empty($spots)): ?>
        <div style="text-align:center; padding: 50px; grid-column: 1/-1;">
            <i class="fa-regular fa-image" style="font-size: 3em; color: #ccc;"></i>
            <p style="color: #777; font-size: 1.2em; margin-top: 20px;">No tourist spots added yet.</p>
        </div>
    <?php else: ?>
        <?php foreach ($spots as $spot): ?>
            <div class="gallery-item category-<?php echo strtolower(str_replace(' ', '-', $spot['category'])); ?>" 
                 id="card-spot-<?php echo $spot['id']; ?>"
                 onclick='openSpotModal(<?php echo json_encode($spot); ?>)'>
                
                <div class="gallery-img-wrapper">
                    <span class="category-badge"><?php echo htmlspecialchars($spot['category']); ?></span>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                            $isSaved = isset($favorites['spot-' . $spot['id']]);
                            $action = $isSaved ? 'remove' : 'add';
                            $icon = $isSaved ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                        ?>
                        <button class="card-save-btn <?php echo $isSaved ? 'saved' : ''; ?> save-trigger" 
                                data-item-id="<?php echo $spot['id']; ?>"
                                data-item-type="spot"
                                data-action="<?php echo $action; ?>"
                                onclick="event.stopPropagation(); saveItem(this)">
                            <i class="fa <?php echo $icon; ?>"></i>
                        </button>
                    <?php endif; ?>

                    <div class="view-overlay"><span class="view-text"><i class="fa-solid fa-images"></i> View Gallery</span></div>
                    
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($spot['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($spot['name']); ?>" loading="lazy">
                </div>

                <div class="gallery-details">
                    <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                    <?php if (!empty($spot['address'])): ?>
                        <div class="address">
                            <i class="fa-solid fa-location-dot" style="color: #dc3545;"></i>
                            <span><?php echo htmlspecialchars($spot['address']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="spotModal" class="spot-modal">
    <div class="spot-modal-content">
        <span class="modal-close-btn" onclick="closeSpotModal()">×</span>
        
        <div class="modal-left">
            <img id="modalImg" class="modal-hero-img" src="">
            
            <button class="slider-btn prev-btn" onclick="moveSlide(-1)">❮</button>
            <button class="slider-btn next-btn" onclick="moveSlide(1)">❯</button>

            <div class="modal-info-overlay">
                <div class="modal-header-row">
                    <h2 id="modalTitle"></h2>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button id="modalSaveBtn" class="modal-save-btn" onclick="saveFromModal(this)">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    <?php endif; ?>
                </div>

                <p style="font-weight:bold;">
                    <i class="fa-solid fa-map-pin" style="color:#dc3545; margin-right:5px;"></i> 
                    <span id="modalAddress"></span>
                </p>
                <p id="modalDesc" style="font-size: 0.9em; margin-top: 5px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"></p>
            </div>
        </div>

        <div class="modal-right">
            <iframe id="modalMap" class="modal-map-frame" src="" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
</div>

<script>
// --- GALLERY DATA (SAMPLE) ---
const spotGalleries = {
    "The Manaoag Hotel": [ "3f5a5c4e-bd97-4d64-b2ab-257ed6789a11.jpg", "10f98967-9682-4e39-a5a6-303a885e585f.jpg", "d1217fa4-58c2-45b4-b7ed-59f42804b7bf.jpg" ]
};

let currentGallery = [];
let slideIndex = 0;
const baseUrl = "<?php echo BASE_URL; ?>/images/";

// OPEN MODAL
function openSpotModal(spot) {
    const modal = document.getElementById('spotModal');
    document.getElementById('modalTitle').innerText = spot.name;
    document.getElementById('modalAddress').innerText = spot.address;
    document.getElementById('modalDesc').innerText = spot.description;

    // --- SYNC HEART BUTTON (Card -> Modal) ---
    const modalBtn = document.getElementById('modalSaveBtn');
    if (modalBtn) {
        // Hanapin yung button sa card sa labas
        const cardBtn = document.querySelector(`#card-spot-${spot.id} .save-trigger`);
        
        // Kopyahin ang data attributes
        modalBtn.dataset.itemId = spot.id;
        modalBtn.dataset.itemType = 'spot';
        
        if (cardBtn && cardBtn.classList.contains('saved')) {
            modalBtn.classList.add('saved');
            modalBtn.dataset.action = 'remove';
            modalBtn.innerHTML = '<i class="fa-solid fa-heart"></i>';
        } else {
            modalBtn.classList.remove('saved');
            modalBtn.dataset.action = 'add';
            modalBtn.innerHTML = '<i class="fa-regular fa-heart"></i>';
        }
    }

    // --- SLIDER LOGIC ---
    currentGallery = [spot.image_url || 'default.png'];
    if (spotGalleries[spot.name]) {
        currentGallery = currentGallery.concat(spotGalleries[spot.name]);
    }
    slideIndex = 0;
    showSlide(slideIndex);

    // Arrows visibility
    document.querySelectorAll('.slider-btn').forEach(btn => btn.style.display = (currentGallery.length > 1) ? 'block' : 'none');

    // --- MAP LOGIC ---
    const mapFrame = document.getElementById('modalMap');
    if (spot.gmap_link && spot.gmap_link.includes("embed")) {
        mapFrame.src = spot.gmap_link;
    } else {
        const searchQuery = encodeURIComponent(spot.name + " " + spot.address + " Manaoag");
        mapFrame.src = "https://maps.google.com/maps?q=" + searchQuery + "&t=h&z=18&ie=UTF8&iwloc=&output=embed";
    }

    modal.style.display = "flex";
}

// SAVE FUNCTION (Reused)
function saveItem(btn) {
    // Alisin natin ang 'title' attribute para walang black box tooltip
    btn.removeAttribute('title'); 
    
    const id = btn.dataset.itemId;
    const type = btn.dataset.itemType;
    const action = btn.dataset.action;

    const formData = new FormData();
    formData.append('item_id', id);
    formData.append('item_type', type);
    formData.append('action', action);

    fetch('<?php echo BASE_URL; ?>/index.php?page=toggle_favorite', {
        method: 'POST', body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            const newAction = (action === 'add') ? 'remove' : 'add';
            const isSaved = (action === 'add');
            
            // Update BUTTON VISUALS
            updateBtnVisuals(btn, isSaved, newAction);

            // Kung nasa loob tayo ng modal, update din yung button sa labas (Card)
            if (btn.id === 'modalSaveBtn') {
                const cardBtn = document.querySelector(`#card-spot-${id} .save-trigger`);
                if(cardBtn) updateBtnVisuals(cardBtn, isSaved, newAction);
            } 
            // Kung nasa labas tayo, update din yung modal button (kung nakabukas)
            else {
                 const modalBtn = document.getElementById('modalSaveBtn');
                 if(modalBtn && modalBtn.dataset.itemId == id) updateBtnVisuals(modalBtn, isSaved, newAction);
            }

        } else {
            alert('Please login to save favorites.');
            window.location.href = 'index.php?page=user_login';
        }
    });
}

// Helper para magpalit ng itsura ng heart
function updateBtnVisuals(btn, isSaved, newAction) {
    btn.dataset.action = newAction;
    if (isSaved) {
        btn.classList.add('saved');
        btn.innerHTML = '<i class="fa-solid fa-heart"></i>';
    } else {
        btn.classList.remove('saved');
        btn.innerHTML = '<i class="fa-regular fa-heart"></i>';
    }
}

// Wrapper para sa Modal Save Button click
function saveFromModal(btn) {
    saveItem(btn);
}

function moveSlide(n) {
    slideIndex += n;
    if (slideIndex >= currentGallery.length) slideIndex = 0;
    if (slideIndex < 0) slideIndex = currentGallery.length - 1;
    showSlide(slideIndex);
}
function showSlide(index) {
    document.getElementById('modalImg').src = baseUrl + currentGallery[index];
}
function closeSpotModal() {
    document.getElementById('spotModal').style.display = "none";
    document.getElementById('modalMap').src = "";
}
function filterSelection(category) {
    var x = document.getElementsByClassName("gallery-item");
    if (category == "all") category = "";
    for (var i = 0; i < x.length; i++) {
        if (x[i].className.indexOf(category.toLowerCase()) > -1 || category == "") {
            x[i].style.display = "inline-block"; x[i].style.width = "100%";
        } else { x[i].style.display = "none"; }
    }
    var btns = document.getElementsByClassName("filter-btn");
    for (var j = 0; j < btns.length; j++) {
        btns[j].classList.remove("active");
        if(btns[j].getAttribute('onclick').includes(category || 'all')) { btns[j].classList.add("active"); }
    }
}
filterSelection("all");
</script>