<h2>Manage Delivery Services</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-delivery-modal-btn">
        <i class="fa fa-plus"></i> Add New Delivery Service
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($delivery_services)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No delivery services found. Click "Add New Service" to start.
        </p>
    <?php else: ?>
        <?php foreach ($delivery_services as $service): ?>
            <div class="admin-card">
                <div style="position: relative; height: 180px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($service['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($service['name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.3em; margin-bottom: 5px;"><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p style="font-size: 0.9em; color: #666;">
                        <i class="fa fa-phone"></i> <?php echo htmlspecialchars($service['contact_number']); ?>
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $service['id']; ?>"
                            data-name="<?php echo htmlspecialchars($service['name']); ?>"
                            data-description="<?php echo htmlspecialchars($service['description']); ?>"
                            data-contact_number="<?php echo htmlspecialchars($service['contact_number']); ?>"
                            data-facebook_link="<?php echo htmlspecialchars($service['facebook_link']); ?>"
                            data-image_url="<?php echo htmlspecialchars($service['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_delivery&id=<?php echo $service['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this service?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="delivery-modal">
    <div class="modal-content">
        <h2 id="delivery-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Delivery Service</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/delivery_form.php'; ?>
    </div>
</div>