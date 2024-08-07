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

# Authentication
To create a user and retrieve a token run the following command:
```bash
php artisan app:create-user
```

Keep the token safe, you will need it to access the API.

If you need to create a new token for an existing user, you can make the following request:
```curl
curl --location 'http://quotes.test/api/user' \
--header 'Accept: application/json' \
--form 'email="test@example.com"' \
--form 'password="Password1\!"'
```

Using the token you can validate it by making the following request:
```curl
curl --location 'http://quotes.test/api/user' \
--header 'Authorization: Bearer [TOKEN]'
```
