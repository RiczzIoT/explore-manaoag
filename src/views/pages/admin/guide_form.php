<form action="index.php?page=admin_process_guide" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="guide-id" value="<?php echo $guide['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <div class="form-group">
                <label for="guide-name">Guide/Tour Name</label>
                <input type="text" id="guide-name" name="guide_name" 
                       value="<?php echo htmlspecialchars($guide['guide_name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="guide-specialization">Specialization</label>
                <input type="text" id="guide-specialization" name="specialization" 
                       value="<?php echo htmlspecialchars($guide['specialization'] ?? 'General Tour'); ?>">
                <small>e.g., General Tour, Food Tour, Historical Tour</small>
            </div>

            <div class="form-group">
                <label for="guide-contact_number">Contact Number</label>
                <input type="text" id="guide-contact_number" name="contact_number" 
                       value="<?php echo htmlspecialchars($guide['contact_number'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="guide-facebook_link">Facebook Link</label>
                <input type="text" id="guide-facebook_link" name="facebook_link" 
                       value="<?php echo htmlspecialchars($guide['facebook_link'] ?? ''); ?>">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Guide Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="guide-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($guide['image_url']) && $guide['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($guide['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <input type="file" id="guide_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="guide-current-image-url" value="<?php echo htmlspecialchars($guide['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="guide-description">Description</label>
                <textarea id="guide-description" name="description" style="height: 100px;"><?php echo htmlspecialchars($guide['description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-guide-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Guide</button>
    </div>
</form>

<script>
document.getElementById('guide_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('guide-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>