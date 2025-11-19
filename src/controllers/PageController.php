<?php
require_once BASE_PATH . '/vendor/autoload.php';

require_once BASE_PATH . '/src/models/Official.php';
require_once BASE_PATH . '/src/models/TouristSpot.php'; 
require_once BASE_PATH . '/src/models/Product.php'; 
require_once BASE_PATH . '/src/models/Event.php'; 
require_once BASE_PATH . '/src/models/Parking.php';
require_once BASE_PATH . '/src/models/Favorite.php';
require_once BASE_PATH . '/src/models/Faq.php';
require_once BASE_PATH . '/src/models/Delivery.php';
require_once BASE_PATH . '/src/models/Feedback.php';
require_once BASE_PATH . '/src/models/Guide.php';
require_once BASE_PATH . '/src/models/Notifier.php';
require_once BASE_PATH . '/src/models/Link.php';
require_once BASE_PATH . '/src/models/Content.php';
require_once BASE_PATH . '/src/models/User.php'; 
require_once BASE_PATH . '/src/models/Admin.php';

class PageController {
    private $db;
    private $officialModel, $spotModel, $productModel, $eventModel, $parkingModel, $favoriteModel, $faqModel, $deliveryModel, $feedbackModel, $guideModel, $notifier, $linkModel, $contentModel, $userModel, $adminModel;

    public function __construct($db) {
        $this->db = $db;
        $this->officialModel = new Official($db);
        $this->spotModel = new TouristSpot($db); 
        $this->productModel = new Product($db); 
        $this->eventModel = new Event($db);
        $this->parkingModel = new Parking($db);
        $this->favoriteModel = new Favorite($db);
        $this->faqModel = new Faq($db);
        $this->deliveryModel = new Delivery($db);
        $this->feedbackModel = new Feedback($db);
        $this->guideModel = new Guide($db);
        $this->notifier = new Notifier($db);
        $this->linkModel = new Link($db);
        $this->contentModel = new Content($db);
        $this->userModel = new User($db); 
        $this->adminModel = new Admin($db);
    }

    private function loadView($viewName, $data = []) {
        extract($data);
        include BASE_PATH . "/src/views/pages/{$viewName}.php";
    }


    private function getFavoritesData() {
        $favorites = [];
        if (isset($_SESSION['user_id'])) {
            $favs = $this->favoriteModel->getAllByUser($_SESSION['user_id']);
            foreach ($favs as $fav) {
                $favorites[$fav['type'] . '-' . $fav['id']] = true;
            }
        }
        return $favorites;
    }



    

    public function home() { 
        $data = [];
    
        $data['content'] = $this->contentModel->getAllAsArray();
        
    
        if (isset($_SESSION['user_id'])) {
        
        
            $data['featured_spots'] = $this->spotModel->getAll(4);
            $data['featured_products'] = $this->productModel->getAll(4);
            $data['featured_guides'] = $this->guideModel->getAll(3);
        }
        
        $this->loadView('home', $data);
    }
    
    public function mayor() {
        $mayorData = $this->officialModel->getSingleOfficial('mayor');
        $this->loadView('mayor', ['official' => $mayorData]);
    }
    public function viceMayor() {
        $viceMayorData = $this->officialModel->getSingleOfficial('vice-mayor');
        $this->loadView('vice-mayor', ['official' => $viceMayorData]);
    }
    public function councilors() {
        $councilorsData = $this->officialModel->getOfficialsByPosition('councilor');
        $this->loadView('councilors', ['councilors' => $councilorsData]);
    }
    public function spots() {
        $spotsData = $this->spotModel->getAll();
        $this->loadView('spots', [ 'spots' => $spotsData, 'favorites' => $this->getFavoritesData() ]);
    }
    public function products() { 
        $productsData = $this->productModel->getAll();
        $this->loadView('products', [ 'products' => $productsData, 'favorites' => $this->getFavoritesData() ]);
    }
    public function events() { 
        $eventsData = $this->eventModel->getUpcoming(); 
        $this->loadView('events', ['events' => $eventsData]);
    }
    public function parking() { 
        $parkingData = $this->parkingModel->getAll();
        $this->loadView('parking', [ 'parking_areas' => $parkingData, 'favorites' => $this->getFavoritesData() ]);
    }
    public function faqs() { 
        $faqsData = $this->faqModel->getAll();
        $this->loadView('faqs', ['faqs' => $faqsData]);
    }
    public function delivery() {
        $deliveryData = $this->deliveryModel->getAll();
        $this->loadView('delivery', ['delivery_services' => $deliveryData]);
    }
    public function guides() {
        $guideData = $this->guideModel->getAll();
        $this->loadView('guides', ['guides' => $guideData]);
    }
    public function usefulLinks() {
        $linkData = $this->linkModel->getAll();
        $this->loadView('useful_links', ['links' => $linkData]);
    }
    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=user_login');
            exit;
        }
        $userData = [ 'id' => $_SESSION['user_id'], 'name' => $_SESSION['user_name'] ];
        $favorites = $this->favoriteModel->getAllByUser($_SESSION['user_id']);
        $this->loadView('profile', [ 'user' => $userData, 'favorites' => $favorites ]);
    }
    public function search() {
        $searchTerm = $_GET['q'] ?? '';
        $spotResults = []; $officialResults = []; $productResults = []; $eventResults = []; $parkingResults = []; $faqResults = []; $deliveryResults = []; $guideResults = []; $linkResults = [];

        if (!empty($searchTerm)) {
            $spotResults = $this->spotModel->search($searchTerm);
            $officialResults = $this->officialModel->search($searchTerm);
            $productResults = $this->productModel->search($searchTerm); 
            $eventResults = $this->eventModel->search($searchTerm); 
            $parkingResults = $this->parkingModel->search($searchTerm);
            $faqResults = $this->faqModel->search($searchTerm);
            $deliveryResults = $this->deliveryModel->search($searchTerm);
            $guideResults = $this->guideModel->search($searchTerm);
            $linkResults = $this->linkModel->search($searchTerm);
        }

        $this->loadView('search_results', [
            'searchTerm' => $searchTerm,
            'spots' => $spotResults, 'officials' => $officialResults,
            'products' => $productResults, 'events' => $eventResults,
            'parking' => $parkingResults, 'faqs' => $faqResults,
            'delivery' => $deliveryResults,
            'guides' => $guideResults,
            'links' => $linkResults,
            'favorites' => $this->getFavoritesData()
        ]);
    }
    public function toggleFavorite() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }
        $userId = $_SESSION['user_id'];
        $itemType = $_POST['item_type'] ?? '';
        $itemId = $_POST['item_id'] ?? 0;
        $action = $_POST['action'] ?? '';
        if (empty($itemType) || empty($itemId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid item.']);
            exit;
        }
        $success = false;
        if ($action === 'add') {
            $success = $this->favoriteModel->add($userId, $itemType, (int)$itemId);
        } else if ($action === 'remove') {
            $success = $this->favoriteModel->remove($userId, $itemType, (int)$itemId);
        }
        echo json_encode(['success' => $success]);
        exit;
    }
    public function submitFeedback() {
        $data = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'user_name' => $_SESSION['user_name'] ?? $_POST['name'] ?? 'Guest',
            'rating' => $_POST['rating'] ?? 5,
            'comment' => $_POST['comment'] ?? '',
            'item_type' => $_POST['item_type'] ?? 'general',
            'item_id' => $_POST['item_id'] ?? null
        ];
        $this->feedbackModel->create($data);
        $referrer = $_SERVER['HTTP_REFERER'] ?? 'index.php?page=home';
        header("Location: $referrer&feedback=success");
        exit;
    }





    private function handleFileUpload($fileInputName, $currentTargetDir, $currentImageUrl) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == 0) {
            
        
            $targetSubDir = $currentTargetDir == '' ? '' : $currentTargetDir . "/";
            $targetDir = BASE_PATH . "/public/images/" . $targetSubDir;

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); 
            }
            $fileName = preg_replace("/[^a-zA-Z0-9-_\.]/", "", basename($_FILES[$fileInputName]['name']));
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFile)) {
            
                return $targetSubDir . $fileName;
            } else {
                return $currentImageUrl;
            }
        }
        return $currentImageUrl;
    }


    
    public function adminDashboard() { 
        $stats = [
            'users' => $this->userModel->getCounts(),
            'spots' => $this->spotModel->getCounts(),
            'products' => $this->productModel->getCounts(),
            'pending_feedback' => $this->feedbackModel->getPendingCount()
        ];
        
        
        $events = $this->eventModel->getAll();

        $this->loadView('admin/dashboard', ['stats' => $stats, 'events' => $events]); 
    }
    

    public function adminManageContent() {
        $contentData = $this->contentModel->getAllAsArray();
        $this->loadView('admin/manage_content', ['content' => $contentData]);
    }


    public function adminProcessContent() {
    
        $newHeroImg = $this->handleFileUpload('hero_image_file', '', $_POST['current_hero_image_url']);
        $newHistoryImg = $this->handleFileUpload('history_image_file', '', $_POST['current_history_image_url']);

    
        $this->contentModel->update('hero_title', $_POST['hero_title']);
        $this->contentModel->update('history_title', $_POST['history_title']);
        $this->contentModel->update('history_content', $_POST['history_content']);
        $this->contentModel->update('live_url', $_POST['live_url']);
        
    
        $this->contentModel->update('hero_image_url', $newHeroImg);
        $this->contentModel->update('history_image_url', $newHistoryImg);
        
        header('Location: index.php?page=admin_manage_content&success=true');
        exit;
    }



    public function adminManageOfficials() {
        $allOfficials = $this->officialModel->getAllOfficials();
        $this->loadView('admin/manage_officials', ['officials' => $allOfficials]);
    }
    public function adminShowForm() {
        $official = null; $pageTitle = 'Add New Official';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $official = $this->officialModel->getOfficialById($id);
            $pageTitle = 'Edit Official';
        }
        $this->loadView('admin/official_form', ['official' => $official, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'officials', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'name' => $_POST['name'] ?? '',
            'position' => $_POST['position'] ?? '', 'message' => $_POST['message'] ?? '',
            'facebook_url' => $_POST['facebook_url'] ?? '', 'website_url' => $_POST['website_url'] ?? '',
            'image_url' => $newImageUrl, 'order' => $_POST['order'] ?? 0
        ];
        if (!empty($data['id'])) { $this->officialModel->update($data); } 
        else { $this->officialModel->create($data); }
        header('Location: index.php?page=admin_manage_officials');
        exit;
    }
    public function adminDeleteOfficial() {
        if (isset($_GET['id'])) { $this->officialModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_officials');
        exit;
    }


    public function adminManageSpots() {
        $allSpots = $this->spotModel->getAll();
        $this->loadView('admin/manage_spots', ['spots' => $allSpots]);
    }
    public function adminShowSpotForm() {
        $spot = null; $pageTitle = 'Add New Tourist Spot';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $spot = $this->spotModel->getById($id);
            $pageTitle = 'Edit Tourist Spot';
        }
        $this->loadView('admin/spot_form', ['spot' => $spot, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessSpotForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'spots', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '', 'image_url' => $newImageUrl,
            'address' => $_POST['address'] ?? '', 'gmap_link' => $_POST['gmap_link'] ?? '',
            'category' => $_POST['category'] ?? 'general'
        ];
        if (!empty($data['id'])) { $this->spotModel->update($data); } 
        else { $this->spotModel->create($data); }
        header('Location: index.php?page=admin_manage_spots');
        exit;
    }
    public function adminDeleteSpot() {
        if (isset($_GET['id'])) { $this->spotModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_spots');
        exit;
    }
    

    public function adminManageProducts() {
        $allProducts = $this->productModel->getAll();
        $this->loadView('admin/manage_products', ['products' => $allProducts]);
    }
    public function adminShowProductForm() {
        $product = null; $pageTitle = 'Add New Product';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $product = $this->productModel->getById($id);
            $pageTitle = 'Edit Product';
        }
        $this->loadView('admin/product_form', ['product' => $product, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessProductForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'products', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '', 'image_url' => $newImageUrl,
            'category' => $_POST['category'] ?? 'food'
        ];
        if (!empty($data['id'])) { $this->productModel->update($data); } 
        else { $this->productModel->create($data); }
        header('Location: index.php?page=admin_manage_products');
        exit;
    }
    public function adminDeleteProduct() {
        if (isset($_GET['id'])) { $this->productModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_products');
        exit;
    }


    public function adminManageEvents() {
        $allEvents = $this->eventModel->getAll();
        $this->loadView('admin/manage_events', ['events' => $allEvents]);
    }
    public function adminShowEventForm() {
        $event = null; $pageTitle = 'Add New Event';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $event = $this->eventModel->getById($id);
        }
        $this->loadView('admin/event_form', ['event' => $event, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessEventForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'events', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'event_name' => $_POST['event_name'] ?? '',
            'description' => $_POST['description'] ?? '', 'image_url' => $newImageUrl,
            'start_date' => $_POST['start_date'] ?? null, 'end_date' => !empty($_POST['end_date']) ? $_POST['end_date'] : null,
            'location' => $_POST['location'] ?? ''
        ];
        if (!empty($data['id'])) { $this->eventModel->update($data); } 
        else { $this->eventModel->create($data); }
        header('Location: index.php?page=admin_manage_events');
        exit;
    }
    public function adminDeleteEvent() {
        if (isset($_GET['id'])) { $this->eventModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_events');
        exit;
    }
    

    public function adminManageParking() {
        $allParking = $this->parkingModel->getAll();
        $this->loadView('admin/manage_parking', ['parking_areas' => $allParking]);
    }
    public function adminShowParkingForm() {
        $parking = null; $pageTitle = 'Add New Parking Area';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $parking = $this->parkingModel->getById($id);
            $pageTitle = 'Edit Parking Area';
        }
        $this->loadView('admin/parking_form', ['parking' => $parking, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessParkingForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'parking', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'name' => $_POST['name'] ?? '',
            'address' => $_POST['address'] ?? '', 'description' => $_POST['description'] ?? '',
            'image_url' => $newImageUrl, 'gmap_link' => $_POST['gmap_link'] ?? '',
            'operating_hours' => $_POST['operating_hours'] ?? '', 'fees' => $_POST['fees'] ?? ''
        ];
        if (!empty($data['id'])) { $this->parkingModel->update($data); } 
        else { $this->parkingModel->create($data); }
        header('Location: index.php?page=admin_manage_parking');
        exit;
    }
    public function adminDeleteParking() {
        if (isset($_GET['id'])) { $this->parkingModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_parking');
        exit;
    }
    

    public function adminManageFaqs() {
        $allFaqs = $this->faqModel->getAll();
        $this->loadView('admin/manage_faqs', ['faqs' => $allFaqs]);
    }
    public function adminShowFaqForm() {
        $faq = null; $pageTitle = 'Add New FAQ';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $faq = $this->faqModel->getById($id);
            $pageTitle = 'Edit FAQ';
        }
        $this->loadView('admin/faq_form', ['faq' => $faq, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessFaqForm() {
        $data = [
            'id' => $_POST['id'] ?? null, 'question' => $_POST['question'] ?? '',
            'answer' => $_POST['answer'] ?? '', 'category' => $_POST['category'] ?? 'general'
        ];
        if (!empty($data['id'])) { $this->faqModel->update($data); } 
        else { $this->faqModel->create($data); }
        header('Location: index.php?page=admin_manage_faqs');
        exit;
    }
    public function adminDeleteFaq() {
        if (isset($_GET['id'])) { $this->faqModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_faqs');
        exit;
    }
    

    public function adminManageDelivery() {
        $allDelivery = $this->deliveryModel->getAll();
        $this->loadView('admin/manage_delivery', ['delivery_services' => $allDelivery]);
    }
    public function adminShowDeliveryForm() {
        $delivery = null; $pageTitle = 'Add New Delivery Service';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $delivery = $this->deliveryModel->getById($id);
            $pageTitle = 'Edit Delivery Service';
        }
        $this->loadView('admin/delivery_form', ['delivery' => $delivery, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessDeliveryForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'delivery', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'name' => $_POST['name'] ?? '',
            'description' => $_POST['description'] ?? '', 'image_url' => $newImageUrl,
            'contact_number' => $_POST['contact_number'] ?? '', 'facebook_link' => $_POST['facebook_link'] ?? ''
        ];
        if (!empty($data['id'])) { $this->deliveryModel->update($data); } 
        else { $this->deliveryModel->create($data); }
        header('Location: index.php?page=admin_manage_delivery');
        exit;
    }
    public function adminDeleteDelivery() {
        if (isset($_GET['id'])) { $this->deliveryModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_delivery');
        exit;
    }


    public function adminManageFeedback() {
        $allFeedback = $this->feedbackModel->getAll();
        $this->loadView('admin/manage_feedback', ['feedback' => $allFeedback]);
    }
    public function adminApproveFeedback() {
        if (isset($_GET['id'])) {
            $this->feedbackModel->approve((int)$_GET['id']);
        }
        header('Location: index.php?page=admin_manage_feedback');
        exit;
    }
    public function adminDeleteFeedback() {
        if (isset($_GET['id'])) {
            $this->feedbackModel->delete((int)$_GET['id']);
        }
        header('Location: index.php?page=admin_manage_feedback');
        exit;
    }
    

    public function adminManageGuides() {
        $allGuides = $this->guideModel->getAll();
        $this->loadView('admin/manage_guides', ['guides' => $allGuides]);
    }
    public function adminShowGuideForm() {
        $guide = null; $pageTitle = 'Add New Guide/Tour';
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $guide = $this->guideModel->getById($id);
            $pageTitle = 'Edit Guide/Tour';
        }
        $this->loadView('admin/guide_form', ['guide' => $guide, 'pageTitle' => $pageTitle]);
    }
    public function adminProcessGuideForm() {
        $newImageUrl = $this->handleFileUpload('image_file', 'guides', $_POST['current_image_url'] ?? 'default.png');
        $data = [
            'id' => $_POST['id'] ?? null, 'guide_name' => $_POST['guide_name'] ?? '',
            'description' => $_POST['description'] ?? '', 'image_url' => $newImageUrl,
            'contact_number' => $_POST['contact_number'] ?? '', 'facebook_link' => $_POST['facebook_link'] ?? '',
            'specialization' => $_POST['specialization'] ?? ''
        ];
        if (!empty($data['id'])) { $this->guideModel->update($data); } 
        else { $this->guideModel->create($data); }
        header('Location: index.php?page=admin_manage_guides');
        exit;
    }
    public function adminDeleteGuide() {
        if (isset($_GET['id'])) { $this->guideModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_guides');
        exit;
    }
    

    public function adminSendNotificationPage() {
        $this->loadView('admin/send_notification');
    }
    public function adminProcessNotification() {
        $title = $_POST['title'] ?? 'Explore Manaoag';
        $message = $_POST['message'] ?? 'Check out the new updates!';
        $results = $this->notifier->sendToAll($title, $message);
        $_SESSION['notification_results'] = $results;
        header('Location: index.php?page=admin_send_notification');
        exit;
    }


    public function adminManageLinks() {
        $allLinks = $this->linkModel->getAll();
        $this->loadView('admin/manage_links', ['links' => $allLinks]);
    }

    public function adminProcessLinkForm() {
        $data = [
            'id' => $_POST['id'] ?? null,
            'title' => $_POST['title'] ?? '',
            'url' => $_POST['url'] ?? '',
            'description' => $_POST['description'] ?? '',
            'category' => $_POST['category'] ?? 'general'
        ];
        if (!empty($data['id'])) { $this->linkModel->update($data); } 
        else { $this->linkModel->create($data); }
        header('Location: index.php?page=admin_manage_links');
        exit;
    }
    public function adminDeleteLink() {
        if (isset($_GET['id'])) { $this->linkModel->delete((int)$_GET['id']); }
        header('Location: index.php?page=admin_manage_links');
        exit;
    }


    public function adminManageUsers() {
        $allUsers = $this->userModel->getAll();
        $this->loadView('admin/manage_users', ['users' => $allUsers]);
    }
    public function adminDeleteUser() {
        if (isset($_GET['id'])) { 
            $this->userModel->delete((int)$_GET['id']); 
        }
        header('Location: index.php?page=admin_manage_users');
        exit;
    }


    public function adminManageAdmins() {
        $allAdmins = $this->adminModel->getAll();
        $this->loadView('admin/manage_admins', ['admins' => $allAdmins]);
    }
    public function adminAddAdmin() {
        $fullName = $_POST['full_name'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($fullName) || empty($username) || empty($password)) {
            $_SESSION['admin_form_message'] = 'All fields are required.';
            $_SESSION['admin_form_message_type'] = 'error';
        } else {
            $data = ['full_name' => $fullName, 'username' => $username, 'password' => $password];
            $result = $this->adminModel->create($data);

            if ($result === true) {
                $_SESSION['admin_form_message'] = 'Admin account created successfully.';
                $_SESSION['admin_form_message_type'] = 'success';
            } else {
                $_SESSION['admin_form_message'] = $result;
                $_SESSION['admin_form_message_type'] = 'error';
            }
        }
        header('Location: index.php?page=admin_manage_admins');
        exit;
    }
    public function adminDeleteAdmin() {
        if (isset($_GET['id'])) {
            $this->adminModel->delete((int)$_GET['id']);
        }
        header('Location: index.php?page=admin_manage_admins');
        exit;
    }
}
?>