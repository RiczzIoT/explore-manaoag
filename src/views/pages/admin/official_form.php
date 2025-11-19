<form action="index.php?page=admin_process_official" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="official-id" value="<?php echo $official['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div>
            <div class="form-group">
                <label for="official-name">Full Name</label>
                <input type="text" id="official-name" name="name" 
                       value="<?php echo htmlspecialchars($official['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="official-position">Position</label>
                <select id="official-position" name="position" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="mayor">Mayor</option>
                    <option value="vice-mayor">Vice-Mayor</option>
                    <option value="councilor">Councilor</option>
                </select>
            </div>

            <div class="form-group">
                <label for="official-facebook-url">Facebook URL (Optional)</label>
                <input type="text" id="official-facebook-url" name="facebook_url" 
                       value="<?php echo htmlspecialchars($official['facebook_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="official-website-url">Website URL (Optional)</label>
                <input type="text" id="official-website-url" name="website_url" 
                       value="<?php echo htmlspecialchars($official['website_url'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="official-order">Display Order</label>
                <input type="number" id="official-order" name="order" 
                       value="<?php echo htmlspecialchars($official['order'] ?? '0'); ?>" required>
                <small style="color: #777;">(1 = First, 2 = Second, etc.)</small>
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Official's Photo</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="official-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($official['image_url']) && $official['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($official['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; object-position: top; border-radius: 4px;">
                    </div>
                    <input type="file" id="official_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="official-current-image-url" value="<?php echo htmlspecialchars($official['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="official-message">Message / Profile</label>
                <textarea id="official-message" name="message" style="height: 120px;"><?php echo htmlspecialchars($official['message'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-official-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Official</button>
    </div>
</form>

<script>
document.getElementById('official_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('official-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>