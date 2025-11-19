<?php
$config = require(BASE_PATH . '/src/core/config.php');
$vapidPublicKey = $config['vapid']['publicKey'];
?>
<!DOCTYPE html>
<html lang="en" class="h-full"> <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $pageTitle ?? 'Explore Manaoag'; ?></title>
  
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  
  <script>
    window.VAPID_PUBLIC_KEY = '<?php echo $vapidPublicKey; ?>';
  </script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">