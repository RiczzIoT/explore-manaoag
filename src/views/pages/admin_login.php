<style>
/* Kinuha ko yung styles galing sa user_login para maganda na rin */
.auth-form { max-width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.auth-form h2 { text-align: center; color: #003366; margin-bottom: 20px; }
.auth-form .form-group { margin-bottom: 15px; }
.auth-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.auth-form .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; }
.auth-btn { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em; font-weight: bold; }
.auth-btn:hover { background-color: #0056b3; }
.auth-message { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>

<div class="auth-form">
    <h2>Admin Login</h2>
    <p style="text-align: center; margin-top: -15px; margin-bottom: 15px; color: #555;">This is for authorized personnel only.</p>
    
    <?php if (isset($this_Message)): ?>
        <div class="auth-message error">
            <?php echo htmlspecialchars($this_Message); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=login" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required 
                   style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required 
                   style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <button type="submit" class="auth-btn">Log In</button>
    </form>
</div>