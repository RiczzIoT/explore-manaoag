<style>
    .admin-form { max-width: 700px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .admin-form .form-group { margin-bottom: 15px; }
    .admin-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .admin-form .form-group input, .admin-form .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }
    .admin-form .form-group textarea { min-height: 100px; resize: vertical; }
    .form-actions { margin-top: 20px; display: flex; justify-content: space-between; align-items: center; }
    .submit-btn { background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; font-weight: bold; }
    .cancel-btn { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
</style>

<h2><?php echo $pageTitle; ?></h2>

<form action="index.php?page=admin_process_link" method="POST" class="admin-form">
    
    <?php if (isset($link['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $link['id']; ?>">
    <?php endif; ?>

    <div class="form-group">
        <label for="title">Link Title</label>
        <input type="text" id="title" name="title" 
               value="<?php echo htmlspecialchars($link['title'] ?? ''); ?>" required>
    </div>
    
    <div class="form-group">
        <label for="url">URL (Full link, e.g., https://...)</label>
        <input type="text" id="url" name="url" 
               value="<?php echo htmlspecialchars($link['url'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($link['description'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" id="category" name="category" 
               value="<?php echo htmlspecialchars($link['category'] ?? 'general'); ?>" required>
        <small>e.g., government, emergency, general</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="submit-btn">Save Link</button>
        <a href="index.php?page=admin_manage_links" class="cancel-btn">Cancel</a>
    </div>
</form>