<style>
    /* HEADER & FILTER */
    .gallery-header {
        text-align: center;
        background: linear-gradient(rgba(255, 193, 7, 0.9), rgba(255, 193, 7, 0.7)), url('<?php echo BASE_URL; ?>/images/manaoag-seal.png');
        background-size: cover; background-position: center; color: #333;
        padding: 60px 20px; margin-bottom: 30px; border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .gallery-header h2 { font-size: 3.5em; font-weight: 800; margin: 0; color: #003366; text-shadow: 1px 1px 0px rgba(255,255,255,0.5); }
    
    .filter-container { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 40px; padding: 0 20px; }
    .filter-btn {
        background-color: white; border: 2px solid #ffc107; color: #333;
        padding: 8px 20px; border-radius: 50px; cursor: pointer; font-weight: 600;
        transition: all 0.3s ease; font-size: 0.95em;
    }
    .filter-btn:hover, .filter-btn.active {
        background-color: #ffc107; color: #000; transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.4);
    }

    /* GRID */
    .gallery-container {
        max-width: 1200px; margin: 0 auto; padding: 0 20px 60px;
        columns: 4 250px; column-gap: 20px; /* Mas maliit na columns para sa products */
    }
    .gallery-item {
        break-inside: avoid; background: #fff; border-radius: 12px; margin-bottom: 20px;
        overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s ease; position: relative; cursor: pointer;
        border: 1px solid #eee; animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    
    .gallery-img-wrapper img { width: 100%; height: auto; display: block; }
    
    .category-badge {
        position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.6);
        color: #fff; padding: 3px 10px; border-radius: 15px; font-size: 0.7em;
        font-weight: bold; text-transform: uppercase; z-index: 2;
    }

    .save-btn {
        position: absolute; top: 10px; right: 10px;
        background: rgba(255, 255, 255, 0.8); color: #dc3545;
        border: none; border-radius: 50%; width: 35px; height: 35px;
        font-size: 1em; cursor: pointer; z-index: 2; display: flex; align-items: center; justify-content: center;
        transition: 0.2s;
    }
    .save-btn:hover { transform: scale(1.1); background: white; }
    .save-btn.saved { background: #dc3545; color: white; }

    .gallery-details { padding: 15px; }
    .gallery-details h3 { font-size: 1.1em; margin: 0 0 5px; color: #333; }
    .gallery-details p { font-size: 0.85em; color: #666; line-height: 1.4; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}

    /* MODAL */
    .product-modal {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.85); align-items: center; justify-content: center;
    }
    .product-modal-content {
        background: #fff; width: 90%; max-width: 900px; border-radius: 10px;
        display: flex; overflow: hidden; position: relative; max-height: 80vh;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .modal-img-container {
        flex: 1.2; background: #f4f4f4; display: flex; align-items: center; justify-content: center;
    }
    .modal-img-container img { width: 100%; height: 100%; object-fit: cover; }
    
    .modal-info-container { flex: 1; padding: 40px; overflow-y: auto; }
    .modal-info-container h2 { margin-top: 0; color: #003366; font-size: 2em; line-height: 1.1; }
    .modal-category { 
        display: inline-block; background: #ffc107; color: #333; 
        padding: 5px 15px; border-radius: 20px; font-size: 0.8em; 
        font-weight: bold; margin-bottom: 20px; text-transform: uppercase;
    }
    .modal-desc { line-height: 1.8; color: #555; font-size: 1.1em; }
    
    .modal-close {
        position: absolute; top: 15px; right: 20px; font-size: 30px; cursor: pointer; color: #333;
        z-index: 10; width: 40px; height: 40px; text-align: center; line-height: 40px;
        background: rgba(255,255,255,0.8); border-radius: 50%;
    }

    @media (max-width: 768px) {
        .gallery-container { columns: 2 150px; }
        .product-modal-content { flex-direction: column; }
        .modal-img-container { height: 250px; }
    }
</style>

<div class="gallery-header">
    <h2>Local Delicacies & Products</h2>
    <p>Taste the sweetness of Manaoag.</p>
</div>

<div class="filter-container">
    <button class="filter-btn active" onclick="filterSelection('all')">All</button>
    <button class="filter-btn" onclick="filterSelection('Food')">Food</button>
    <button class="filter-btn" onclick="filterSelection('Delicacy')">Delicacies</button>
    <button class="filter-btn" onclick="filterSelection('Handicraft')">Handicrafts</button>
    <button class="filter-btn" onclick="filterSelection('Souvenir')">Souvenirs</button>
</div>

<div class="gallery-container">
    <?php if (empty($products)): ?>
        <p style="text-align:center; color:#777; grid-column:1/-1;">No products found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="gallery-item category-<?php echo strtolower($product['category']); ?>" 
                 onclick='openProductModal(<?php echo json_encode($product); ?>)'>
                
                <div class="gallery-img-wrapper">
                    <span class="category-badge"><?php echo htmlspecialchars($product['category']); ?></span>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                            $isSaved = isset($favorites['product-' . $product['id']]);
                            $action = $isSaved ? 'remove' : 'add';
                            $icon = $isSaved ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                        ?>
                        <button class="save-btn <?php echo $isSaved ? 'saved' : ''; ?>" 
                                onclick="event.stopPropagation(); saveItem(this, '<?php echo $product['id']; ?>', 'product')"
                                data-item-id="<?php echo $product['id']; ?>"
                                data-item-type="product"
                                data-action="<?php echo $action; ?>">
                            <i class="fa <?php echo $icon; ?>"></i>
                        </button>
                    <?php endif; ?>

                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($product['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                </div>

                <div class="gallery-details">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo strip_tags(htmlspecialchars_decode($product['description'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="productModal" class="product-modal">
    <div class="product-modal-content">
        <span class="modal-close" onclick="closeProductModal()">&times;</span>
        <div class="modal-img-container">
            <img id="p-img" src="">
        </div>
        <div class="modal-info-container">
            <span id="p-cat" class="modal-category"></span>
            <h2 id="p-name"></h2>
            <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
            <p id="p-desc" class="modal-desc"></p>
            <div style="margin-top:30px; color:#777; font-size:0.9em; font-style:italic;">
                <i class="fa-solid fa-store"></i> Available at local markets and souvenir shops near the Basilica.
            </div>
        </div>
    </div>
</div>

<script>
function openProductModal(product) {
    document.getElementById('p-img').src = "<?php echo BASE_URL; ?>/images/" + (product.image_url || 'default.png');
    document.getElementById('p-name').innerText = product.name;
    document.getElementById('p-cat').innerText = product.category;
    document.getElementById('p-desc').innerText = product.description;
    document.getElementById('productModal').style.display = "flex";
}

function closeProductModal() {
    document.getElementById('productModal').style.display = "none";
}

// Save Button AJAX Logic (Reused para hindi na mag reload)
function saveItem(btn, id, type) {
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
            if(action === 'add') {
                btn.dataset.action = 'remove';
                btn.classList.add('saved');
                btn.innerHTML = '<i class="fa-solid fa-heart"></i>';
            } else {
                btn.dataset.action = 'add';
                btn.classList.remove('saved');
                btn.innerHTML = '<i class="fa-regular fa-heart"></i>';
            }
        } else {
            alert('Please login to save favorites.');
            window.location.href = 'index.php?page=user_login';
        }
    });
}

// Filter Logic
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
        if(btns[j].innerText.includes(category || 'All')) btns[j].classList.add("active");
    }
}
filterSelection("all");
</script>