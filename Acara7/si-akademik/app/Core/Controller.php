<?php

// Base Controller: helper umum untuk semua controller
abstract class Controller
{
    // Tampilkan view. $layout = null berarti view berdiri sendiri (mis. halaman login)
    protected function view(string $name, array $data = [], ?string $layout = 'main'): void
    {
        extract($data);

        $viewFile = APP_PATH . '/Views/' . $name . '.php';

        if ($layout === null) {
            require $viewFile;
            return;
        }

        $view = $viewFile;
        require APP_PATH . '/Views/layouts/' . $layout . '.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    // Cek token CSRF dari form POST; jika tidak cocok, kembali ke halaman $backTo
    protected function verifyCsrf(string $backTo): void
    {
        $sent  = $_POST['_token'] ?? '';
        $saved = $_SESSION['_token'] ?? '';

        if ($saved === '' || !hash_equals($saved, $sent)) {
            $this->flash('danger', 'Sesi form tidak valid. Silakan coba lagi.');
            $this->redirect($backTo);
        }
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }
}