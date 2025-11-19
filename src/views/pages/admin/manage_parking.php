<h2>Manage Parking Areas</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-parking-modal-btn">
        <i class="fa fa-plus"></i> Add New Parking Area
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($parking_areas)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No parking areas found. Click "Add New Parking Area" to start.
        </p>
    <?php else: ?>
        <?php foreach ($parking_areas as $park): ?>
            <div class="admin-card">
                <div style="position: relative; height: 180px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($park['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($park['name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.2em; margin-bottom: 5px;"><?php echo htmlspecialchars($park['name']); ?></h3>
                    
                    <p style="font-size: 0.9em; color: #666;">
                        <strong>Fees:</strong> <?php echo htmlspecialchars($park['fees']); ?>
                    </p>
                    <p style="font-size: 0.9em; color: #666;">
                        <strong>Hours:</strong> <?php echo htmlspecialchars($park['operating_hours']); ?>
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $park['id']; ?>"
                            data-name="<?php echo htmlspecialchars($park['name']); ?>"
                            data-address="<?php echo htmlspecialchars($park['address']); ?>"
                            data-description="<?php echo htmlspecialchars($park['description']); ?>"
                            data-fees="<?php echo htmlspecialchars($park['fees']); ?>"
                            data-operating_hours="<?php echo htmlspecialchars($park['operating_hours']); ?>"
                            data-gmap_link="<?php echo htmlspecialchars($park['gmap_link']); ?>"
                            data-image_url="<?php echo htmlspecialchars($park['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_parking&id=<?php echo $park['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this parking area?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="parking-modal">
    <div class="modal-content">
        <h2 id="parking-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Parking Area</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/parking_form.php'; ?>
    </div>
</div>