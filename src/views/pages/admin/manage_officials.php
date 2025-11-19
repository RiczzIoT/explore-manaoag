<h2>Manage Officials</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-official-modal-btn">
        <i class="fa fa-plus"></i> Add New Official
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($officials)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No officials found. Click "Add New Official" to start.
        </p>
    <?php else: ?>
        <?php foreach ($officials as $official): ?>
            <div class="admin-card">
                <div style="position: relative; height: 250px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($official['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($official['name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover; object-position: top;">
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.3em; margin-bottom: 5px;"><?php echo htmlspecialchars($official['name']); ?></h3>
                    <p style="font-size: 0.9em; color: #007bff; font-weight: bold; text-transform: uppercase;">
                        <?php echo htmlspecialchars($official['position']); ?>
                    </p>
                    <p style="font-size: 0.8em; color: #999;">Order: <?php echo htmlspecialchars($official['order']); ?></p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $official['id']; ?>"
                            data-name="<?php echo htmlspecialchars($official['name']); ?>"
                            data-position="<?php echo htmlspecialchars($official['position']); ?>"
                            data-message="<?php echo htmlspecialchars($official['message']); ?>"
                            data-facebook_url="<?php echo htmlspecialchars($official['facebook_url']); ?>"
                            data-website_url="<?php echo htmlspecialchars($official['website_url']); ?>"
                            data-image_url="<?php echo htmlspecialchars($official['image_url']); ?>"
                            data-order="<?php echo htmlspecialchars($official['order']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_official&id=<?php echo $official['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this official?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="official-modal">
    <div class="modal-content">
        <h2 id="official-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Official</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/official_form.php'; ?>
    </div>
</div>