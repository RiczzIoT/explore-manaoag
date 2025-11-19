<form action="index.php?page=admin_process_delivery" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="delivery-id" value="<?php echo $delivery['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <div class="form-group">
                <label for="delivery-name">Service Name</label>
                <input type="text" id="delivery-name" name="name" 
                       value="<?php echo htmlspecialchars($delivery['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="delivery-contact_number">Contact Number</label>
                <input type="text" id="delivery-contact_number" name="contact_number" 
                       value="<?php echo htmlspecialchars($delivery['contact_number'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="delivery-facebook_link">Facebook Link</label>
                <input type="text" id="delivery-facebook_link" name="facebook_link" 
                       value="<?php echo htmlspecialchars($delivery['facebook_link'] ?? ''); ?>">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Service Logo/Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="delivery-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($delivery['image_url']) && $delivery['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($delivery['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <input type="file" id="delivery_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="delivery-current-image-url" value="<?php echo htmlspecialchars($delivery['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="delivery-description">Description</label>
                <textarea id="delivery-description" name="description" style="height: 100px;"><?php echo htmlspecialchars($delivery['description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-delivery-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Service</button>
    </div>
</form>

<script>
document.getElementById('delivery_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('delivery-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>