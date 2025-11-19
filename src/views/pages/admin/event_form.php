<form action="index.php?page=admin_process_event" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="event-id" value="<?php echo $event['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div>
            <div class="form-group">
                <label for="event-name">Event Name</label>
                <input type="text" id="event-name" name="event_name" 
                       value="<?php echo htmlspecialchars($event['event_name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-start_date">Start Date & Time</label>
                <input type="datetime-local" id="event-start_date" name="start_date" 
                       value="<?php echo htmlspecialchars($event['start_date'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="event-end_date">End Date & Time (Optional)</label>
                <input type="datetime-local" id="event-end_date" name="end_date" 
                       value="<?php echo htmlspecialchars($event['end_date'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="event-location">Location</label>
                <input type="text" id="event-location" name="location" 
                       value="<?php echo htmlspecialchars($event['location'] ?? ''); ?>">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Event Poster/Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="event-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($event['image_url']) && $event['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($event['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <input type="file" id="event_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="event-current-image-url" value="<?php echo htmlspecialchars($event['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="event-description">Description</label>
                <textarea id="event-description" name="description" required style="height: 100px;"><?php echo htmlspecialchars($event['description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-event-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Event</button>
    </div>
</form>

<script>
document.getElementById('event_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('event-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>