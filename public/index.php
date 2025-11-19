<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/explore-manaoag/public'); 

require_once BASE_PATH . '/src/core/Database.php';
require_once BASE_PATH . '/src/controllers/PageController.php';
require_once BASE_PATH . '/src/controllers/AuthController.php';

$dbConfig = [
    'host' => '127.0.0.1',
    'dbname' => 'db_explore_manaoag',
    'user' => 'root',
    'pass' => '' 
];
$database = new Database($dbConfig);
$db = $database->getConnection();

$pageController = new PageController($db);
$authController = new AuthController($db);

$page = $_GET['page'] ?? 'home';

$adminPages = [
    'admin_dashboard', 'admin_logout',
    'admin_manage_content', 'admin_process_content',
    'admin_manage_officials', 'admin_delete_official', 'admin_process_official',
    'admin_manage_spots', 'admin_add_spot', 'admin_edit_spot', 'admin_delete_spot', 'admin_process_spot',
    'admin_manage_products', 'admin_add_product', 'admin_edit_product', 'admin_delete_product', 'admin_process_product',
    'admin_manage_events', 'admin_add_event', 'admin_edit_event', 'admin_delete_event', 'admin_process_event',
    'admin_manage_parking', 'admin_add_parking', 'admin_edit_parking', 'admin_delete_parking', 'admin_process_parking',
    'admin_manage_faqs', 'admin_add_faq', 'admin_edit_faq', 'admin_delete_faq', 'admin_process_faq',
    'admin_manage_delivery', 'admin_add_delivery', 'admin_edit_delivery', 'admin_delete_delivery', 'admin_process_delivery',
    'admin_manage_feedback', 'admin_approve_feedback', 'admin_delete_feedback',
    'admin_manage_guides', 'admin_add_guide', 'admin_edit_guide', 'admin_delete_guide', 'admin_process_guide',
    'admin_send_notification', 'admin_process_notification',
    'admin_manage_links', 'admin_delete_link', 'admin_process_link',
    'admin_manage_users', 'admin_delete_user',
    'admin_manage_admins', 'admin_add_admin', 'admin_delete_admin'
];

$adminActionPages = [
    'admin_process_content', 'admin_process_official', 'admin_process_spot', 
    'admin_process_product', 'admin_process_event', 'admin_process_parking',
    'admin_process_faq', 'admin_process_delivery', 'admin_process_guide',
    'admin_process_notification', 'admin_process_link', 'admin_add_admin',
    'admin_delete_official', 'admin_delete_spot', 'admin_delete_product',
    'admin_delete_event', 'admin_delete_parking', 'admin_delete_faq',
    'admin_delete_delivery', 'admin_approve_feedback', 'admin_delete_feedback',
    'admin_delete_guide', 'admin_delete_link', 'admin_delete_user', 'admin_delete_admin',
    'admin_logout'
];

$adminViewPages = [
    'admin_dashboard', 'admin_manage_content', 
    'admin_manage_officials',
    'admin_manage_spots', 'admin_add_spot', 'admin_edit_spot',
    'admin_manage_products', 'admin_add_product', 'admin_edit_product',
    'admin_manage_events', 'admin_add_event', 'admin_edit_event',
    'admin_manage_parking', 'admin_add_parking', 'admin_edit_parking',
    'admin_manage_faqs', 'admin_add_faq', 'admin_edit_faq',
    'admin_manage_delivery', 'admin_add_delivery', 'admin_edit_delivery',
    'admin_manage_feedback',
    'admin_manage_guides', 'admin_add_guide', 'admin_edit_guide',
    'admin_send_notification',
    'admin_manage_links',
    'admin_manage_users',
    'admin_manage_admins'
];


if ($page === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login(); 
    } else {
        $authController->showLogin(); 
    }
    exit; 
}

$isAdminPage = in_array($page, $adminPages);
$isAdminLoggedIn = isset($_SESSION['admin_id']);

if ($isAdminPage) {
    if (!$isAdminLoggedIn) {
        header('Location: index.php?page=login');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($page, $adminActionPages)) {
        switch ($page) {
            case 'admin_process_content': $pageController->adminProcessContent(); break;
            case 'admin_process_official': $pageController->adminProcessForm(); break;
            case 'admin_process_spot': $pageController->adminProcessSpotForm(); break;
            case 'admin_process_product': $pageController->adminProcessProductForm(); break;
            case 'admin_process_event': $pageController->adminProcessEventForm(); break;
            case 'admin_process_parking': $pageController->adminProcessParkingForm(); break;
            case 'admin_process_faq': $pageController->adminProcessFaqForm(); break;
            case 'admin_process_delivery': $pageController->adminProcessDeliveryForm(); break;
            case 'admin_process_guide': $pageController->adminProcessGuideForm(); break;
            case 'admin_process_notification': $pageController->adminProcessNotification(); break;
            case 'admin_process_link': $pageController->adminProcessLinkForm(); break;
            case 'admin_add_admin': $pageController->adminAddAdmin(); break;
        }
    } 
    else if (in_array($page, $adminActionPages)) {
         switch ($page) {
            case 'admin_logout': $authController->logout(); break;
            case 'admin_delete_official': $pageController->adminDeleteOfficial(); break;
            case 'admin_delete_spot': $pageController->adminDeleteSpot(); break;
            case 'admin_delete_product': $pageController->adminDeleteProduct(); break;
            case 'admin_delete_event': $pageController->adminDeleteEvent(); break;
            case 'admin_delete_parking': $pageController->adminDeleteParking(); break;
            case 'admin_delete_faq': $pageController->adminDeleteFaq(); break;
            case 'admin_delete_delivery': $pageController->adminDeleteDelivery(); break;
            case 'admin_approve_feedback': $pageController->adminApproveFeedback(); break;
            case 'admin_delete_feedback': $pageController->adminDeleteFeedback(); break;
            case 'admin_delete_guide': $pageController->adminDeleteGuide(); break;
            case 'admin_delete_link': $pageController->adminDeleteLink(); break;
            case 'admin_delete_user': $pageController->adminDeleteUser(); break; 
            case 'admin_delete_admin': $pageController->adminDeleteAdmin(); break;
         }
    }
    else if (in_array($page, $adminViewPages)) {
        include BASE_PATH . '/src/views/components/admin_head.php';
        include BASE_PATH . '/src/views/components/admin_navbar.php';
        switch ($page) {
            case 'admin_dashboard': $pageController->adminDashboard(); break;
            case 'admin_manage_content': $pageController->adminManageContent(); break;
            case 'admin_manage_officials': $pageController->adminManageOfficials(); break;
            case 'admin_manage_spots': $pageController->adminManageSpots(); break;
            case 'admin_add_spot': $pageController->adminShowSpotForm(); break;
            case 'admin_edit_spot': $pageController->adminShowSpotForm(); break;
            case 'admin_manage_products': $pageController->adminManageProducts(); break;
            case 'admin_add_product': $pageController->adminShowProductForm(); break;
            case 'admin_edit_product': $pageController->adminShowProductForm(); break;
            case 'admin_manage_events': $pageController->adminManageEvents(); break;
            case 'admin_add_event': $pageController->adminShowEventForm(); break;
            case 'admin_edit_event': $pageController->adminShowEventForm(); break;
            case 'admin_manage_parking': $pageController->adminManageParking(); break;
            case 'admin_add_parking': $pageController->adminShowParkingForm(); break;
            case 'admin_edit_parking': $pageController->adminShowParkingForm(); break;
            case 'admin_manage_faqs': $pageController->adminManageFaqs(); break;
            case 'admin_add_faq': $pageController->adminShowFaqForm(); break;
            case 'admin_edit_faq': $pageController->adminShowFaqForm(); break;
            case 'admin_manage_delivery': $pageController->adminManageDelivery(); break;
            case 'admin_add_delivery': $pageController->adminShowDeliveryForm(); break;
            case 'admin_edit_delivery': $pageController->adminShowDeliveryForm(); break;
            case 'admin_manage_feedback': $pageController->adminManageFeedback(); break;
            case 'admin_manage_guides': $pageController->adminManageGuides(); break;
            case 'admin_add_guide': $pageController->adminShowGuideForm(); break;
            case 'admin_edit_guide': $pageController->adminShowGuideForm(); break;
            case 'admin_send_notification': $pageController->adminSendNotificationPage(); break;
            case 'admin_manage_links': $pageController->adminManageLinks(); break;
            case 'admin_manage_users': $pageController->adminManageUsers(); break; 
            case 'admin_manage_admins': $pageController->adminManageAdmins(); break; 
            default: $pageController->adminDashboard();
        }
        include BASE_PATH . '/src/views/components/admin_footer.php';
    }
    else {
        include BASE_PATH . '/src/views/components/admin_head.php';
        include BASE_PATH . '/src/views/components/admin_navbar.php';
        $pageController->adminDashboard();
        include BASE_PATH . '/src/views/components/admin_footer.php';
    }

} 
else {
    if ($isAdminLoggedIn) {
        header('Location: index.php?page=admin_dashboard');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch ($page) {
            case 'user_login_process': $authController->userLogin(); break; 
            case 'user_register_process': $authController->userRegister(); break;
            case 'toggle_favorite': $pageController->toggleFavorite(); break;
            case 'submit_feedback': $pageController->submitFeedback(); break;
            default:
                header('Location: index.php?page=home');
                exit;
        }
    } 
    else if ($page === 'user_logout') {
        $authController->logout();
    }
    else {
        include BASE_PATH . '/src/views/components/head.php';
        include BASE_PATH . '/src/views/components/navbar.php';

        switch ($page) {
            case 'home': $pageController->home(); break;
            case 'mayor': $pageController->mayor(); break;
            case 'vice-mayor': $pageController->viceMayor(); break;
            case 'councilors': $pageController->councilors(); break;
            case 'spots': $pageController->spots(); break; 
            case 'products': $pageController->products(); break;
            case 'events': $pageController->events(); break; 
            case 'parking': $pageController->parking(); break;
            case 'faqs': $pageController->faqs(); break;
            case 'delivery': $pageController->delivery(); break;
            case 'guides': $pageController->guides(); break;
            case 'useful_links': $pageController->usefulLinks(); break;
            case 'user_login': $authController->showUserLogin(); break;
            case 'user_register': $authController->showUserRegister(); break;
            case 'profile': $pageController->profile(); break; 
            case 'search': $pageController->search(); break;
            default: $pageController->home();
        }
        
        include BASE_PATH . '/src/views/components/footer.php';
    }
}
?>