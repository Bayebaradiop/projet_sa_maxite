<?php
namespace App\Controller;
use App\Core\App;
use App\Core\Validator;
use Exception;
use App\Core\AbstracteController;

class SecuriteController extends AbstracteController
{
    private $securityService;
    private $url;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'securite';
        $this->session = App::getDependency('session');
        $this->securityService = App::getDependency('securityService');
        $this->url = getenv('URL');
    }

    public function register() {}
    public function create() {}
    public function delete() {}
    public function edit() {}
    public function show() {}
    public function store() {}
    public function update() {}

    public function index()
    {
        $this->render('login/login');
    }

    public function login()
    {
        $errors = $this->session->get('errors');
        if ($errors) $this->session->unset('errors');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            Validator::validateLoginFields($login, $password);

            if (!Validator::isValid()) {
                $this->session->set('errors', Validator::getErrors());
                header('Location: ' . $this->url . '/');
                exit();
            }

            try {
                $user = $this->securityService->login($login, $password);
                if (!$user) throw new Exception('auth');

                $this->session->set('user', $user->toArray());
                $this->session->set('typeuser', $user->getId());
                $userType = $user->getTypeUser()->value;

                if ($userType === 'client') {
                    $this->session->set('success', Validator::$fields['success_client']);
                    header('Location: ' . $this->url . '/solde');
                } elseif ($userType === 'serviceCommercial') {
                    $this->session->set('success', Validator::$fields['success_vendeur']);
                } else {
                    $this->session->set('success', Validator::$fields['success_default']);
                    header('Location: ' . $this->url . '/solde');
                }
                exit();
            } catch (Exception $e) {
                $key = $e->getMessage() === 'auth' ? 'auth' : 'system';
                Validator::addError($key, Validator::$fields[$key]);
                $this->session->set('errors', Validator::getErrors());
                header('Location: ' . $this->url . '/');
                exit();
            }
        } else {
            $this->render('login/login', ['errors' => $errors]);
        }
    }

    
    public function Inscription()
    {
        $errors = $_SESSION['errors'] ?? [];
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        $this->render('login/Inscription', [
            'errors' => $errors
        ]);
    }


    public function destroy()
    {
        $this->session->destroy('user');
        header('Location: ' . $this->url . '/');
        exit();
    }

    public static function getInstance()
    {
        return new self();
    }
}