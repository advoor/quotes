# Quotes
This is a simple API to retrieve quotes. At the moment this is limited to Kanye quotes.

## Requirements
- PHP 8.3
- Git
- Composer

## Install
```bash
git clone git@github.com:advoor/quotes.git
cd quotes
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

In this example I am using `quotes.test` as the domain. You can change this in the `.env` file.

## Authentication
To create a user and retrieve a token run the following command:
```bash
php artisan app:create-user
```

Keep the token safe, you will need it to access the API!

If you need to create a new token for an existing user, you can make the following request with your login credentials:
```curl
curl --location 'http://quotes.test/api/user' \
--header 'Accept: application/json' \
--form 'email="test@example.com"' \
--form 'password="Password1\!"'
```

Using the token, you can validate it by making the following request, which will return the user details:
```curl
curl --location 'http://quotes.test/api/user' \
--header 'Authorization: Bearer [TOKEN]'
```

## API
The quotes are retrieved from the [Kanye Rest API](https://kanye.rest/).

In order to get a quote you can make the following request:
```curl
curl --location 'http://quotes.test/api/quotes' \
--header 'Authorization: Bearer [TOKEN]'
```

By default, the API will return 5 quotes. This can be configured in `config/quote.php`.

These quotes are cached for 10 minutes to prevent excessive requests to the Kanye Rest API. If however you want to always retrieve a new quote you can add the `?refresh=true` query parameter to the request:
```curl
curl --location 'http://quotes.test/api/quotes?refresh=true' \
--header 'Authorization: Bearer [TOKEN]'
```

## Testing
To run the tests, you can use the following command:
```bash
php artisan test
```

## Notes
This API implementation is a simple example and is not intended for production use. It is a demonstration of how to create a simple API with Laravel that was completed with a short limit of time.

There are multiple improvements that can be made, such as:
- Using a proper authentication system such as Sanctum or Passport
- Adding more robust validation
- Adding some unit tests (limited myself early on by using configs within the driver class, so unit tests were not possible). 
