<style>
    .logs { 
        background: #f1f1f1; 
        border: 1px solid #ddd; 
        padding: 15px; 
        margin-top: 20px; 
        border-radius: 5px; 
        max-height: 200px; 
        overflow-y: auto; 
        font-family: monospace; 
        font-size: 0.9em;
    }
</style>

<h2>Send Push Notification</h2>
<p>This will send a notification to ALL subscribed users.</p>

<div class="admin-form" style="max-width: 700px;">
    <form action="index.php?page=admin_process_notification" method="POST">
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="Explore Manaoag" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required placeholder="e.g., The Manaoag Town Fiesta is starting soon!"></textarea>
        </div>

        <button type="submit" class="submit-btn" style="background-color: #007bff;">Send Notification to All Users</button>
    </form>
</div>

<?php
if (isset($_SESSION['notification_results'])):
    $results = $_SESSION['notification_results'];
    unset($_SESSION['notification_results']); 
?>
    <div class="logs">
        <strong>Send Results:</strong>
        <pre><?php print_r($results); ?></pre>
    </div>
<?php endif; ?>