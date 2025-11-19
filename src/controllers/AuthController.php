<?php
require_once BASE_PATH . '/src/models/User.php';

class AuthController {
    private $db;
    private $adminTable = 'admins';
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($db);
    }

    public function showLogin() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin_dashboard');
            exit;
        }
        include BASE_PATH . '/src/views/pages/admin_login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $this_Message = 'Username and password are required.';
                include BASE_PATH . '/src/views/pages/admin_login.php';
                return;
            }

            $query = "SELECT * FROM " . $this->adminTable . " WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                header('Location: index.php?page=admin_dashboard');
                exit;
            } else {
                $this_Message = 'Invalid username or password.';
                include BASE_PATH . '/src/views/pages/admin_login.php';
                return;
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?page=home');
        exit;
    }


    public function showUserLogin() {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=profile'); 
            exit;
        }
        $this->loadView('user_login');
    }

    public function showUserRegister() {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=profile');
            exit;
        }
        $this->loadView('user_register');
    }

    public function userLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $message = '';

        if (empty($username) || empty($password)) {
            $message = 'Username and password are required.';
        } else {
            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                header('Location: index.php?page=profile');
                exit;
            } else {
                $message = 'Invalid username or password.';
            }
        }
        
        $data = ['message' => $message, 'messageType' => 'error'];
        extract($data);
        
        include BASE_PATH . '/src/views/components/head.php';
        include BASE_PATH . '/src/views/components/navbar.php';
        include BASE_PATH . "/src/views/pages/user_login.php";
        include BASE_PATH . '/src/views/components/footer.php';
        
        return; 
    }

    public function userRegister() {
        $fullName = $_POST['full_name'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $message = '';
        $messageType = 'error';
        $data = [];

        if (empty($fullName) || empty($username) || empty($password)) {
            $message = 'All fields are required.';
        } else {
            $postData = [
                'full_name' => $fullName,
                'username' => $username,
                'password' => $password
            ];
            $result = $this->userModel->register($postData);

            if ($result === true) {
                $message = 'Registration successful! You can now log in.';
                $messageType = 'success';
                
                $data = ['message' => $message, 'messageType' => $messageType];
                extract($data);
                
                include BASE_PATH . '/src/views/components/head.php';
                include BASE_PATH . '/src/views/components/navbar.php';
                include BASE_PATH . "/src/views/pages/user_login.php";
                include BASE_PATH . '/src/views/components/footer.php';
                return; 
            } else {
                $message = $result;
            }
        }
        
        $data = ['message' => $message, 'messageType' => $messageType];
        extract($data);
        
        include BASE_PATH . '/src/views/components/head.php';
        include BASE_PATH . '/src/views/components/navbar.php';
        include BASE_PATH . "/src/views/pages/user_register.php";
        include BASE_PATH . '/src/views/components/footer.php';
        return;
    }
    
    private function loadView($viewName, $data = []) {
        extract($data);
        include BASE_PATH . "/src/views/pages/{$viewName}.php";
    }
}
?>