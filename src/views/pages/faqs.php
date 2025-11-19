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
</style>

<div class="spots-header">
    <h2>Frequently Asked Questions</h2>
</div>

<div class="container mx-auto max-w-3xl px-4 py-8">
    <div class="space-y-4">
        <?php if (empty($faqs)): ?>
            <p class="text-center text-gray-500">No FAQs available at the moment.</p>
        <?php else: ?>
            <?php foreach ($faqs as $faq): ?>
                <details class="bg-white shadow-md rounded-lg overflow-hidden group">
                    <summary class="flex justify-between items-center p-5 cursor-pointer list-none">
                        <span class="font-semibold text-gray-800"><?php echo htmlspecialchars($faq['question']); ?></span>
                        <span class="text-gray-400 group-open:rotate-45 transform transition-transform duration-200">
                            <i class="fa fa-plus"></i>
                        </span>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                    </div>
                </details>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>