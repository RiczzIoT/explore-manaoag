<?php
$name = $official['name'] ?? 'HON. [Mayor’s Name]';
$message = $official['message'] ?? 'Message from the Mayor...';
$fb_link = $official['facebook_url'] ?? '#';
$web_link = $official['website_url'] ?? '#';
$image = $official['image_url'] ?? 'default.png';
?>

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
</style>

<div class="page-header">
    <h2 class="uppercase tracking-wider">The Municipal Mayor</h2>
</div>

<div class="container mx-auto max-w-5xl px-4 py-16">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden md:flex">
        
        <div class="md:w-2/5 p-8 bg-gray-50 flex flex-col items-center justify-center">
            <div class="w-64 h-64 rounded-lg overflow-hidden shadow-lg mb-6">
                <img class="w-full h-full object-cover" 
                     src="<?php echo BASE_URL; ?>/images/<?php echo htmlspecialchars($image); ?>" 
                     alt="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="flex space-x-4 w-full max-w-xs">
                <a href="<?php echo htmlspecialchars($fb_link); ?>" 
                   target="_blank" 
                   class="flex-1 flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition">
                    <i class="fab fa-facebook-f mr-2"></i> Facebook
                </a>
                <a href="<?php echo htmlspecialchars($web_link); ?>" 
                   target="_blank" 
                   class="flex-1 flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-md font-semibold hover:bg-gray-700 transition">
                    <i class="fas fa-globe mr-2"></i> Website
                </a>
            </div>
        </div>
        
        <div class="md:w-3/5 p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-5">Message from the Mayor</h2>
            <div class="prose prose-lg text-gray-600 leading-relaxed">
                <p><?php echo nl2br(htmlspecialchars($message)); ?></p>
            </div>
            <div class="mt-10 border-t border-gray-200 pt-6">
                <h3 class="text-2xl font-bold text-gray-800"><?php echo htmlspecialchars($name); ?></h3>
                <p class="text-lg text-gray-500"><em>Municipal Mayor</em></p>
            </div>
        </div>

    </div>
</div>