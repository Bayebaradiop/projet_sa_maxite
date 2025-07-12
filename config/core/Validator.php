<?php
namespace App\Core;

class Validator
{
    private static array $errors = [];

    // Ajoute ici le tableau des messages d'erreur
    public static array $fields = [
        'nom' => 'Le nom est obligatoire.',
        'prenom' => 'Le prénom est obligatoire.',
        'login' => 'Le login est obligatoire.',
        'password' => 'Le mot de passe est obligatoire.',
        'adresse' => 'L\'adresse est obligatoire.',
        'numeroCarteidentite' => 'Le numéro de carte d\'identité est obligatoire.',
        'numerotel' => 'Le numéro de téléphone est obligatoire.',
        'photorecto' => 'La photo recto est obligatoire.',
        'photoverso' => 'La photo verso est obligatoire.',
        'auth' => 'Identifiants incorrects',
        'system' => 'Une erreur est survenue lors de la connexion',
        'success_client' => 'Connexion réussie ! Bienvenue sur votre espace client.',
        'success_vendeur' => 'Connexion réussie ! Bienvenue sur votre espace vendeur.',
        'success_default' => 'Connexion réussie !'
    ];

    public static function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function isEmpty(string $value): bool
    {
        return trim($value) === '';
    }

    public static function getErrors(): array
    {
        return self::$errors;
    }

    public static function addError(string $field, string $message): void
    {
        self::$errors[$field][] = $message;
    }

    public static function isValid(): bool
    {
        return empty(self::$errors);
    }

    public static function resetErrors(): void
    {
        self::$errors = [];
    }

    public static function isValidPhone(string $phone): bool
    {
        return preg_match('/^(77|78|76|70|75)[0-9]{7}$/', $phone);
    }

    public static function isValidCni(string $cni): bool
    {
        return preg_match('/^[0-9]{13}$/', $cni);
    }

    // Nouvelle méthode pour valider un tableau de champs
    public static function validateFields(array $fields, array $data, array $files = []): void
    {
        foreach ($fields as $key => $message) {
            if ($key === 'photorecto' || $key === 'photoverso') {
                if (empty($files[$key]['name'] ?? '')) {
                    self::addError($key, $message);
                }
            } else {
                if (self::isEmpty($data[$key] ?? '')) {
                    self::addError($key, $message);
                }
            }
        }
    }

    public static function validateInscription(array $data, array $files, $compteService): void
    {
        self::validateFields(self::$fields, $data, $files);

        if (!self::isEmpty($data['numerotel'] ?? '')) {
            if (!self::isValidPhone($data['numerotel'])) {
                self::addError('numerotel', 'Le numéro de téléphone n\'est pas valide.');
            }
            if (!$compteService->isPhoneUnique($data['numerotel'])) {
                self::addError('numerotel', 'Ce numéro de téléphone existe déjà.');
            }
        }

        if (!self::isEmpty($data['numeroCarteidentite'] ?? '')) {
            if (!self::isValidCni($data['numeroCarteidentite'])) {
                self::addError('numeroCarteidentite', 'Le numéro de CNI n\'est pas valide (13 chiffres).');
            }
            if (!$compteService->isCniUnique($data['numeroCarteidentite'])) {
                self::addError('numeroCarteidentite', 'Ce numéro de CNI existe déjà.');
            }
        }
    }
    public static function validateLogin(string $login, string $password): void
    {
        if (self::isEmpty($login)) {
            self::addError('login', 'Le login est obligatoire');
        }
        if (self::isEmpty($password)) {
            self::addError('password', 'Le mot de passe est obligatoire');
        }
    }
    public static function validateLoginFields(string $login, string $password): void
    {
        self::resetErrors();

        if (self::isEmpty($login)) {
            self::addError('login', self::$fields['login']);
        }
        if (self::isEmpty($password)) {
            self::addError('password', self::$fields['password']);
        }
    }
}
