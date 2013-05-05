scaffold
========

Scaffolding for Laravel 4 
[![Build Status](https://travis-ci.org/nils-werner/laravel-scaffold.png?branch=master)](https://travis-ci.org/nils-werner/laravel-scaffold)

**Be warned: This is a work in progress. Nothing actually works yet!**

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

## Concept

Most of the code here is just a package wrapper so the important components don't have to be in `/app`:

 - `routes.php`
 - `controllers/ScaffoldController.php`
 - `views/*.blade.php`

It's in `ScaffoldController` where most of the magic happens:

 1. Deduct the model name from the URL and see if it exists
 2. Fetch the schema of the table associated with the model
 3. Process and display the data and the schema in a table or a form

## Configuration

Each `Model` can configure an array of columns and fields it wants to show in the scaffolding view:

```php
public $columns = ['realname'];
public $fields = ['realname', 'email'];
```

Additionally, you can use Eloquent ORM getters and setters to manipulate the input received from the form, i.e. `Hash::make()` a password when saving and only display "****" when editing:

```php
public function setPasswordAttribute($value)
{
    if($value != "****")
    $this->attributes['password'] = Hash::make($value);
}

public function getPasswordAttribute($value)
{
    return "****";
}
```