<h2>Manage Products & Delicacies</h2>

<div style="margin-bottom: 20px;">
    <button class="add-btn" id="show-product-modal-btn">
        <i class="fa fa-plus"></i> Add New Product
    </button>
</div>

<div class="admin-card-container">
    <?php if (empty($products)): ?>
        <p style="grid-column: 1/-1; text-align: center; color: #777; margin-top: 20px;">
            No products found. Click "Add New Product" to start.
        </p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="admin-card">
                <div style="position: relative; height: 200px; overflow: hidden; background: #eee;">
                    <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($product['image_url'] ?? 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>" 
                         class="admin-card-image"
                         style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <span style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 10px; border-radius: 4px; font-size: 0.8em; text-transform: uppercase;">
                        <?php echo htmlspecialchars($product['category']); ?>
                    </span>
                </div>
                
                <div class="admin-card-content">
                    <h3 style="font-size: 1.3em; margin-bottom: 5px;"><?php echo htmlspecialchars($product['name']); ?></h3>
                    
                    <p style="font-size: 0.9em; color: #555; line-height: 1.4;">
                        <?php echo substr(htmlspecialchars($product['description']), 0, 100); ?>...
                    </p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $product['id']; ?>"
                            data-name="<?php echo htmlspecialchars($product['name']); ?>"
                            data-description="<?php echo htmlspecialchars($product['description']); ?>"
                            data-category="<?php echo htmlspecialchars($product['category']); ?>"
                            data-image_url="<?php echo htmlspecialchars($product['image_url']); ?>">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    <a href="index.php?page=admin_delete_product&id=<?php echo $product['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this product?');">
                       <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="product-modal">
    <div class="modal-content">
        <h2 id="product-modal-title" style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Add New Product</h2>
        <?php include BASE_PATH . '/src/views/pages/admin/product_form.php'; ?>
    </div>
</div>