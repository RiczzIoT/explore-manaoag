<style>
    /* --- HERO SECTION STYLES --- */
    .hero-section {
        position: relative;
        height: 85vh; /* Tinaasan ko konti para hindi siksikan */
        background-image: url('<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($content['hero_image_url'] ?? 'manaoag_hero.jpg'); ?>');
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }
    
    .hero-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Darker overlay para litaw ang text */
        z-index: 1;
    }

    .hero-content {
        position: relative; z-index: 2; width: 100%; max-width: 1000px; padding: 20px;
    }

    .hero-title {
        font-size: 3.5rem; font-weight: 800; margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7); line-height: 1.1;
    }

    .hero-subtitle {
        font-size: 1.3rem; margin-bottom: 50px; opacity: 0.9;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
    }

    /* --- NEW BUTTONS GRID (Para hindi sabog) --- */
    .hero-buttons-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
    }

    .hero-btn {
        background-color: rgba(255, 255, 255, 0.95);
        color: #003366;
        padding: 14px 28px; /* Mas malaki pindutan */
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: transform 0.2s, background-color 0.2s;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        font-size: 1rem;
        border: 2px solid transparent;
    }

    .hero-btn:hover {
        transform: translateY(-5px);
        background-color: #003366;
        color: white;
        border-color: white;
    }
    
    .hero-btn i { font-size: 1.2em; }

    /* --- FEATURED SECTION STYLES --- */
    .section-container {
        padding: 80px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .section-title {
        text-align: center; font-size: 2.5rem; font-weight: 800; color: #003366; margin-bottom: 50px;
    }

    .grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    /* Card Style */
    .home-card {
        background: white; border-radius: 15px; overflow: hidden; position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.3s;
        text-decoration: none; color: inherit; display: block; border: 1px solid #eee;
    }
    .home-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
    .home-card img { width: 100%; height: 200px; object-fit: cover; }
    .home-card-content { padding: 20px; }
    .home-card-content h3 { margin: 5px 0; font-size: 1.2rem; color: #333; font-weight: 700; }
    .home-card-content span { font-size: 0.8rem; color: #007bff; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; }

    /* Heart/Save Button Style */
    .card-save-btn {
        position: absolute; top: 15px; right: 15px;
        background: rgba(255, 255, 255, 0.9); color: #dc3545;
        border: none; border-radius: 50%; width: 40px; height: 40px;
        font-size: 1.2rem; cursor: pointer; z-index: 10;
        display: flex; align-items: center; justify-content: center;
        transition: 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
    .card-save-btn:hover { transform: scale(1.1); background: white; }
    /* Pula pag saved, outline pag hindi */
    .card-save-btn i { transition: 0.2s; }

    .view-all-container { text-align: center; margin-top: 50px; }
    .view-all-btn {
        display: inline-block; padding: 12px 35px;
        border: 2px solid #003366; color: #003366;
        border-radius: 30px; font-weight: bold; text-decoration: none;
        transition: 0.3s; font-size: 1.1em;
    }
    .view-all-btn:hover { background: #003366; color: white; }

    /* --- HISTORY SECTION --- */
    .history-section { background-color: white; }
    .history-img-wrapper { position: relative; }
    .history-bg-blob {
        position: absolute; top: -20px; left: -20px; right: 20px; bottom: 20px;
        background-color: #eef2ff; border-radius: 20px; z-index: 0; transform: rotate(-2deg);
    }
    .history-img {
        position: relative; z-index: 1; width: 100%; border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    /* --- CTA SECTION --- */
    .cta-section {
        background: linear-gradient(to right, #003366, #0056b3);
        color: white; text-align: center; padding: 80px 20px;
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 2.5rem; }
        .hero-btn { width: 100%; justify-content: center; }
        .section-container { padding: 50px 20px; }
    }
</style>

<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">
            <?php echo htmlspecialchars($content['hero_title'] ?? 'Welcome to Manaoag'); ?>
        </h1>
        <p class="hero-subtitle">Discover the Pilgrim Center of the North.</p>
        
        <div class="hero-buttons-grid">
            <a href="index.php?page=spots" class="hero-btn">
                <i class="fa-solid fa-map-location-dot"></i> Tourist Spots
            </a>
            <a href="index.php?page=products" class="hero-btn">
                <i class="fa-solid fa-basket-shopping"></i> Local Products
            </a>
            <a href="index.php?page=events" class="hero-btn">
                <i class="fa-regular fa-calendar-days"></i> Events
            </a>
            <a href="index.php?page=delivery" class="hero-btn">
                <i class="fa-solid fa-motorcycle"></i> Delivery
            </a>
            <a href="index.php?page=parking" class="hero-btn">
                <i class="fa-solid fa-square-parking"></i> Parking Info
            </a>
            <a href="index.php?page=guides" class="hero-btn">
                <i class="fa-solid fa-person-hiking"></i> Tour Guides
            </a>
        </div>
    </div>
</section>

<?php if (isset($_SESSION['user_id'])): ?>
    
    <section class="section-container" style="background-color: #f9fafb;">
        <h2 class="section-title">Top Places to Visit</h2>
        <div class="grid-layout">
            <?php foreach ($featured_spots as $spot): ?>
                <a href="index.php?page=spots" class="home-card">
                    
                    <?php
                        $isSaved = isset($favorites['spot-' . $spot['id']]);
                        $action = $isSaved ? 'remove' : 'add';
                        $icon = $isSaved ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                    ?>
                    <button class="card-save-btn <?php echo $isSaved ? 'saved' : ''; ?> save-btn" 
                            data-item-id="<?php echo $spot['id']; ?>"
                            data-item-type="spot"
                            data-action="<?php echo $action; ?>"
                            onclick="event.preventDefault();"> 
                        <i class="fa <?php echo $icon; ?>"></i>
                    </button>

                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($spot['image_url'] ?? 'default.png'); ?>" alt="">
                    <div class="home-card-content">
                        <span><?php echo htmlspecialchars($spot['category']); ?></span>
                        <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="view-all-container">
            <a href="index.php?page=spots" class="view-all-btn">Explore All Places</a>
        </div>
    </section>

    <section class="section-container">
        <h2 class="section-title">Local Delicacies</h2>
        <div class="grid-layout">
            <?php foreach ($featured_products as $product): ?>
                <a href="index.php?page=products" class="home-card">
                    
                    <?php
                        $isSaved = isset($favorites['product-' . $product['id']]);
                        $action = $isSaved ? 'remove' : 'add';
                        $icon = $isSaved ? 'fa-solid fa-heart' : 'fa-regular fa-heart';
                    ?>
                    <button class="card-save-btn <?php echo $isSaved ? 'saved' : ''; ?> save-btn" 
                            data-item-id="<?php echo $product['id']; ?>"
                            data-item-type="product"
                            data-action="<?php echo $action; ?>"
                            onclick="event.preventDefault();"> 
                        <i class="fa <?php echo $icon; ?>"></i>
                    </button>

                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($product['image_url'] ?? 'default.png'); ?>" alt="">
                    <div class="home-card-content">
                        <span><?php echo htmlspecialchars($product['category']); ?></span>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="view-all-container">
            <a href="index.php?page=products" class="view-all-btn">View All Products</a>
        </div>
    </section>

<?php else: ?>
    <section class="cta-section">
        <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 20px;">Join our Community!</h2>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto 30px;">
            Sign up to save your favorite spots, leave reviews, and get personalized recommendations.
        </p>
        <a href="index.php?page=user_register" style="background: #ffc107; color: #333; padding: 15px 40px; border-radius: 50px; font-weight: bold; text-decoration: none; font-size: 1.1rem; display: inline-block; transition: transform 0.3s;">
            Register Now
        </a>
    </section>
<?php endif; ?>

<section class="section-container history-section" id="history">
    <div style="display: flex; flex-direction: column; md:flex-row; gap: 50px; align-items: center;">
        <div style="flex: 1;">
            <span style="color: #007bff; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">Our Heritage</span>
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #333; margin: 10px 0 25px;">
                <?php echo htmlspecialchars($content['history_title'] ?? 'History of Manaoag'); ?>
            </h2>
            <div style="font-size: 1.1rem; line-height: 1.8; color: #555; text-align: justify;">
                <p>
                    <?php echo nl2br(htmlspecialchars($content['history_content'] ?? 'History content goes here...')); ?>
                </p>
            </div>
        </div>
        
        <div style="flex: 1; padding: 20px;">
            <div class="history-img-wrapper">
                <div class="history-bg-blob"></div>
                <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($content['history_image_url'] ?? 'manaoag_church.jpg'); ?>" 
                     alt="Manaoag Church" 
                     class="history-img">
            </div>
        </div>
    </div>
</section>