<?php
$currentPage = $_GET['page'] ?? 'admin_dashboard';

$tourismPages = [
    'admin_manage_spots', 'admin_add_spot', 'admin_edit_spot',
    'admin_manage_products', 'admin_add_product', 'admin_edit_product',
    'admin_manage_events', 'admin_add_event', 'admin_edit_event',
    'admin_manage_guides', 'admin_add_guide', 'admin_edit_guide',
    'admin_manage_parking', 'admin_add_parking', 'admin_edit_parking',
    'admin_manage_delivery', 'admin_add_delivery', 'admin_edit_delivery',
    'admin_manage_links'
];

$adminPages = [
    'admin_manage_officials',
    'admin_manage_users',
    'admin_manage_admins', 'admin_add_admin',
    'admin_manage_feedback',
    'admin_manage_faqs', 'admin_add_faq', 'admin_edit_faq'
];

$isTourismOpen = in_array($currentPage, $tourismPages) ? 'active' : '';
$tourismDisplay = in_array($currentPage, $tourismPages) ? 'block' : 'none';

$isAdminOpen = in_array($currentPage, $adminPages) ? 'active' : '';
$adminDisplay = in_array($currentPage, $adminPages) ? 'block' : 'none';
?>

<style>
    
    .dropdown-btn {
        padding: 12px 15px;
        text-decoration: none;
        font-size: 16px;
        color: #ecf0f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        outline: none;
        border-radius: 6px;
        transition: background 0.3s;
        margin-bottom: 2px;
    }
    .dropdown-btn:hover { background-color: #34495e; }
    
    
    .dropdown-btn.active { 
        background-color: #2c3e50; 
        color: #fff; 
    }

    
    .dropdown-btn.active .menu-label {
        font-weight: bold;
    }
    
    
    .dropdown-btn i {
        font-weight: 900 !important; 
    }
    
    
    .nav-item-wrapper {
        display: flex;
        align-items: center;
    }

    .dropdown-container {
        display: none;
        background-color: #1a252f;
        padding-left: 0;
        border-radius: 6px;
        margin-bottom: 5px;
        overflow: hidden;
    }
    .dropdown-container a {
        display: block;
        font-size: 14px;
        padding: 10px 15px 10px 46px; 
        color: #bdc3c7;
        text-decoration: none;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    .dropdown-container a:hover {
        color: #fff;
        background-color: rgba(255,255,255,0.05);
    }

    
    .dropdown-container a.active-link {
        color: #fff;
        background-color: rgba(255,255,255,0.1);
        border-left: 3px solid #3498db;
        font-weight: bold;
    }

    
    .caret-icon { transition: transform 0.3s; }
    .dropdown-btn.active .caret-icon { transform: rotate(180deg); }

    
    .nav-link {
        display: block;
        padding: 12px 15px;
        color: #ecf0f1;
        text-decoration: none;
        border-radius: 6px;
        margin-bottom: 2px;
    }
    .nav-link:hover { background-color: #34495e; }
    .nav-link.active { background-color: #2980b9; color: white; }
    .nav-link.active .menu-label { font-weight: bold; }

    
    .admin-topbar {
        display: flex;
        justify-content: flex-end; 
        align-items: center;
        padding-bottom: 15px;
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
    }
    .top-logout-btn {
        background-color: #c0392b;
        color: white;
        padding: 8px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .top-logout-btn:hover { background-color: #e74c3c; }
    .admin-user-info { margin-right: 20px; color: #555; font-weight: 600; }
</style>

<nav class="admin-sidenav">
    <div class="admin-logo-container">
        <img src="<?php echo BASE_URL; ?>/images/manaoag-seal.png" alt="Manaoag Logo">
        <h3>Manaoag Admin</h3>
    </div>
  
    <a href="index.php?page=admin_dashboard" class="nav-link <?php echo ($currentPage == 'admin_dashboard') ? 'active' : ''; ?>">
        <div class="nav-item-wrapper">
            <i class="fa fa-gauge mr-2" style="width:20px; text-align:center;"></i> 
            <span class="menu-label">Dashboard</span>
        </div>
    </a>
    
    <a href="index.php?page=admin_manage_content" class="nav-link <?php echo ($currentPage == 'admin_manage_content') ? 'active' : ''; ?>">
        <div class="nav-item-wrapper">
            <i class="fa fa-globe mr-2" style="width:20px; text-align:center;"></i> 
            <span class="menu-label">Site Content</span>
        </div>
    </a>

    <button class="dropdown-btn <?php echo $isTourismOpen; ?>">
        <div class="nav-item-wrapper">
            <i class="fa fa-map mr-2" style="width:20px; text-align:center;"></i> 
            <span class="menu-label">Tourism Assets</span>
        </div>
        <i class="fa fa-caret-down caret-icon"></i>
    </button>
    <div class="dropdown-container" style="display: <?php echo $tourismDisplay; ?>;">
        <a href="index.php?page=admin_manage_spots" class="<?php echo ($currentPage == 'admin_manage_spots' || $currentPage == 'admin_add_spot') ? 'active-link' : ''; ?>">Tourist Spots</a>
        <a href="index.php?page=admin_manage_products" class="<?php echo ($currentPage == 'admin_manage_products' || $currentPage == 'admin_add_product') ? 'active-link' : ''; ?>">Products & Food</a>
        <a href="index.php?page=admin_manage_events" class="<?php echo ($currentPage == 'admin_manage_events' || $currentPage == 'admin_add_event') ? 'active-link' : ''; ?>">Events & Festivals</a>
        <a href="index.php?page=admin_manage_guides" class="<?php echo ($currentPage == 'admin_manage_guides' || $currentPage == 'admin_add_guide') ? 'active-link' : ''; ?>">Tour Guides</a>
        <a href="index.php?page=admin_manage_parking" class="<?php echo ($currentPage == 'admin_manage_parking' || $currentPage == 'admin_add_parking') ? 'active-link' : ''; ?>">Parking Areas</a>
        <a href="index.php?page=admin_manage_delivery" class="<?php echo ($currentPage == 'admin_manage_delivery' || $currentPage == 'admin_add_delivery') ? 'active-link' : ''; ?>">Delivery Services</a>
        <a href="index.php?page=admin_manage_links" class="<?php echo ($currentPage == 'admin_manage_links') ? 'active-link' : ''; ?>">Useful Links</a>
    </div>

    <button class="dropdown-btn <?php echo $isAdminOpen; ?>">
        <div class="nav-item-wrapper">
            <i class="fa fa-users-gear mr-2" style="width:20px; text-align:center;"></i> 
            <span class="menu-label">Administration</span>
        </div>
        <i class="fa fa-caret-down caret-icon"></i>
    </button>
    <div class="dropdown-container" style="display: <?php echo $adminDisplay; ?>;">
        <a href="index.php?page=admin_manage_officials" class="<?php echo ($currentPage == 'admin_manage_officials') ? 'active-link' : ''; ?>">Officials</a>
        <a href="index.php?page=admin_manage_users" class="<?php echo ($currentPage == 'admin_manage_users') ? 'active-link' : ''; ?>">Registered Tourists</a>
        <a href="index.php?page=admin_manage_admins" class="<?php echo ($currentPage == 'admin_manage_admins') ? 'active-link' : ''; ?>">Admin Accounts</a>
        <a href="index.php?page=admin_manage_feedback" class="<?php echo ($currentPage == 'admin_manage_feedback') ? 'active-link' : ''; ?>">Feedback & Reviews</a>
        <a href="index.php?page=admin_manage_faqs" class="<?php echo ($currentPage == 'admin_manage_faqs') ? 'active-link' : ''; ?>">Manage FAQs</a>
    </div>

    <a href="index.php?page=admin_send_notification" class="nav-link notification-btn <?php echo ($currentPage == 'admin_send_notification') ? 'active' : ''; ?>">
        <div class="nav-item-wrapper">
            <i class="fa fa-bell mr-2" style="width:20px; text-align:center;"></i> 
            <span class="menu-label">Send Notification</span>
        </div>
    </a>
</nav>

<main class="admin-content">

    <div class="admin-topbar">
        <span class="admin-user-info">
            <i class="fa fa-user-circle mr-1"></i> 
            <?php echo htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>
        </span>
        <a href="index.php?page=admin_logout" class="top-logout-btn">
            <i class="fa fa-sign-out"></i> Log Out
        </a>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
});
</script>