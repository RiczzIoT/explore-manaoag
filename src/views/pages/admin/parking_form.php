<form action="index.php?page=admin_process_parking" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="parking-id" value="<?php echo $parking['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div>
            <div class="form-group">
                <label for="parking-name">Parking Area Name</label>
                <input type="text" id="parking-name" name="name" 
                       value="<?php echo htmlspecialchars($parking['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="parking-address">Address</label>
                <input type="text" id="parking-address" name="address" 
                       value="<?php echo htmlspecialchars($parking['address'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="parking-fees">Parking Fees</label>
                <input type="text" id="parking-fees" name="fees" 
                       value="<?php echo htmlspecialchars($parking['fees'] ?? 'Varies'); ?>">
            </div>

            <div class="form-group">
                <label for="parking-operating_hours">Operating Hours</label>
                <input type="text" id="parking-operating_hours" name="operating_hours" 
                       value="<?php echo htmlspecialchars($parking['operating_hours'] ?? '24/7'); ?>">
            </div>

            <div class="form-group">
                <label for="parking-gmap_link">Google Maps Link</label>
                <input type="text" id="parking-gmap_link" name="gmap_link" 
                       value="<?php echo htmlspecialchars($parking['gmap_link'] ?? ''); ?>">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="parking-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($parking['image_url']) && $parking['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($parking['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <input type="file" id="parking_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="parking-current-image-url" value="<?php echo htmlspecialchars($parking['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="parking-description">Description</label>
                <textarea id="parking-description" name="description" style="height: 100px;"><?php echo htmlspecialchars($parking['description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-parking-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Parking Area</button>
    </div>
</form>

<script>
document.getElementById('parking_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('parking-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>