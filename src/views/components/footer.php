</main> <div class="chat-bubble" id="chat-bubble">
    <i class="fa fa-comments"></i>
</div>

<div class="chat-window" id="chat-window">
    <div class="chat-header">
        <strong>Explore Manaoag Bot</strong>
        <button class="chat-close" id="chat-close">&times;</button>
    </div>
    <div class="chat-body" id="chat-body">
        <div class="chat-message bot">
            Hello! I am the Explore Manaoag virtual assistant. How can I help you?
        </div>
        
        <div class="chat-suggestions" id="chat-suggestions">
            <button class="suggestion-btn" data-message="Where can I find parking?">Where can I find parking?</button>
            <button class="suggestion-btn" data-message="What are the local products?">What are the local products?</button>
            <button class="suggestion-btn" data-message="Are there any events?">Are there any events?</button>
        </div>
        </div>
    <div class="chat-footer">
        <input type="text" id="chat-input" placeholder="Ask a question...">
        <button id="chat-send">Send</button>
    </div>
</div>
<footer class="bg-gray-800 text-gray-400 mt-auto py-8 flex-shrink-0">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>
            &copy; 
            <?php echo date('Y'); ?> Municipality of Manaoag. All rights reserved.
        </p>
    </div>
</footer>

<script src="<?php echo BASE_URL; ?>/js/main.js"></script>

</body>
</html>