<p align="center"><img src="https://cloud.githubusercontent.com/assets/11228182/22874613/07031906-f1ed-11e6-8951-d96b9d9274c6.png"></p>

<p align="center">
<a href="https://packagist.org/packages/lubusin/laravel-mojo"><img src="https://poser.pugx.org/lubusin/laravel-mojo/v/stable" alt="Latest Stable Version"></a>
<a href="https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/build-status/master"><img src="https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/badges/build.png?b=master" alt="Build Status"></a>
<a href="https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/?branch=master"><img src="https://scrutinizer-ci.com/g/lubusIN/laravel-mojo/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://insight.sensiolabs.com/projects/8ae22c91-5ce0-4d38-be01-8432bb2f6e1c"><img src="https://img.shields.io/badge/Check-Platinum-brightgreen.svg" alt="SensioLabs Insight"></a>
<a href="https://packagist.org/packages/lubusin/laravel-mojo"><img src="https://poser.pugx.org/lubusin/laravel-mojo/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/lubusin/laravel-mojo"><img src="https://poser.pugx.org/lubusin/laravel-mojo/license" alt="License"></a>
</p>

## Introduction

Laravel Mojo provides an expressive, fluent interface to [Instamojo's](https://instamojo.com) online payments and refund services. It handles almost all of the boilerplate payment code you are dreading writing and are unable to watch next episode of Narcos because of the same. In addition to the basic payments and refunds management, Mojo stores all the tansactions & refunds details with him and gives them to you as you ask (No you don't even need to shout Ok google for that). 

> **If you are upgrading from v1 to v2 please checkout the [changelog](https://github.com/lubusIN/laravel-mojo/blob/master/changelog.md)**

Here are a few short examples of what you can do:
```php
$instamojoFormUrl = Mojo::giveMeFormUrl($user,$amount,$purpose);

return redirect($instamojoFormUrl);
```
That's it for making the payment, also it gets you the payment details after the payment with the same breeze:
```php
$details = Mojo::giveMePaymentDetails();
```
My 3 most favourites out of all the helpers
```php
$income = Mojo::myAndMojosIncome(); // Total amount including Instamojo's fees

$income = Mojo::myIncome(); // Total amount excluding Instamojo's fees

$income = Mojo::mojosIncome(); // Instamojo's total fees
```

Much more in the [documentation](https://github.com/lubusIN/laravel-mojo/wiki)

## Documentation
You'll find the entire documentation & the spoiler for Narcos season 3 in the [WIKI](https://github.com/lubusIN/laravel-mojo/wiki).
Since thats why the wiki is made for! But, no one cares sigh...

Stuck somewhere using the laravel mojo, any feature requests, or a TV series recommendation? Feel free to [create an issue on gitHub](https://github.com/lubusIN/laravel-mojo/issues), I'll try to address it as soon as possible.

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
    Lubusin\Mojo\MojoServiceProvider::class,
];
```

You can run the migrations for both transactions and refunds details after registering the service provider with:
```bash
php artisan migrate
```

You can publish the config-file "laravelmojo.php" with:
```bash
php artisan vendor:publish --provider="Lubusin\Mojo\MojoServiceProvider"
```

A file "laravelmojo.php" would be published in the config directory. Make sure to fill in the correct config values in your .env file before proceeding.

> **After successful installation, continue with the documentation [here](https://github.com/lubusIN/laravel-mojo/wiki/1.-Prerequisites)**

## Contributing

Thank you for considering contributing to the Laravel Mojo. You can read the contribution guide lines [here](contributing.md)

## Security

If you discover any security related issues, please email to [harish@lubus.in](mailto:harish@lubus.in) instead of using the issue tracker.

## Credits

- [Harish Toshniwal](https://github.com/introwit)

## About LUBUS
LUBUS is a web design agency based in Mumbai. More about us could be found here [on our website](http://lubus.in).

## License
Laravel Mojo is open-sourced software licensed under the [MIT license](LICENSE.txt)

## Changelog
Please see the [Changelog](https://github.com/lubusIN/laravel-mojo/blob/master/changelog.md) for the details
