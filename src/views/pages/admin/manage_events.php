<h2>Manage Events & Festivals</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-event-modal-btn">
        <i class="fa fa-plus"></i> Add New Event
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($events)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No events found. Click "Add New Event" to start.
        </p>
    <?php else: ?>
        <?php foreach ($events as $event): ?>
            <div class="admin-card">
                <div style="position: relative; height: 180px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($event['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($event['event_name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.2em; margin-bottom: 5px;"><?php echo htmlspecialchars($event['event_name']); ?></h3>
                    
                    <p style="font-size: 0.9em; color: #007bff; font-weight: bold; margin-bottom: 5px;">
                        <i class="fa fa-calendar"></i> 
                        <?php echo date('M j, Y', strtotime($event['start_date'])); ?>
                    </p>
                    <p style="font-size: 0.9em; color: #666; margin-bottom: 10px;">
                        <i class="fa fa-map-pin"></i> <?php echo htmlspecialchars($event['location']); ?>
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $event['id']; ?>"
                            data-event_name="<?php echo htmlspecialchars($event['event_name']); ?>"
                            data-description="<?php echo htmlspecialchars($event['description']); ?>"
                            data-start_date="<?php echo htmlspecialchars($event['start_date']); ?>"
                            data-end_date="<?php echo htmlspecialchars($event['end_date']); ?>"
                            data-location="<?php echo htmlspecialchars($event['location']); ?>"
                            data-image_url="<?php echo htmlspecialchars($event['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_event&id=<?php echo $event['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this event?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="event-modal">
    <div class="modal-content">
        <h2 id="event-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Event</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/event_form.php'; ?>
    </div>
</div>