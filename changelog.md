All notable changes to Laravel Mojo will be documented in this file

## v2.0.1 (13-02-2017)
- Indentation fixed

## v2.0 (13-02-2017)

> **PHP 7.0 is now the minimum requirement to use v2.* of Laravel Mojo**

- The vendor name has been updated in all the namespaces to avoid confusions and keep the organisation name & vendor name in sync. So everywhere where you have been using 
```php
use Lubus\Mojo\Mojo;
```
should be changed to 
```php
use LubusIN\Mojo\Mojo;
```

- The Payment details in the database are now updated via Instamojo's webhook , so make sure you have a public POST route added for it. The rest of the logic is now handled by the package itself. Complete docs about the WEBHOOK [here](https://github.com/lubusIN/laravel-mojo/wiki)

- The `go()` function has been renamed to `giveMeFormUrl()`

- The `done()` function has been renamed to `giveMePaymentDetails()`

- The renaming has been done because the new names are what these functions are actually doing. I don't know why I gave those inappropriate names go & done in v1.* Sorry for that!

- In v1.* the `go()` function accepted 3 parameters : The user object , amount & purpose , and the user's phone number had to be a property of the user object. That in v2 has been made flexible. The `giveMeFormUrl()` function in v2 now accepts 4 parameters : The user object , amount , purpose & an optional fourth argument as the phone number. If fourth argument not given , the package will then look for the phone number in the user object.

- WEBHOOK support has been added. How to use the webhook can be found out in the [docs](https://github.com/lubusIN/laravel-mojo/wiki)

- Major performance and dependency improvements

- Better code refactoring

- Game of Thrones season 8 spoiler in the docs

## v1.5 (20-11-2016)
- Initial Stable release
