# URL Shortener and Redirect System

## Description
A powerful URL shortening and redirect management system built with PHP 8.1.

## Requirements
- PHP 8.1+
- MySQL 8.0+
- Redis 6.0+
- Nginx

## Installation
1. Clone the repository:
```bash
git clone https://github.com/romanus1983/redirect.git
```

2. Install dependencies:
```bash
composer install --no-dev --optimize-autoloader
```

3. Copy `.env.example` to `.env` and configure:
```bash
cp .env.example .env
```

4. Set up the database:
```bash
php install/install.php
```

## Development
- Use feature branches for new features
- Follow PSR-12 coding standards
- Write descriptive commit messages

## Deployment
Deployment is handled through Git:
1. Push changes to main branch
2. Pull changes on production server
3. Run composer install if needed
4. Clear cache

## Backup
Automatic backups are configured to run daily

## Security
- All user input is sanitized
- CSRF protection enabled
- XSS prevention implemented
