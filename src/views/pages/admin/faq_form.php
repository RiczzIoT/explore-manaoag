<style>
    .admin-form { max-width: 700px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .admin-form .form-group { margin-bottom: 15px; }
    .admin-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .admin-form .form-group input, .admin-form .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }
    .admin-form .form-group textarea { min-height: 150px; resize: vertical; }
    .form-actions { margin-top: 20px; display: flex; justify-content: space-between; align-items: center; }
    .submit-btn { background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; font-weight: bold; }
    .cancel-btn { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
</style>

<h2><?php echo $pageTitle; ?></h2>

<form action="index.php?page=admin_process_faq" method="POST" class="admin-form">
    
    <?php if (isset($faq['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $faq['id']; ?>">
    <?php endif; ?>

    <div class="form-group">
        <label for="question">Question</label>
        <input type="text" id="question" name="question" 
               value="<?php echo htmlspecialchars($faq['question'] ?? ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="answer">Answer</label>
        <textarea id="answer" name="answer" required><?php echo htmlspecialchars($faq['answer'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" id="category" name="category" 
               value="<?php echo htmlspecialchars($faq['category'] ?? 'general'); ?>" required>
        <small>e.g., general, parking, food, church</small>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="submit-btn">Save FAQ</button>
        <a href="index.php?page=admin_manage_faqs" class="cancel-btn">Cancel</a>
    </div>
</form>