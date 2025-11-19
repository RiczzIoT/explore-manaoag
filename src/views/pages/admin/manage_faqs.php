<style>

    .admin-card-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
    }
    .admin-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    .admin-card-content {
        padding: 15px;
    }
    .admin-card-content h3 { margin-top: 0; color: #003366; font-size: 1.1em; }
    .admin-card-content p { font-size: 0.9em; color: #555; margin: 5px 0; }
    .admin-card-actions {
        padding: 10px 15px;
        background: #f9f9f9;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }
</style>

<h2>Manage FAQs</h2>

<button class="add-btn" id="show-faq-modal-btn">
    + Add New FAQ
</button>

<div class="admin-card-container">
    <?php if (empty($faqs)): ?>
        <p>No FAQs found.</p>
    <?php else: ?>
        <?php foreach ($faqs as $faq): ?>
            <div class="admin-card">
                <div class="admin-card-content">
                    <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($faq['category']); ?></p>
                    <p><?php echo substr(htmlspecialchars($faq['answer']), 0, 150); ?>...</p>
                </div>
                
                <div class="admin-card-actions">
                    <button class="action-btn edit-btn"
                            data-id="<?php echo $faq['id']; ?>"
                            data-question="<?php echo htmlspecialchars($faq['question']); ?>"
                            data-answer="<?php echo htmlspecialchars($faq['answer']); ?>"
                            data-category="<?php echo htmlspecialchars($faq['category']); ?>">
                        Edit
                    </button>
                    <a href="index.php?page=admin_delete_faq&id=<?php echo $faq['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this FAQ?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="modal-overlay" id="faq-modal">
    <div class="modal-content">
        <h2 id="faq-modal-title">Add New FAQ</h2>
        
        <form action="index.php?page=admin_process_faq" method="POST" class="admin-form">
            
            <input type="hidden" name="id" id="faq-id">

            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" id="faq-question" name="question" required>
            </div>

            <div class="form-group">
                <label for="answer">Answer</label>
                <textarea id="faq-answer" name="answer" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="faq-category" name="category" value="general" required>
                <small>e.g., general, parking, food, church</small>
            </div>
            
            <div class="form-actions">
                <button type="button" class="cancel-btn" id="cancel-faq-modal-btn">Cancel</button>
                <button type="submit" class="submit-btn">Save FAQ</button>
            </div>
        </form>
    </div>
</div>