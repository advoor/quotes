# Quotes
This is a simple API to retrieve quotes.

# Requirements
- PHP 8.3
- Git
- Composer

# Install
```bash
git clone git@github.com:advoor/quotes.git
cd quotes
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

# Create user
To create a user and retrieve a token run the following command:
```bash
php artisan app:create-user
```

Keep the token safe, you will need it to access the API.
