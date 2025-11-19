<style>
    .guides-header {
        text-align: center; background-color: #003366; color: white;
        padding: 50px 20px; margin-bottom: 40px;
    }
    .guides-header h2 { font-size: 3em; font-weight: 900; margin: 0; }

    .guides-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px; max-width: 1100px; margin: 0 auto 60px; padding: 0 20px;
    }

    .guide-card {
        background: white; border-radius: 15px; overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); text-align: center;
        transition: transform 0.3s; border: 1px solid #f0f0f0;
    }
    .guide-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.15); }

    .guide-img-box {
        height: 150px; background: linear-gradient(45deg, #003366, #0056b3);
        position: relative; margin-bottom: 60px;
    }
    .guide-avatar {
        width: 120px; height: 120px; border-radius: 50%; object-fit: cover;
        border: 4px solid white; position: absolute;
        bottom: -50px; left: 50%; transform: translateX(-50%);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2); background: #fff;
    }

    .guide-info { padding: 0 20px 25px; }
    .guide-info h3 { margin: 0; color: #333; font-size: 1.4em; }
    .guide-role { color: #007bff; font-weight: bold; font-size: 0.9em; text-transform: uppercase; margin-bottom: 15px; display: block; }
    .guide-desc { color: #666; font-size: 0.95em; margin-bottom: 20px; font-style: italic; }

    .guide-actions {
        display: flex; justify-content: center; gap: 10px;
    }
    .contact-btn {
        text-decoration: none; padding: 8px 20px; border-radius: 20px; font-size: 0.9em; font-weight: 600; transition: 0.2s;
    }
    .btn-call { background: #28a745; color: white; }
    .btn-call:hover { background: #218838; }
    
    .btn-fb { background: #3b5998; color: white; }
    .btn-fb:hover { background: #2d4373; }
</style>

<div class="guides-header">
    <h2>Tour Guides</h2>
    <p>Let locals show you the best of Manaoag.</p>
</div>

<div class="guides-grid">
    <?php if (empty($guides)): ?>
        <p style="text-align:center; grid-column:1/-1; color:#777;">No guides listed yet.</p>
    <?php else: ?>
        <?php foreach ($guides as $guide): ?>
            <div class="guide-card">
                <div class="guide-img-box">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($guide['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($guide['guide_name']); ?>" 
                         class="guide-avatar">
                </div>
                <div class="guide-info">
                    <h3><?php echo htmlspecialchars($guide['guide_name']); ?></h3>
                    <span class="guide-role"><?php echo htmlspecialchars($guide['specialization']); ?></span>
                    
                    <p class="guide-desc">"<?php echo htmlspecialchars($guide['description']); ?>"</p>
                    
                    <div class="guide-actions">
                        <?php if (!empty($guide['contact_number'])): ?>
                            <a href="tel:<?php echo htmlspecialchars($guide['contact_number']); ?>" class="contact-btn btn-call">
                                <i class="fa-solid fa-phone"></i> Call
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($guide['facebook_link'])): ?>
                            <a href="<?php echo htmlspecialchars($guide['facebook_link']); ?>" target="_blank" class="contact-btn btn-fb">
                                <i class="fa-brands fa-facebook-f"></i> Message
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>