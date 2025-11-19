<h2>Manage Tourist Spots</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-spot-modal-btn">
        <i class="fa fa-plus"></i> Add New Spot
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($spots)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No tourist spots found. Click "Add New Spot" to start.
        </p>
    <?php else: ?>
        <?php foreach ($spots as $spot): ?>
            <div class="admin-card">
                <div style="position: relative; height: 200px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($spot['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($spot['name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <span style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.8em; text-transform: uppercase;">
                        <?php echo htmlspecialchars($spot['category']); ?>
                    </span>
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.3em; margin-bottom: 5px;"><?php echo htmlspecialchars($spot['name']); ?></h3>
                    
                    <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                        <i class="fa fa-map-marker-alt" style="color: #dc3545;"></i> 
                        <?php echo htmlspecialchars($spot['address']); ?>
                    </p>
                    
                    <p style="font-size: 0.9em; color: #555; line-height: 1.4;">
                        <?php echo substr(htmlspecialchars($spot['description']), 0, 100); ?>...
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $spot['id']; ?>"
                            data-name="<?php echo htmlspecialchars($spot['name']); ?>"
                            data-description="<?php echo htmlspecialchars($spot['description']); ?>"
                            data-category="<?php echo htmlspecialchars($spot['category']); ?>"
                            data-address="<?php echo htmlspecialchars($spot['address']); ?>"
                            data-gmap_link="<?php echo htmlspecialchars($spot['gmap_link']); ?>"
                            data-image_url="<?php echo htmlspecialchars($spot['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_spot&id=<?php echo $spot['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this spot?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="spot-modal">
    <div class="modal-content">
        <h2 id="spot-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Spot</h2>
        
        <?php include BASE_PATH . '/src/views/pages/admin/spot_form.php'; ?>
    </div>
</div>