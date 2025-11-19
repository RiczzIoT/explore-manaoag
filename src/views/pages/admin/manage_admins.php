<style>
    .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9em; }
    .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .admin-table th { background-color: #f4f4f4; }
    .admin-table tr:nth-child(even) { background-color: #f9f9f9; }
    
    .form-message { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
    .error { background-color: #f8d7da; color: #721c24; }
    .success { background-color: #d4edda; color: #155724; }
</style>

<h2>Manage Admin Accounts</h2>

<?php if (isset($_SESSION['admin_form_message'])): ?>
    <div class="form-message <?php echo $_SESSION['admin_form_message_type']; ?>">
        <?php 
            echo $_SESSION['admin_form_message']; 
            unset($_SESSION['admin_form_message']);
            unset($_SESSION['admin_form_message_type']);
        ?>
    </div>
<?php endif; ?>

<button class="add-btn" id="show-admin-modal-btn">
    + Add New Admin
</button>

<h3>Admin List</h3>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($admins)): ?>
            <tr>
                <td colspan="4">No other admin accounts found.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo htmlspecialchars($admin['id']); ?></td>
                    <td><?php echo htmlspecialchars($admin['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                    <td>
                        <a href="index.php?page=admin_delete_admin&id=<?php echo $admin['id']; ?>" 
                           class="action-btn delete-btn" 
                           onclick="return confirm('Are you sure you want to delete this admin account?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="modal-overlay" id="admin-modal">
    <div class="modal-content">
        <h2>Add New Admin</h2>
        
        <form action="index.php?page=admin_add_admin" method="POST" class="admin-form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-actions">
                <button type="button" class="cancel-btn" id="cancel-admin-modal-btn">Cancel</button>
                <button type="submit" class="submit-btn">Create Admin</button>
            </div>
        </form>
    </div>
</div>