<?php

namespace App\Core;


class EnvConfig
{
    private static $variables = [];
    private static $initialized = false;

    public static function initialize(): void
    {
        if (self::$initialized) {
            return;
        }

        $path = dirname(__DIR__) . '/.env';
        
        if (file_exists($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value);
                    
                    if (preg_match('/^"(.*)"|\'(.*)\'$/', $value, $matches)) {
                        $value = $matches[1] ?? $matches[2];
                    }
                    
                    if (strtolower($value) === 'true') {
                        $value = true;
                    } elseif (strtolower($value) === 'false') {
                        $value = false;
                    } elseif (strtolower($value) === 'null') {
                        $value = null;
                    }
                    
                    self::$variables[$name] = $value;
                }
            }
        }
        
        self::$initialized = true;
    }

 
    public static function get(string $key, $default = null)
    {
        if (!self::$initialized) {
            self::initialize();
        }
        
        return self::$variables[$key] ?? $default;
    }
}

if (!function_exists('env')) {
 
    function env(string $key, $default = null)
    {
        return EnvConfig::get($key, $default);
    }
}

EnvConfig::initialize();