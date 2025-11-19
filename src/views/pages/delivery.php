<style>
    .delivery-header {
        text-align: center; background-color: #003366; color: white;
        padding: 50px 20px; margin-bottom: 40px;
    }
    .delivery-header h2 { font-size: 3em; font-weight: 900; margin: 0; }

    .delivery-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px; max-width: 1100px; margin: 0 auto 60px; padding: 0 20px;
    }

    .service-card {
        background: white; border-radius: 12px; overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 1px solid #eee;
        display: flex; flex-direction: column; transition: transform 0.3s;
    }
    .service-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

    .service-img {
        width: 100%; height: 180px; object-fit: cover; background: #f4f4f4;
    }
    
    .service-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
    .service-content h3 { margin: 0 0 10px; color: #333; }
    .service-desc { color: #666; font-size: 0.95em; line-height: 1.5; margin-bottom: 20px; flex-grow: 1; }
    
    .contact-box {
        background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: auto;
        display: flex; align-items: center; justify-content: space-between;
    }
    .phone-number { font-weight: bold; color: #003366; font-size: 1.1em; }
    .call-btn {
        background: #003366; color: white; width: 40px; height: 40px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        text-decoration: none; transition: 0.3s;
    }
    .call-btn:hover { background: #0056b3; transform: scale(1.1); }
</style>

<div class="delivery-header">
    <h2>Delivery Services</h2>
    <p>Get your favorites delivered to your doorstep.</p>
</div>

<div class="delivery-grid">
    <?php if (empty($delivery_services)): ?>
        <p style="text-align:center; grid-column:1/-1; color:#777;">No delivery services found.</p>
    <?php else: ?>
        <?php foreach ($delivery_services as $service): ?>
            <div class="service-card">
                <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($service['image_url'] ?? 'default.png'); ?>" 
                     alt="<?php echo htmlspecialchars($service['name']); ?>" 
                     class="service-img">
                
                <div class="service-content">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p class="service-desc"><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
                    
                    <div class="contact-box">
                        <div>
                            <small style="color:#999; display:block;">Call to Order</small>
                            <span class="phone-number"><?php echo htmlspecialchars($service['contact_number']); ?></span>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <?php if (!empty($service['facebook_link'])): ?>
                                <a href="<?php echo htmlspecialchars($service['facebook_link']); ?>" target="_blank" class="call-btn" style="background:#3b5998;">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            <a href="tel:<?php echo htmlspecialchars($service['contact_number']); ?>" class="call-btn">
                                <i class="fa-solid fa-phone"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>