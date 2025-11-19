<style>
    /* --- HEADER --- */
    .page-header {
        text-align: center;
        background: linear-gradient(rgba(0, 51, 102, 0.9), rgba(0, 51, 102, 0.7)), url('<?php echo BASE_URL; ?>/images/manaoag-seal.png');
        background-size: cover; background-position: center; color: white;
        padding: 60px 20px; margin-bottom: 40px; border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .page-header h2 { font-size: 3em; font-weight: 900; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
    .page-header p { font-size: 1.2em; opacity: 0.9; margin-top: 10px; }

    /* --- WIDE GRID LIST --- */
    .councilor-grid {
        display: grid;
        /* Use 500px min para laging wide ang cards, magiging 2 columns sa malaking screen */
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr)); 
        gap: 25px;
        max-width: 1300px;
        margin: 0 auto 60px;
        padding: 0 20px;
    }

    /* --- WIDE CARD STYLE (Picture Left, Info Right) --- */
    .councilor-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        border: 1px solid #eee;
        display: flex; /* Ito ang nagpapa-wide/horizontal sa kanya */
        flex-direction: row;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        height: 200px; /* Fixed height para pantay lahat */
    }

    .councilor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        border-color: #003366;
    }

    /* LEFT: IMAGE BOX */
    .c-img-box {
        width: 180px; /* Fixed width para sa picture */
        flex-shrink: 0;
        position: relative;
        background: #f4f4f4;
    }
    .c-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Crop automatically */
        object-position: top center; /* Focus sa mukha */
        transition: transform 0.5s;
    }
    .councilor-card:hover .c-img-box img { transform: scale(1.05); }

    /* RIGHT: INFO BOX */
    .c-info {
        flex-grow: 1;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .c-role {
        color: #007bff; font-weight: 700; font-size: 0.85em;
        text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;
    }
    
    .c-name {
        font-size: 1.4em; font-weight: 800; color: #003366;
        margin: 0 0 10px; line-height: 1.2;
    }

    .c-preview {
        font-size: 0.9em; color: #666; margin-bottom: 15px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }

    .read-more {
        font-size: 0.85em; font-weight: bold; color: #333; 
        display: flex; align-items: center; gap: 5px;
    }
    .read-more i { transition: transform 0.3s; }
    .councilor-card:hover .read-more i { transform: translateX(5px); color: #007bff; }


    /* --- MODAL STYLE (Split View) --- */
    .c-modal {
        display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.85); align-items: center; justify-content: center;
    }
    .c-modal-content {
        background: #fff; width: 90%; max-width: 900px; height: 75vh;
        border-radius: 12px; overflow: hidden; display: flex; position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .modal-close-btn {
        position: absolute; top: 15px; right: 20px; font-size: 30px; color: #333;
        cursor: pointer; z-index: 10; background: rgba(255,255,255,0.9);
        width: 40px; height: 40px; border-radius: 50%; text-align: center; line-height: 40px;
    }
    
    /* Modal Left: Image */
    .c-modal-left { flex: 1; background: #eee; }
    .c-modal-img { width: 100%; height: 100%; object-fit: cover; object-position: top; }

    /* Modal Right: Details */
    .c-modal-right {
        flex: 1.5; padding: 40px; overflow-y: auto; display: flex; flex-direction: column;
    }
    .c-modal-name { font-size: 2em; color: #003366; margin: 0; line-height: 1.1; font-weight: 800; }
    .c-modal-role { color: #007bff; font-weight: bold; text-transform: uppercase; margin-bottom: 25px; display: block; }
    .c-modal-msg { font-size: 1.1em; line-height: 1.8; color: #444; flex-grow: 1; white-space: pre-line; }
    
    .c-modal-links {
        margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;
        display: flex; gap: 15px;
    }
    .social-btn {
        flex: 1; text-align: center; padding: 12px; border-radius: 8px; color: white; 
        text-decoration: none; font-weight: bold; display: flex; align-items: center; 
        justify-content: center; gap: 8px; transition: 0.3s;
    }
    .fb-btn { background: #1877f2; } .fb-btn:hover { background: #145dbf; }
    .web-btn { background: #333; } .web-btn:hover { background: #000; }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .councilor-grid { grid-template-columns: 1fr; } /* Stack vertical on phone */
        .councilor-card { height: auto; flex-direction: row; } /* Keep row layout on mobile but auto height */
        .c-img-box { width: 120px; height: auto; } /* Smaller image on mobile */
        
        .c-modal-content { flex-direction: column; height: 90vh; }
        .c-modal-left { height: 40%; }
        .c-modal-right { height: 60%; padding: 20px; }
    }
</style>

<div class="page-header">
    <h2>Sangguniang Bayan</h2>
    <p>Meet the dedicated councilors serving the Municipality of Manaoag.</p>
</div>

<div class="councilor-grid">
    <?php if (empty($councilors)): ?>
        <p style="text-align:center; width:100%; color:#777; font-size:1.2em;">No councilor profiles found.</p>
    <?php else: ?>
        <?php foreach ($councilors as $official): ?>
            
            <div class="councilor-card" onclick='openCouncilorModal(<?php echo json_encode($official); ?>)'>
                
                <div class="c-img-box">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($official['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($official['name']); ?>">
                </div>

                <div class="c-info">
                    <span class="c-role">SB Member</span>
                    <h3 class="c-name"><?php echo htmlspecialchars($official['name']); ?></h3>
                    
                    <div class="c-preview">
                        <?php echo strip_tags($official['message']); ?>
                    </div>

                    <div class="read-more">
                        Read Full Profile <i class="fa fa-arrow-right"></i>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="councilorModal" class="c-modal">
    <div class="c-modal-content">
        <span class="modal-close-btn" onclick="closeCouncilorModal()">×</span>
        
        <div class="c-modal-left">
            <img id="modalImg" class="c-modal-img" src="">
        </div>

        <div class="c-modal-right">
            <h2 id="modalName" class="c-modal-name"></h2>
            <span class="c-modal-role">Sangguniang Bayan Member</span>
            
            <div style="overflow-y: auto; padding-right: 10px;">
                <p id="modalMsg" class="c-modal-msg"></p>
            </div>

            <div class="c-modal-links">
                <a id="modalFb" href="#" target="_blank" class="social-btn fb-btn">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a id="modalWeb" href="#" target="_blank" class="social-btn web-btn">
                    <i class="fas fa-globe"></i> Website
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openCouncilorModal(official) {
    // Populate Modal Data
    document.getElementById('modalImg').src = "<?php echo BASE_URL; ?>/images/" + (official.image_url || 'default.png');
    document.getElementById('modalName').innerText = official.name;
    document.getElementById('modalMsg').innerHTML = official.message.replace(/\n/g, '<br>');

    // Buttons Visibility
    const fbBtn = document.getElementById('modalFb');
    if (official.facebook_url) {
        fbBtn.href = official.facebook_url;
        fbBtn.style.display = 'flex';
    } else {
        fbBtn.style.display = 'none';
    }

    const webBtn = document.getElementById('modalWeb');
    if (official.website_url) {
        webBtn.href = official.website_url;
        webBtn.style.display = 'flex';
    } else {
        webBtn.style.display = 'none';
    }

    document.getElementById('councilorModal').style.display = 'flex';
}

function closeCouncilorModal() {
    document.getElementById('councilorModal').style.display = 'none';
}
</script>