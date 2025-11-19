<style>

    .admin-form .image-preview { margin-top: 10px; }
    .admin-form .image-preview img { width: 200px; height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; }
    
    .live-status-form {
        background: #fff8e1;
        border: 1px solid #ffecb3;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }
    .live-status-form .form-group { margin-bottom: 10px; }
    .live-status-form .form-group label { font-size: 1.2em; font-weight: bold; color: #c0392b; }
    .live-status-form small { color: #555; }
    .submit-btn.live { background-color: #c0392b; }
</style>

<h2>Manage Home Page Content</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        Content updated successfully!
    </p>
<?php endif; ?>

<form action="index.php?page=admin_process_content" method="POST" class="admin-form live-status-form">
    <div class="form-group">
        <label for="live_url">Facebook Live URL</label>
        <input type="text" id="live_url" name="live_url" 
               value="<?php echo htmlspecialchars($content['live_url'] ?? ''); ?>" 
               placeholder="Ilagay ang FB Live URL dito...">
        <small>
            Ilagay ang URL dito para lumabas ang "LIVE" button. 
            <strong>Burahin ang text at i-save para itago ang button.</strong>
        </small>
    </div>
    
    <input type="hidden" name="hero_title" value="<?php echo htmlspecialchars($content['hero_title'] ?? ''); ?>">
    <input type="hidden" name="current_hero_image_url" value="<?php echo htmlspecialchars($content['hero_image_url'] ?? ''); ?>">
    <input type="hidden" name="history_title" value="<?php echo htmlspecialchars($content['history_title'] ?? ''); ?>">
    <input type="hidden" name="history_content" value="<?php echo htmlspecialchars($content['history_content'] ?? ''); ?>">
    <input type="hidden" name="current_history_image_url" value="<?php echo htmlspecialchars($content['history_image_url'] ?? ''); ?>">
    
    <button type="submit" class="submit-btn live">Update Live Status</button>
</form>
<form action="index.php?page=admin_process_content" method="POST" class="admin-form" enctype="multipart/form-data" style="max-width: 900px;">
    
    <input type="hidden" name="live_url" value="<?php echo htmlspecialchars($content['live_url'] ?? ''); ?>">

    <div class="form-group">
        <label for="hero_title">Hero Title (e.g., Welcome to Manaoag)</label>
        <input type="text" id="hero_title" name="hero_title" 
               value="<?php echo htmlspecialchars($content['hero_title'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="hero_image_file">Hero Background Image</label>
        <input type="file" id="hero_image_file" name="hero_image_file" accept="image/jpeg, image/png, image/gif">
        <input type="hidden" name="current_hero_image_url" value="<?php echo htmlspecialchars($content['hero_image_url'] ?? ''); ?>">
        <?php if (isset($content['hero_image_url'])): ?>
            <div class="image-preview">
                <p>Current Image:</p>
                <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($content['hero_image_url']); ?>" alt="Current Image">
            </div>
        <?php endif; ?>
    </div>

    <hr style="margin: 30px 0;">

    <div class="form-group">
        <label for="history_title">History Section Title</label>
        <input type="text" id="history_title" name="history_title" 
               value="<?php echo htmlspecialchars($content['history_title'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="history_content">History Content</label>
        <textarea id="history_content" name="history_content" required><?php echo htmlspecialchars($content['history_content'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label for="history_image_file">History Image</label>
        <input type="file" id="history_image_file" name="history_image_file" accept="image/jpeg, image/png, image/gif">
        <input type="hidden" name="current_history_image_url" value="<?php echo htmlspecialchars($content['history_image_url'] ?? ''); ?>">
        <?php if (isset($content['history_image_url'])): ?>
            <div class="image-preview">
                <p>Current Image:</p>
                <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($content['history_image_url']); ?>" alt="Current Image">
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="submit-btn">Save Page Content</button>
</form>