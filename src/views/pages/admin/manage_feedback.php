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
    .admin-card.pending {
        border-left: 5px solid #ffc107;
    }
    .admin-card.approved {
        border-left: 5px solid #28a745;
    }
    .admin-card-content {
        padding: 15px;
    }
    .admin-card-content h3 { 
        margin-top: 0; 
        color: #003366; 
        font-size: 1.1em;
        margin-bottom: 10px;
    }
    .admin-card-content .stars { color: #f0c100; font-size: 1.2em; }
    .admin-card-content p { font-size: 1em; color: #333; margin: 10px 0; }
    .admin-card-content .meta { font-size: 0.9em; color: #777; }
    
    .admin-card-actions {
        padding: 10px 15px;
        background: #f9f9f9;
        border-top: 1px solid #eee;
        display: flex;
        gap: 10px;
    }
    .approve-btn { background-color: #28a745; }
</style>

<h2>Manage Feedback & Reviews</h2>

<div class="admin-card-container">
    <?php if (empty($feedback)): ?>
        <p>No feedback found.</p>
    <?php else: ?>
        <?php foreach ($feedback as $item): ?>
            <div classclass="admin-card <?php echo $item['is_approved'] ? 'approved' : 'pending'; ?>">
                <div class="admin-card-content">
                    <span class="stars">
                        <?php for ($i = 0; $i < $item['rating']; $i++) echo '★'; ?>
                        <?php for ($i = $item['rating']; $i < 5; $i++) echo '☆'; ?>
                        <span style="font-size: 0.8em; color: #555;">(<?php echo $item['rating']; ?>/5 Stars)</span>
                    </span>
                    
                    <p>"<?php echo htmlspecialchars($item['comment']); ?>"</p>
                    
                    <span class="meta">
                        By: <strong><?php echo htmlspecialchars($item['user_name']); ?></strong> 
                        on <?php echo htmlspecialchars(date('M j, Y', strtotime($item['created_at']))); ?> | 
                        Item: <?php echo htmlspecialchars($item['item_type'] . ' (ID: ' . $item['item_id'] . ')'); ?>
                    </span>
                </div>
                
                <div class="admin-card-actions">
                    <?php if (!$item['is_approved']): ?>
                        <a href="index.php?page=admin_approve_feedback&id=<?php echo $item['id']; ?>" class="action-btn approve-btn">Approve</a>
                    <?php endif; ?>
                    <a href="index.php?page=admin_delete_feedback&id=<?php echo $item['id']; ?>" 
                       class="action-btn delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>