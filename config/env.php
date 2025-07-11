<?php



$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

define('WEB_URL', $_ENV['WEB_URL']);
define("DB_HOST", $_ENV["DB_HOST"]);
define("DB_PORT", $_ENV["DB_PORT"]);
define("DB_DATABASE", $_ENV["DB_DATABASE"]); 
define("DB_USERNAME", $_ENV["DB_USERNAME"]); 
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);
define("TWILIO_SID", $_ENV["TWILIO_SID"]);
define("TWILIO_TOKEN", $_ENV["TWILIO_TOKEN"]);
define("TWILIO_FROM", $_ENV["TWILIO_FROM"]);