<h2>Manage Digital Guides & Tours</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-guide-modal-btn">
        <i class="fa fa-plus"></i> Add New Guide/Tour
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($guides)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No guides found. Click "Add New Guide" to start.
        </p>
    <?php else: ?>
        <?php foreach ($guides as $guide): ?>
            <div class="admin-card">
                <div style="position: relative; height: 200px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($guide['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($guide['guide_name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <span style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.6); color: white; padding: 8px; font-size: 0.9em; text-align: center;">
                        <?php echo htmlspecialchars($guide['specialization']); ?>
                    </span>
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.3em; margin-bottom: 5px;"><?php echo htmlspecialchars($guide['guide_name']); ?></h3>
                    <p style="font-size: 0.9em; color: #666;">
                        <i class="fa fa-phone"></i> <?php echo htmlspecialchars($guide['contact_number']); ?>
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $guide['id']; ?>"
                            data-guide_name="<?php echo htmlspecialchars($guide['guide_name']); ?>"
                            data-description="<?php echo htmlspecialchars($guide['description']); ?>"
                            data-specialization="<?php echo htmlspecialchars($guide['specialization']); ?>"
                            data-contact_number="<?php echo htmlspecialchars($guide['contact_number']); ?>"
                            data-facebook_link="<?php echo htmlspecialchars($guide['facebook_link']); ?>"
                            data-image_url="<?php echo htmlspecialchars($guide['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_guide&id=<?php echo $guide['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this guide?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="guide-modal">
    <div class="modal-content">
        <h2 id="guide-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Guide</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/guide_form.php'; ?>
    </div>
</div>