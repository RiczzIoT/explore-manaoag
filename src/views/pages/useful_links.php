<style>
.spots-header {
    text-align: center;
    background-color: #003366;
    color: white;
    padding: 40px 20px;
    margin-bottom: 40px;
}
.spots-header h2 {
    font-size: 3em;
    font-weight: 900;
}
.links-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}
.link-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    padding: 20px;
    transition: box-shadow 0.3s;
}
.link-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.link-card h3 {
    font-size: 1.7em;
    color: #003366;
    margin-bottom: 10px;
}
.link-card p {
    font-size: 1em;
    line-height: 1.6;
    color: #555;
    margin-bottom: 15px;
}
.link-card .category {
    font-size: 0.9em;
    color: #777;
    margin-bottom: 15px;
    font-style: italic;
    text-transform: capitalize;
}
.visit-link-btn {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    text-align: center;
    transition: background-color 0.3s;
}
.visit-link-btn:hover {
    background-color: #0056b3;
}

.iframe-page-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 10px 10px 20px;
}
.iframe-container {
    position: relative;
    width: 100%;
    height: 92vh;
    border: 1px solid #ddd;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 0 auto 20px;
}
.iframe-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
.back-to-links {
    display: inline-block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #007bff;
    text-decoration: none;
    font-size: 1.1em;
}
.back-to-links:hover {
    text-decoration: underline;
}
</style>

<?php 
if (isset($_GET['view_url'])): 
    $url_to_view = htmlspecialchars(urldecode($_GET['view_url']));
?>
    <div class="iframe-page-container">
        <a href="index.php?page=useful_links" class="back-to-links">&larr; Back to all links</a>
        
        <div class="iframe-container">
            <iframe src="<?php echo $url_to_view; ?>" 
                    title="External Website"
                    sandbox="allow-scripts allow-same-origin allow-popups allow-forms">
            </iframe>
        </div>
        
        </div>

<?php else: ?>
    <div class="spots-header">
        <h2>Useful Links</h2>
    </div>

    <div class="links-container">
        <?php if (empty($links)): ?>
            <p style="font-size: 1.2em; text-align: center; color: #777;">No useful links available at the moment.</p>
        <?php else: ?>
            <?php foreach ($links as $link): ?>
                <div class="link-card" id="link-<?php echo $link['id']; ?>">
                    <h3><?php echo htmlspecialchars($link['title']); ?></h3>
                    <p class="category">Category: <?php echo htmlspecialchars($link['category']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($link['description'])); ?></p>
                    
                    <a href="index.php?page=useful_links&view_url=<?php echo urlencode($link['url']); ?>" 
                       class="visit-link-btn">
                       Visit Website (Inside App)
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>