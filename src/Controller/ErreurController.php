<?php



namespace App\Controller;

class ErreurController
{

    public function erreur404()
    {
        include __DIR__ . '/../../Template/erreu/erruer.php';
    }

    public static function getInstance()
    {
        return new self();
    }
}
