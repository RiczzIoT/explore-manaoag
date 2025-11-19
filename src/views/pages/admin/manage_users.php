<style>
    .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.9em; }
    .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    .admin-table th { background-color: #f4f4f4; }
    .admin-table tr:nth-child(even) { background-color: #f9f9f9; }
</style>

<h2>Manage Registered Users (Tourists)</h2>

<table class="admin-table">
    <thead>
        <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($users)): ?>
            <tr>
                <td colspan="4">No registered users found.</td> </tr>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td>
                        <a href="index.php?page=admin_delete_user&id=<?php echo $user['id']; ?>" 
                           class="action-btn delete-btn" 
                           onclick="return confirm('Are you sure you want to delete this user? This may affect their saved favorites and feedback.');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>