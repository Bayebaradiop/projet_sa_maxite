<?php
namespace App\Core;

class Validator
{

    
    private static array $errors = [];

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
        // Exemple : CNI sénégalais = 13 chiffres
        return preg_match('/^[0-9]{13}$/', $cni);
    }
}
