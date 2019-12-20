# ibus_task

## Getting Started
### Installing
Clone project by running command:
```
git clone https://github.com/explod3r/ibus_task.git
```
When finished run command:
```
composer install
```

To start web server run:
```
symfony server:start
```

## Running App
### API
API endpoint url:
```
http://127.0.0.1:8000/api/scraper
```

### JSON validation
To run JSON validation task use command:
```
php bin/console app:validate-json
```

## Additional information
### Built With
* [Symfony 5](https://symfony.com/) - The web framework used
* [duzun/hquery](https://github.com/duzun/hQuery.php) - Web scraper
* [opis/json-schema](https://github.com/opis/json-schema) - JSON schema validator

### Requirements
* PHP 7.2.5
