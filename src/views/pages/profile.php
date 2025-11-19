<style>
.page-header {
    text-align: center;
    background-color: #003366;
    color: white;
    padding: 40px 20px;
    margin-bottom: 40px;
}
.page-header h2 {
    font-size: 3em;
    font-weight: 900;
}
.page-header p {
    font-size: 1.2em;
    color: #eee;
    margin-top: 10px;
}

.profile-container {
    max-width: 1000px;
    margin: 30px auto; 
    padding: 0 20px 40px;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 30px;
}

.profile-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 25px;
}
.profile-card h3 {
    font-size: 1.5em;
    color: #003366;
    margin-top: 0;
    margin-bottom: 15px;
    border-bottom: 2px solid #f0f2f5;
    padding-bottom: 10px;
}
.profile-card p {
    font-size: 1em;
    color: #333;
    line-height: 1.6;
}
.profile-card p strong {
    color: #000;
}

.logout-btn { 
    display: inline-block;
    width: 100%;
    text-align: center;
    background-color: #dc3545; 
    color: white; 
    padding: 12px 20px; 
    border-radius: 5px; 
    border: none; 
    cursor: pointer; 
    text-decoration: none;
    font-weight: bold;
    margin-top: 10px;
    transition: background-color 0.3s;
}
.logout-btn:hover {
    background-color: #c82333;
}

.favorites-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 25px;
}
.favorites-container h3 {
    font-size: 1.5em;
    color: #003366;
    margin-top: 0;
    margin-bottom: 20px;
    border-bottom: 2px solid #f0f2f5;
    padding-bottom: 10px;
}
.favorites-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.profile-fav-card { 
    display: flex; 
    background: #f9f9f9; 
    border: 1px solid #eee;
    border-radius: 8px; 
    overflow: hidden; 
}
.profile-fav-card img { 
    width: 150px; 
    height: 100px; 
    object-fit: cover; 
}
.profile-fav-card-content { 
    padding: 15px; 
    flex-grow: 1; 
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.profile-fav-card-content h4 { 
    font-size: 1.1em; 
    color: #003366; 
    margin: 0 0 5px 0;
}
.profile-fav-card-content .category { 
    font-size: 0.8em; 
    color: #777; 
    text-transform: capitalize; 
    font-weight: bold; 
}
.profile-fav-card-content .delete-btn { 
    background-color: #dc3545; 
    color: white; 
    padding: 5px 10px; 
    border-radius: 4px; 
    border: none; 
    cursor: pointer; 
    font-size: 0.9em;
}

.admin-form .form-group { margin-bottom: 15px; }
.admin-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.admin-form .form-group input, 
.admin-form .form-group textarea, 
.admin-form .form-group select { 
    width: 100%; 
    padding: 10px; 
    border: 1px solid #ccc; 
    border-radius: 4px; 
    font-size: 1em; 
    box-sizing: border-box;
}
.admin-form .form-group textarea { min-height: 100px; resize: vertical; }
.submit-btn { 
    background-color: #28a745; 
    color: white; 
    padding: 12px 20px; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer; 
    font-size: 1em; 
    font-weight: bold; 
    width: 100%;
}

@media (max-width: 768px) {
    .profile-container {
        grid-template-columns: 1fr;
    }
    .profile-fav-card img {
        width: 100px;
        height: 70px;
    }
    .profile-fav-card-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<div class="page-header">
    <h2>Welcome, <?php echo htmlspecialchars(explode(' ', $user['name'])[0]); ?>!</h2>
    <p>This is your personal profile page.</p>
</div>

<div class="profile-container">
    
    <div class="profile-sidebar">
        <div class="profile-card">
            <h3>Your Profile</h3>
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <a href="index.php?page=user_logout" class="logout-btn">Log Out</a>
        </div>

        <div id="feedback" class="profile-card" style="margin-top: 30px;">
            <h3>Leave General Feedback</h3>
            <p style="font-size: 0.9em; margin-bottom: 15px;">We would love to hear your thoughts about your experience!</p>

            <?php if (isset($_GET['feedback']) && $_GET['feedback'] == 'success'): ?>
                <p style="color: green; background: #d4edda; padding: 10px; border-radius: 5px;">
                    Thank you for your feedback! It has been submitted for review.
                </p>
            <?php endif; ?>

            <form action="index.php?page=submit_feedback" method="POST" class="admin-form" style="padding: 0; box-shadow: none;">
                <input type="hidden" name="item_type" value="general">
                
                <div class="form-group">
                    <label for="rating">Your Rating</label>
                    <select name="rating" id="rating">
                        <option value="5">5 Stars (Excellent)</option>
                        <option value="4">4 Stars (Good)</option>
                        <option value="3" selected>3 Stars (Average)</option>
                        <option value="2">2 Stars (Poor)</option>
                        <option value="1">1 Star (Terrible)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Your Comment</label>
                    <textarea name="comment" id="comment" rows="4" placeholder="Tell us what you think..."></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit Feedback</button>
            </form>
        </div>
    </div>

    <div id="favorites" class="favorites-container">
        <h3>Your Saved Favorites</h3>
        
        <?php if (empty($favorites)): ?>
            <p>You have no saved items. Start exploring and click the <i class="fa-regular fa-bookmark"></i> icon to save items to your profile!</p>
        <?php else: ?>
            <div class="favorites-grid">
                <?php foreach ($favorites as $item): ?>
                    <div class="profile-fav-card" id="fav-<?php echo $item['type']; ?>-<?php echo $item['id']; ?>">
                        <img src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($item['image_url'] ?? 'default.png'); ?>" 
                             alt="<?php echo htmlspecialchars($item['name']); ?>">
                        
                        <div class="profile-fav-card-content">
                            <div>
                                <p class="category"><?php echo htmlspecialchars($item['type']); ?></p>
                                <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                            </div>
                            
                            <form action="index.php?page=toggle_favorite" method="POST">
                                <input type="hidden" name="item_type" value="<?php echo $item['type']; ?>">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="delete-btn">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>