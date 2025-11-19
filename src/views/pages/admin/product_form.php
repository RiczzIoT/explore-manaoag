<form action="index.php?page=admin_process_product" method="POST" class="admin-form" enctype="multipart/form-data">
    
    <input type="hidden" name="id" id="product-id" value="<?php echo $product['id'] ?? ''; ?>">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <div>
            <div class="form-group">
                <label for="product-name">Product Name</label>
                <input type="text" id="product-name" name="name" 
                       value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="product-category">Category</label>
                <select id="product-category" name="category" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="Food">Food</option>
                    <option value="Delicacy">Delicacy</option>
                    <option value="Handicraft">Handicraft</option>
                    <option value="Souvenir">Souvenir</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="product-description">Description</label>
                <textarea id="product-description" name="description" required style="height: 100px;"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>
        </div>

        <div>
            <div class="form-group">
                <label>Product Image</label>
                <div style="border: 2px dashed #ccc; padding: 10px; text-align: center; border-radius: 8px; background: #f9f9f9;">
                    <div id="product-image-preview" style="margin-bottom: 10px; display: <?php echo (isset($product['image_url']) && $product['image_url'] != 'default.png') ? 'block' : 'none'; ?>;">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($product['image_url'] ?? ''); ?>" 
                             alt="Preview" 
                             style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <input type="file" id="product_image_file" name="image_file" accept="image/*" style="width: 100%;">
                    <input type="hidden" name="current_image_url" id="product-current-image-url" value="<?php echo htmlspecialchars($product['image_url'] ?? 'default.png'); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;">
        <button type="button" class="cancel-btn" id="cancel-product-modal-btn">Cancel</button>
        <button type="submit" class="submit-btn">Save Product</button>
    </div>
</form>

<script>
document.getElementById('product_image_file').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        const previewDiv = document.getElementById('product-image-preview');
        const img = previewDiv.querySelector('img');
        img.src = URL.createObjectURL(file);
        previewDiv.style.display = 'block';
    }
});
</script>