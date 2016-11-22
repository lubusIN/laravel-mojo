# Laravel package to process transactions with Instamojo

[![Latest Stable Version](https://poser.pugx.org/lubusin/laravel-mojo/v/stable)](https://packagist.org/packages/lubusin/laravel-mojo)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/build-status/master)
[![Total Downloads](https://poser.pugx.org/lubusin/laravel-mojo/downloads)](https://packagist.org/packages/lubusin/laravel-mojo)
[![License](https://poser.pugx.org/lubusin/laravel-mojo/license)](https://packagist.org/packages/lubusin/laravel-mojo)

## Introduction
![github-header](https://cloud.githubusercontent.com/assets/11228182/20463744/25754186-af60-11e6-9a48-543347a52c7f.jpg)

Laravel Mojo provides an expressive, fluent interface to [Instamojo's](https://instamojo.com) online payments and refund services. It handles almost all of the boilerplate payment code you are dreading writing and are unable to watch next episode of Narcos because of the same. In addition to the basic payments and refunds management, Mojo stores all the tansactions & refunds details with him and gives them to you as you ask (No you don't even need to shout Ok google for that). 


Here are a few short examples of what you can do:
```php
$Payment_page = Mojo::go($user,$amount,$purpose);

return redirect($Payment_page);
```
That's it for making the payment, also it gets you the payment details with the same breeze:
```php
$details = Mojo::done();
```
My 3 most favourites out of all the helpers
```php
$income = Mojo::myAndMojosIncome(); // Total amount including Instamojo's fees

$income = Mojo::myIncome(); // Total amount excluding Instamojo's fees

$income = Mojo::mojosIncome(); // Instamojo's total fees
```

You can find many more such mojo helpers in the [documentation](https://github.com/lubusIN/laravel-mojo/wiki)

## Documentation
You'll find the entire documentation & the spoiler for Narcos season 3 in the [WIKI](https://github.com/lubusIN/laravel-mojo/wiki).
Since thats why the wiki is made for! But, no one cares sigh...

Stuck somewhere using the laravel mojo, any feature requests, or tinder username? Feel free to [create an issue on gitHub](https://github.com/lubusIN/laravel-mojo/issues), I'll try to address it as soon as possible.

Things coming in v2 :
- Webhook Support
- Auto PDF generation
- Some bugs to fix in v3

## Installation

> **Enable the CURL extension in order to use this package**

You can install this package via composer using this command:

```bash
composer require lubusin/laravel-mojo
```

Next, you must add the service provider:

```php
// config/app.php
'providers' => [
    ...
    Lubus\Mojo\MojoServiceProvider::class,
];
```

You can publish the migrations for both transactions and refunds details with:
```bash
php artisan vendor:publish --provider="Lubus\Mojo\MojoServiceProvider" --tag="migrations"
```

After the migrations have been published you can create both the tables in the database by running the migrations:

```bash
php artisan migrate
```

You can publish the config-file "laravelmojo.php" with:
```bash
php artisan vendor:publish --provider="Lubus\Mojo\MojoServiceProvider" --tag="config"
```

A file "laravelmojo.php" would be published in the config directory. Make sure to fill in the correct config values and then proceed 

> **After successful installation, continue with the documentation [here](https://github.com/lubusIN/laravel-mojo/wiki/1.-Prerequisites)**

## Contributing

Thank you for considering contributing to the Laravel Mojo. You can read the contribution guide lines [here](contributing.md)

## Security

If you discover any security related issues, please email to [haristoshniwal@gmail.com](mailto:haristoshniwal@gmail.com) instead of using the issue tracker.

## Credits

- [Harish Toshniwal](https://github.com/harishtoshniwal)

## About LUBUS
LUBUS is a web design agency based in Mumbai. More about us could be found here [on our website](http://lubus.in).

## License
Laravel Mojo is open-sourced software licensed under the [MIT license](LICENSE.txt)

## Changelog
Please see the [Changelog](https://github.com/lubusIN/laravel-mojo/blob/master/changelog.md) for the details