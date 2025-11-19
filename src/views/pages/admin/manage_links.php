<h2>Manage Useful Links</h2>

<button class="add-btn" id="show-modal-btn">
    + Add New Link
</button>

<div class="admin-card-container">
    <?php if (empty($links)): ?>
        <p>No links found.</p>
    <?php else: ?>
        <?php foreach ($links as $link): ?>
            <div class="admin-card">
                <div>
                    <h3><?php echo htmlspecialchars($link['title']); ?></h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($link['category']); ?></p>
                    <p><strong>URL:</strong> <a href="<?php echo htmlspecialchars($link['url']); ?>" target="_blank"><?php echo htmlspecialchars($link['url']); ?></a></p>
                    <p><?php echo htmlspecialchars($link['description']); ?></p>
                </div>
                <div class="card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $link['id']; ?>"
                            data-title="<?php echo htmlspecialchars($link['title']); ?>"
                            data-url="<?php echo htmlspecialchars($link['url']); ?>"
                            data-description="<?php echo htmlspecialchars($link['description']); ?>"
                            data-category="<?php echo htmlspecialchars($link['category']); ?>">
                        Edit
                    </button>
                    <a href="index.php?page=admin_delete_link&id=<?php echo $link['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this link?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="link-modal">
    <div class="modal-content">
        <h2 id="modal-title">Add New Link</h2>
        
        <form action="index.php?page=admin_process_link" method="POST" class="admin-form">
            
            <input type="hidden" name="id" id="link-id">

            <div class="form-group">
                <label for="title">Link Title</label>
                <input type="text" id="link-title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="url">URL (Full link, e.g., https://...)</label>
                <input type="text" id="link-url" name="url" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="link-description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="link-category" name="category" value="general" required>
                <small>e.g., government, emergency, general</small>
            </div>

            <div class="form-actions">
                <button type="button" class="cancel-btn" id="cancel-modal-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save Link</button>
            </div>
        </form>
    </div>
</div>