<style>
.auth-form { max-width: 400px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.auth-form h2 { text-align: center; color: #003366; margin-bottom: 20px; }
.auth-form .form-group { margin-bottom: 15px; }
.auth-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.auth-form .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; }
.auth-btn { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em; font-weight: bold; }
.auth-btn:hover { background-color: #218838; }
.auth-link { text-align: center; margin-top: 15px; }
.auth-link a { color: #007bff; text-decoration: none; }
.auth-message { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; }
.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>

<div class="auth-form">
    <h2>Tourist Registration</h2>

    <?php if (isset($message)): ?>
        <div class="auth-message <?php echo ($messageType ?? 'error'); ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=user_register_process" method="POST">
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
        <button type="submit" class="auth-btn">Register</button>
    </form>
    <div class="auth-link">
        <p>Already have an account? <a href="index.php?page=user_login">Login here</a></p>
    </div>
</div>