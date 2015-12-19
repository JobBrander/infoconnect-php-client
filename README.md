# Infoconnect PHP Client
Infoconnect provides some excellent company and personnel data that you can access
via their API. This wrapper makes it easy to connect to and use their data in a
PHP application. See more information about the Infoconnect API
[here](http://developer.infoconnect.com/apis).

*Note: This project is still a work in progress
and may change frequently. Be aware of this if 
you decide to use it in production, and
please let me know if you'd like to contribute.*

## Installation

To install, use composer:

```
composer require jobbrander/infoconnect-php-client
```

## Usage

### Get Company by ID

```php
$client = new new InfoconnectClient(['apiKey' => XXX]);

$id = '826381212';

$result = $client->getCompany($id);

var_dump($result);
```

## Testing

Unit testing is important. If you're going to make a pull request against this library, 
please be sure to write some tests as well.

#### Running Tests
- Run the PHPUnit test suite: `APIKEY=<YOUR API KEY> phpunit`
- Run the PHPUnit tests with code coverage report `APIKEY=<YOUR API KEY> phpunit --coverage-text`

## Contributing

Please see [CONTRIBUTING](https://github.com/jobbrander/infoconnect-php-client/blob/master/CONTRIBUTING.md) for details.

## License

The Apache 2.0. Please see [License File](https://github.com/jobbrander/infoconnect-php-client/blob/master/LICENSE.md) for more information.
