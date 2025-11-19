<form action="index.php?page=admin_process_spot" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="spot-id" value="<?php echo $spot['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div>
            <div class="form-group">
                <label for="spot-name">Spot Name</label>
                <input type="text" id="spot-name" name="name" 
                       value="<?php echo htmlspecialchars($spot['name'] ?? ''); ?>" required 
                       placeholder="e.g., Minor Basilica of Manaoag">
            </div>

            <div class="form-group">
                <label for="spot-category">Category</label>
                <select id="spot-category" name="category" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Religious">Religious</option>
                    <option value="Resort">Resort</option>
                    <option value="Nature">Nature</option>
                    <option value="Hotel">Hotel</option>
                    <option value="Restaurant">Restaurant</option>
                    <option value="Historical">Historical</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="spot-address">Address</label>
                <input type="text" id="spot-address" name="address" 
                       value="<?php echo htmlspecialchars($spot['address'] ?? ''); ?>"
                       placeholder="e.g., Milo St, Poblacion">
            </div>

            <div class="form-group">
                <label for="spot-gmap_link">Google Maps Link</label>
                <input type="text" id="spot-gmap_link" name="gmap_link" 
                       value="<?php echo htmlspecialchars($spot['gmap_link'] ?? ''); ?>"
                       placeholder="https://maps.google.com/...">
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Spot Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    
                    <div id="spot-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($spot['image_url']) && $spot['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($spot['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    
                    <input type="file" id="image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <small style="color: #777;">Recommended: Landscape orientation (High Quality)</small>
                    <input type="hidden" name="current_image_url" id="spot-current-image-url" value="<?php echo htmlspecialchars($spot['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="spot-description">Description</label>
                <textarea id="spot-description" name="description" required style="height: 120px;" 
                          placeholder="Describe the place..."><?php echo htmlspecialchars($spot['description'] ?? ''); ?></textarea>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-spot-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Spot</button>
    </div>
</form>

<script>
document.getElementById('image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('spot-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>