scaffold
========

Scaffolding for Laravel 4 
[![Build Status](https://travis-ci.org/nils-werner/laravel-scaffold.png?branch=master)](https://travis-ci.org/nils-werner/laravel-scaffold)


## Installation

Add `nils-werner/scaffold` as a requirement to composer.json:

```json
{
    "require": {
        "nils-werner/scaffold": "dev-master"
    },
    "repositories": [
        {
        "type":"vcs",
        "url":"https://github.com/nils-werner/laravel-scaffold"
        }
    ]
}
```

Then run `composer update` or `composer install`

Next step is to tell laravel to load the serviceprovider. In `app/config/app.php` add

```php
  // ...
  'NilsWerner\Scaffold\ScaffoldServiceProvider'
  // ...
```
to the `providers` array.
