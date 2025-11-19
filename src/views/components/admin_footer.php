</main> 

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const baseImgPath = '<?php echo BASE_URL; ?>/images/';

    
    function initializeModal(modalId, addBtnId, cancelBtnId, editBtnSelector, resetFormCallback, fillFormCallback) {
        const modal = document.getElementById(modalId);
        if (!modal) return; 

        const showModalBtn = document.getElementById(addBtnId);
        const cancelModalBtn = document.getElementById(cancelBtnId);
        
        const openModal = () => { modal.style.display = 'flex'; };
        const closeModal = () => { modal.style.display = 'none'; };

        if (showModalBtn) {
            showModalBtn.addEventListener('click', () => {
                if(resetFormCallback) resetFormCallback();
                openModal();
            });
        }
        
        if (cancelModalBtn) {
            cancelModalBtn.addEventListener('click', closeModal);
        }
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) { 
                closeModal();
            }
        });

        
        if(editBtnSelector && fillFormCallback) {
            const editButtons = document.querySelectorAll(editBtnSelector);
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    fillFormCallback(button.dataset);
                    openModal();
                });
            });
        }
    }

    
    initializeModal(
        'link-modal', 
        'show-modal-btn', 
        'cancel-modal-btn',
        '.edit-btn[data-title]',
        () => { 
            document.getElementById('modal-title').innerText = 'Add New Link';
            document.getElementById('link-id').value = '';
            document.getElementById('link-title').value = '';
            document.getElementById('link-url').value = '';
            document.getElementById('link-description').value = '';
            document.getElementById('link-category').value = 'general';
        },
        (data) => { 
            document.getElementById('modal-title').innerText = 'Edit Link';
            document.getElementById('link-id').value = data.id;
            document.getElementById('link-title').value = data.title;
            document.getElementById('link-url').value = data.url;
            document.getElementById('link-description').value = data.description;
            document.getElementById('link-category').value = data.category;
        }
    );

    
    initializeModal(
        'official-modal', 
        'show-official-modal-btn', 
        'cancel-official-modal-btn',
        '.edit-btn[data-name]', 
        () => { 
            document.getElementById('official-modal-title').innerText = 'Add New Official';
            document.getElementById('official-id').value = '';
            document.getElementById('official-name').value = '';
            document.getElementById('official-position').value = 'councilor';
            document.getElementById('official-message').value = '';
            document.getElementById('official-current-image-url').value = 'default.png';
            document.getElementById('official-image-preview').style.display = 'none';
            document.getElementById('official-facebook-url').value = '';
            document.getElementById('official-website-url').value = '';
            document.getElementById('official-order').value = '0';
        },
        (data) => { 
            document.getElementById('official-modal-title').innerText = 'Edit Official';
            document.getElementById('official-id').value = data.id;
            document.getElementById('official-name').value = data.name;
            document.getElementById('official-position').value = data.position;
            document.getElementById('official-message').value = data.message;
            document.getElementById('official-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('official-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
            
            document.getElementById('official-facebook-url').value = data.facebook_url;
            document.getElementById('official-website-url').value = data.website_url;
            document.getElementById('official-order').value = data.order;
        }
    );

    
    initializeModal(
        'spot-modal', 
        'show-spot-modal-btn', 
        'cancel-spot-modal-btn',
        '.edit-btn[data-description]', 
        () => { 
            document.getElementById('spot-modal-title').innerText = 'Add New Spot';
            document.getElementById('spot-id').value = '';
            document.getElementById('spot-name').value = '';
            document.getElementById('spot-description').value = '';
            document.getElementById('spot-category').value = 'general';
            document.getElementById('spot-address').value = '';
            document.getElementById('spot-gmap_link').value = '';
            document.getElementById('spot-current-image-url').value = 'default.png';
            document.getElementById('spot-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('spot-modal-title').innerText = 'Edit Spot';
            document.getElementById('spot-id').value = data.id;
            document.getElementById('spot-name').value = data.name;
            document.getElementById('spot-description').value = data.description;
            document.getElementById('spot-category').value = data.category;
            document.getElementById('spot-address').value = data.address;
            document.getElementById('spot-gmap_link').value = data.gmap_link;
            document.getElementById('spot-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('spot-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );

    
    initializeModal(
        'product-modal', 
        'show-product-modal-btn', 
        'cancel-product-modal-btn',
        '.edit-btn[data-category]',
        () => { 
            document.getElementById('product-modal-title').innerText = 'Add New Product';
            document.getElementById('product-id').value = '';
            document.getElementById('product-name').value = '';
            document.getElementById('product-description').value = '';
            document.getElementById('product-category').value = 'food';
            document.getElementById('product-current-image-url').value = 'default.png';
            document.getElementById('product-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('product-modal-title').innerText = 'Edit Product';
            document.getElementById('product-id').value = data.id;
            document.getElementById('product-name').value = data.name;
            document.getElementById('product-description').value = data.description;
            document.getElementById('product-category').value = data.category;
            document.getElementById('product-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('product-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );

    
    initializeModal(
        'event-modal', 
        'show-event-modal-btn', 
        'cancel-event-modal-btn',
        '.edit-btn[data-event_name]', 
        () => { 
            document.getElementById('event-modal-title').innerText = 'Add New Event';
            document.getElementById('event-id').value = '';
            document.getElementById('event-name').value = '';
            document.getElementById('event-description').value = '';
            document.getElementById('event-start_date').value = '';
            document.getElementById('event-end_date').value = '';
            document.getElementById('event-location').value = '';
            document.getElementById('event-current-image-url').value = 'default.png';
            document.getElementById('event-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('event-modal-title').innerText = 'Edit Event';
            document.getElementById('event-id').value = data.id;
            document.getElementById('event-name').value = data.event_name;
            document.getElementById('event-description').value = data.description;
            document.getElementById('event-start_date').value = data.start_date;
            document.getElementById('event-end_date').value = data.end_date;
            document.getElementById('event-location').value = data.location;
            document.getElementById('event-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('event-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );

    
    initializeModal(
        'parking-modal', 
        'show-parking-modal-btn', 
        'cancel-parking-modal-btn',
        '.edit-btn[data-fees]', 
        () => { 
            document.getElementById('parking-modal-title').innerText = 'Add New Parking Area';
            document.getElementById('parking-id').value = '';
            document.getElementById('parking-name').value = '';
            document.getElementById('parking-address').value = '';
            document.getElementById('parking-description').value = '';
            document.getElementById('parking-fees').value = 'Varies';
            document.getElementById('parking-operating_hours').value = '24/7';
            document.getElementById('parking-gmap_link').value = '';
            document.getElementById('parking-current-image-url').value = 'default.png';
            document.getElementById('parking-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('parking-modal-title').innerText = 'Edit Parking Area';
            document.getElementById('parking-id').value = data.id;
            document.getElementById('parking-name').value = data.name;
            document.getElementById('parking-address').value = data.address;
            document.getElementById('parking-description').value = data.description;
            document.getElementById('parking-fees').value = data.fees;
            document.getElementById('parking-operating_hours').value = data.operating_hours;
            document.getElementById('parking-gmap_link').value = data.gmap_link;
            document.getElementById('parking-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('parking-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );

    
    initializeModal(
        'faq-modal', 
        'show-faq-modal-btn', 
        'cancel-faq-modal-btn',
        '.edit-btn[data-question]', 
        () => { 
            document.getElementById('faq-modal-title').innerText = 'Add New FAQ';
            document.getElementById('faq-id').value = '';
            document.getElementById('faq-question').value = '';
            document.getElementById('faq-answer').value = '';
            document.getElementById('faq-category').value = 'general';
        },
        (data) => { 
            document.getElementById('faq-modal-title').innerText = 'Edit FAQ';
            document.getElementById('faq-id').value = data.id;
            document.getElementById('faq-question').value = data.question;
            document.getElementById('faq-answer').value = data.answer;
            document.getElementById('faq-category').value = data.category;
        }
    );

    
    initializeModal(
        'delivery-modal', 
        'show-delivery-modal-btn', 
        'cancel-delivery-modal-btn',
        '.edit-btn[data-contact_number]', 
        () => { 
            document.getElementById('delivery-modal-title').innerText = 'Add New Delivery Service';
            document.getElementById('delivery-id').value = '';
            document.getElementById('delivery-name').value = '';
            document.getElementById('delivery-description').value = '';
            document.getElementById('delivery-contact_number').value = '';
            document.getElementById('delivery-facebook_link').value = '';
            document.getElementById('delivery-current-image-url').value = 'default.png';
            document.getElementById('delivery-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('delivery-modal-title').innerText = 'Edit Delivery Service';
            document.getElementById('delivery-id').value = data.id;
            document.getElementById('delivery-name').value = data.name;
            document.getElementById('delivery-description').value = data.description;
            document.getElementById('delivery-contact_number').value = data.contact_number;
            document.getElementById('delivery-facebook_link').value = data.facebook_link;
            document.getElementById('delivery-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('delivery-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );
    
    
    initializeModal(
        'guide-modal', 
        'show-guide-modal-btn', 
        'cancel-guide-modal-btn',
        '.edit-btn[data-guide_name]', 
        () => { 
            document.getElementById('guide-modal-title').innerText = 'Add New Guide/Tour';
            document.getElementById('guide-id').value = '';
            document.getElementById('guide-name').value = '';
            document.getElementById('guide-description').value = '';
            document.getElementById('guide-specialization').value = 'General Tour';
            document.getElementById('guide-contact_number').value = '';
            document.getElementById('guide-facebook_link').value = '';
            document.getElementById('guide-current-image-url').value = 'default.png';
            document.getElementById('guide-image-preview').style.display = 'none';
        },
        (data) => { 
            document.getElementById('guide-modal-title').innerText = 'Edit Guide/Tour';
            document.getElementById('guide-id').value = data.id;
            document.getElementById('guide-name').value = data.guide_name;
            document.getElementById('guide-description').value = data.description;
            document.getElementById('guide-specialization').value = data.specialization;
            document.getElementById('guide-contact_number').value = data.contact_number;
            document.getElementById('guide-facebook_link').value = data.facebook_link;
            document.getElementById('guide-current-image-url').value = data.image_url;
            
            const previewDiv = document.getElementById('guide-image-preview');
            if(data.image_url && data.image_url !== 'default.png') {
                previewDiv.querySelector('img').src = baseImgPath + data.image_url;
                previewDiv.style.display = 'block';
            } else {
                previewDiv.style.display = 'none';
            }
        }
    );

    
    initializeModal(
        'admin-modal', 
        'show-admin-modal-btn', 
        'cancel-admin-modal-btn',
        null, 
        () => { 
            
            document.getElementById('full_name').value = '';
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
        },
        null 
    );

});
</script>
</body>
</html>