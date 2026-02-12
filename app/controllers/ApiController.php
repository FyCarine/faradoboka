<?php
namespace app\controllers;
use app\models\User;
use Flight;

class ApiController {
    protected $db;
    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function showLogin() {
        Flight::render('auth/login.php', [
            'title' => 'Connexion'
        ]);
    }

    public function loginPost() {
        session_start();

        $email = trim($_POST['email'] ?? '');
    
        if (empty($email)) {
            $email = 'guest@demo.local';
        }
    
        $userModel = new \app\models\User();
    
        $user = $userModel->findByEmail($email);
    
        if (!$user) {
            $user = $userModel->create($email);
        }
    
        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'Impossible de créer l’utilisateur'
            ]);
            return;
        }
    
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
    
        echo json_encode([
            'success' => true,
            'redirect' => '/dashboard'
        ]);
    }
    
    public function showDashboard() {
        session_start();
    
        if (!isset($_SESSION['user_id'])) {
            Flight::redirect('/login');
            return;
        }
    
        Flight::render('auth/dist/index.php', [
            'title' => 'Dashboard'
        ]);
    }

}