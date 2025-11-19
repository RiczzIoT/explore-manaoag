<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css" />
  <style>
    
    body, html {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
    }
    .admin-body-wrapper {
        display: flex;
        min-height: 100vh;
    }
    .admin-sidenav {
        width: 260px;
        background: #2c3e50; 
        color: white;
        padding: 20px;
        flex-shrink: 0;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    
    .admin-logo-container {
        text-align: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #4a627a;
        margin-bottom: 15px;
    }
    .admin-logo-container img {
        width: 80px;
        height: 80px;
        margin: 0 auto 10px;
    }
    .admin-logo-container h3 {
        margin: 0;
        font-size: 1.5em;
        color: white;
    }
    .admin-logo-container span {
        font-size: 0.9em;
        color: #bdc3c7;
        display: block;
    }
    

    .admin-sidenav a {
        display: block;
        color: #ecf0f1;
        text-decoration: none;
        padding: 12px 15px;
        margin-bottom: 5px;
        border-radius: 6px;
        transition: background 0.3s;
    }
    .admin-sidenav a:hover {
        background: #34495e;
    }
    .admin-sidenav a.logout-btn {
        margin-top: 30px;
        background: #c0392b; 
    }
    .admin-sidenav a.logout-btn:hover {
        background: #e74c3c;
    }
    .admin-sidenav a.notification-btn {
        background: #8e44ad; 
    }
     .admin-sidenav a.notification-btn:hover {
        background: #9b59b6;
    }
    .admin-content {
        flex-grow: 1;
        padding: 40px;
        overflow-y: auto;
    }
    

    
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6); z-index: 1000;
        display: none; 
        align-items: center; justify-content: center;
    }
    .modal-content {
        background: #fff; border-radius: 8px;
        padding: 30px; width: 90%; max-width: 600px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .admin-card-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .admin-card {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .admin-card h3 { margin-top: 0; color: #003366; }
    .admin-card p { font-size: 0.9em; color: #555; }
    .admin-card .card-actions { margin-top: 15px; }
    .action-btn { padding: 5px 10px; text-decoration: none; border-radius: 4px; color: white; font-size: 0.9em; margin-right: 5px; cursor: pointer; border: none; }
    .edit-btn { background-color: #007bff; }
    .delete-btn { background-color: #dc3545; }
    .add-btn { background-color: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-bottom: 20px; cursor: pointer; }
    
    .admin-form .form-group { margin-bottom: 15px; }
    .admin-form .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .admin-form .form-group input, .admin-form .form-group textarea, .admin-form .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; box-sizing: border-box; }
    .admin-form .form-group textarea { min-height: 100px; resize: vertical; }
    .form-actions { margin-top: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 10px; }
    .submit-btn { background-color: #28a745; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; font-weight: bold; }
    .cancel-btn { background-color: #6c757d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; cursor: pointer; border: none; }
  </style>
</head>
<body class="admin-body-wrapper">