<?php

namespace App\Controllers;

use App\Repositories\UserRepository;

class AuthController
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function showLogin(): string
    {
        $error = null;
        ob_start();
        require __DIR__ . '/../Views/login.php';
        return ob_get_clean();
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if ($email === '' || $password === "") 
        {
            $error = "Vul een e-mail en wachtwoord in!";
            ob_start();
            require __DIR__ . '/../Views/login.php';
            echo ob_get_clean();
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $error = "Ongeldig e-mailadres.";
            ob_start();
            require __DIR__ . '/../Views/login.php';
            echo ob_get_clean();
            return;
        }

        $user = $this->users->findByEmail($email);

        if (!$user || !password_verify($password, (string)$user->passwordHash))
        {
            $error = 'Onjuiste login.';
            ob_start();
            require __DIR__ . '/../Views/login.php';
            echo ob_get_clean();
            return;
        }

        $_SESSION['user_id'] = (int)$user->id;
        $_SESSION['role'] = (string)$user->role;

        $this->redirect('/dashboard');

    }

    public function showRegister(): string
    {
        $error = null;
        ob_start();
        require __DIR__ . '/../Views/register.php';
        return ob_get_clean();
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if ($name === '' || $email === '' || $password === '') {
            $error = 'Vul alle velden in.';
            ob_start();
            require __DIR__ . '/../Views/register.php';
            echo ob_get_clean();
            return;
        }

        if (mb_strlen($name) < 2 || mb_strlen($name) > 100) 
        {
            $error = 'Naam moet tussen 2 en 100 tekens zijn.';
            ob_start();
            require __DIR__ . '/../Views/register.php';
            echo ob_get_clean();
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Ongeldig e-mailadres.';
            ob_start();
            require __DIR__ . '/../Views/register.php';
            echo ob_get_clean();
            return;
        }

        if (strlen($password) < 8) {
            $error = 'Wachtwoord moet minimaal 8 tekens zijn.';
            ob_start();
            require __DIR__ . '/../Views/register.php';
            echo ob_get_clean();
            return;
        }

        if ($this->users->findByEmail($email)) {
            $error = 'E-mail bestaat al.';
            ob_start();
            require __DIR__ . '/../Views/register.php';
            echo ob_get_clean();
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->users->create($name, $email, $hash);

        $_SESSION['user_id'] = $userId;
        $_SESSION['role'] = 'user';

        $this->redirect('/dashboard');

    }
    
    public function logout(): void
    {
        session_destroy();
        $this->redirect('/login');
    }

    private function redirect(string $path): void
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header("Location: {$path}");
        exit;
    }

}