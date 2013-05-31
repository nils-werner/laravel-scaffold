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

## Usage

After installing, pick any of your existing `Eloquent` models and view its scaffolding view by navigating to

    http://host/scaffold/<handle>

where `<handle>` is the lowercase name of your model. See section `Configuration` if any of your table fields
contain special data like a file upload or relations.

## Concept

This bundle primarily exists of the following parts:

 - `routes.php`
 - `controllers/ScaffoldController.php`
 - `views/*.blade.php`
 - `NilsWerner/Scaffold/Fields/*`

It's in `ScaffoldController` where most of the magic happens:

 1. Deduct the model name from the URL and see if it exists
 2. Fetch the schema of the table associated with the model
 3. Process and display the data and the schema in a table or a form

All files in `NilsWerner/Scaffold/Fields/` contain the specific codebase for each fieldtype to be displayed
and processed.

## Configuration

Each `Model` can configure an array of columns and fields it wants to show in the scaffolding view:

```php
public $columns = ['realname'];
public $fields = ['realname', 'email'];
```

You can also manipulate the type of input field and logic to be used for each field:

```php
public $fields = ['realname', 'email', 'avatar' => 'upload', 'active' => 'checkbox'];
```

This will ask `NilsWerner\Scaffold\Fields\Upload` and `NilsWerner\Scaffold\Fields\Checkbox` to render the input view, as opposed to the default `NilsWerner\Scaffold\Fields\String` etc.

### Relations

Relations can be showed by simply using the `relation` type in your Model fields:

```php
public $fields = ['user' => 'relation', 'comments' => 'relation', 'title', 'body'];
```

The type of relation will automatically be figured out. The name of the field must represent the relation method used in the Model.

### Adding new fields

In order to implement new field types, you need to create a Class that inherits from `NilsWerner\Scaffold\Fields\Field`:

```php
class Somefield extends NilsWerner\Scaffold\Fields\Field {
    public function input()
    {
        return Illuminate\Support\Facades\Form::checkbox($this->handle());
    }
}
```

and bind it to the alias you want to use:

```php
App::bind('Scaffold\Fields\Somefield', function($app, $handle)
{
    return new Fields\Somefield($app, $handle);
});
```

## Data Manipulation

You can then use the type `somefield` in the `$fields` array in your model.

Additionally, you can use Eloquent ORM getters and setters to manipulate the input received from the form, i.e. `Hash::make()` a password when saving and only display a blank field when editing:

```php
public function setPasswordAttribute($value)
{
    if($value != "")
    $this->attributes['password'] = Hash::make($value);
}

public function getPasswordAttribute($value)
{
    return "";
}
```