# AGENT.md - Development Guide

## Commands
- **Composer Install**: `composer install`
- **Database Migration**: `composer run database:migrate` 
- **Database Seeding**: `composer run database:seed`
- **Docker Build**: `docker-compose up --build`
- **Local Server**: `php -S localhost:8000 -t public`

## Architecture
- **Framework**: Custom PHP MVC with dependency injection container
- **Database**: PostgreSQL with custom migration system
- **Structure**: PSR-4 autoloaded (`src/` namespace mapping)
- **Entry Point**: `bootstrap.php` → `App::run()` → Router
- **Dependencies**: Managed via `config/service.yaml` and App container

## Code Style
- **Namespace**: App\Controller, App\Entity, App\Service, App\Core
- **Controllers**: Extend AbstracteController, methods match route definitions
- **Naming**: camelCase methods, PascalCase classes
- **Routes**: Defined in `route/route.web.php` array format
- **Middleware**: Auth middleware for protected routes
- **Database**: Uses AbstracteRipository pattern
- **Environment**: `.env` file loaded via vlucas/phpdotenv
