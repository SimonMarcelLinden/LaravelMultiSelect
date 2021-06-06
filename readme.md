# LaravelMultiSelect

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require simonmarcellinden/laravelmultiselect
```

To install all required files run the follow command

``` bash
$ php artisan multiSelect:install
```

### Laravel <= 5.4
Once LaravelMultiSelect is installed you need to register the service provider with the application.
Open up `config/app.php` and find the `providers` key.

Add the service provider to `config/app.php`

```php
    SimonMarcelLinden\LaravelMultiSelect\LaravelMultiSelectServiceProvider::class,
```
Optionally include the Facade in config/app.php if you'd like.

```php
    "LaravelMultiSelect" => "SimonMarcelLinden\LaravelMultiSelect\Facades\LaravelMultiSelect::class",
```

### Publish the configurations

~~Run this on the command line from the root of your project:~~

```
$ no config needed
```

~~A configuration file will be publish to `config/scriptloader.php`.~~

## Usage

Add the following code snippet to your view
```php
<?php 
    <x-multiSelect :values="$labels" />
?>
```
And define in your controller the labels for displaying


```php
<?php 

namespace App\Http\Controllers;

class HomeController extends Controller  {

    public function index() {
        // Defaults labels
        $labels = [
            ['key' => '34123' , 'label' => 'License'],
            ['key' => '34124' , 'label' => 'GitHub Stars'],
            ['key' => '34125' , 'label' => 'Npm Monthly Downloads'],
            ['key' => '34126' , 'label' => 'Full Test Coverage'],
            ['key' => '34127' , 'label' => 'No Dependencies'],
            ['key' => '34128' , 'label' => 'Lorem Ipsum'],
            ['key' => '34129' , 'label' => 'AllPCB'],
            ['key' => '34130' , 'label' => 'DevTools'],
            ['key' => '34131' , 'label' => '@Deprecated'],
            ['key' => '34132' , 'label' => 'VueJS'],
            ['key' => '34133' , 'label' => 'Laravel'],
        ];        
        
        return view('welcome', ['labels' => $labels]);
    }
}
?>
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email inof@snerve.de instead of using the issue tracker.

## Credits

- [Simon Marcel Linden][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/simonmarcellinden/laravelmultiselect.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/simonmarcellinden/laravelmultiselect.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/simonmarcellinden/laravelmultiselect/master.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/simonmarcellinden/laravelmultiselect
[link-downloads]: https://packagist.org/packages/simonmarcellinden/laravelmultiselect
[link-travis]: https://travis-ci.org/simonmarcellinden/laravelmultiselect
[link-author]: https://github.com/simonmarcellinden
[link-contributors]: ../../contributors
