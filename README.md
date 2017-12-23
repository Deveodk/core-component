[![Build Status](https://travis-ci.org/Deveodk/core-component.svg?branch=master)](https://travis-ci.org/Deveodk/core-component)
[![Coverage Status](https://coveralls.io/repos/github/Deveodk/core-component/badge.svg?branch=master)](https://coveralls.io/github/Deveodk/core-component?branch=master)
[![Coding Standards](https://img.shields.io/badge/cs-PSR--2--R-yellow.svg)](https://github.com/php-fig-rectified/fig-rectified-standards)
[![Latest Stable Version](https://poser.pugx.org/deveodk/core-component/v/stable)](https://packagist.org/packages/deveodk/core-component)
[![Total Downloads](https://poser.pugx.org/deveodk/core-component/downloads)](https://packagist.org/packages/deveodk/core-component)
[![License](https://poser.pugx.org/deveodk/core-component/license)](https://packagist.org/packages/deveodk/core-component)
# Core components

| for use with Core by deveo

## Requirements

This package requires the following:

* Composer
* PHP 7.1 / 7.2
* Core by deveo

## Installation

```bash
composer require deveodk/core-components
```


## Disclaimer

Core components is a opinionated approach to designing API´s.
Every component is specifically designed for Core and therefore is not compatible with other frameworks. Not even standard Laravel.


## What it does

Core component divides the Laravel class based directory structure into a domain based one.
What this essentially allows us to have what we call a bundle with an contained logic.

Example of this structure:

<pre>

•
├── api
│   ├── User
│   │   ├── Controllers
│   │   ├── Entitites
│   │   ├── Models
│   │   ├── Repositories
│   │   ├── ResourceTransformers
│   │   ├── Services
│   │   ├── Jobs
│   │   ├── Exceptions
│   │   └── routes.php
│   └── Customer
│       ├── Controllers
│       ├── Entitites
│       ├── Models
│       ├── Repositories
│       ├── ResourceTransformers
│       ├── Services
│       ├── Jobs
│       ├── Exceptions
│       └── routes.php
├── infrastructure
│   ├── Console
│   ├── Events
│   ├── Exceptions
│   ├── Http
│   ├── Jobs
│   └── Providers
├── integrations
│   └── GoogleAnalytics
│       ├── Controllers
│       ├── Entitites
│       ├── Models
│       ├── Repositories
│       ├── ResourceTransformers
│       ├── Services
│       ├── Jobs
│       ├── Exceptions
│       └── routes.php
├── resources // This folder is present cause of compatability with laravel eco system.
├── public
├── storage
└── tests
</pre>

## Routing

When using the bundle logic we need to place our routes in quite a different maner than usual.

To create a new route simply place it in the bundle.

example: 

Lets say we have a bundle named ``` User ``` and we want to create a new route we can do it in two ways

Creating a ``` routes.php ``` file or creating a ``` routes_public.php ``` file

the content of the files would be as following

```php
// The $router variable automaticly gets injected
// Core Components knows the current namespace so you dont need to specify it in the controller part.

$router->get('/users', 'UserController@findAll');
```

``` routes.php``` 
* This file is intended for protected endpoints. 
* The middlewares are configurale under ``` config->core->components['protection_middleware'] ```

``` routes_public.php ```
* This file is intended for use with public accessable endpoints
* The middlewares are configurale under ``` config->core->components['middleware'] ```

## View files

Using view files in Core Component is just as simple as using standard Laravel.

You can use any of the standard helpers with only a slight modification in syntax

### View loading syntax


```php
// Getting bundle view file
view('{bundleName}:{pathToView}')
```

```php
// Getting regular resources view file
view('{pathToView}')
```


example 1:


Lets say we need to get a view file named ``` list.blade.php ``` in the ``` User ``` bundle

```php
// Always use lowercase letters
view('user:list')
```

example 2:

Lets say we need to get a view file named ``` welcome-email.blade.php ``` in the ``` resources ``` directory

```php
// Just the regular Laravel syntax
view('welcome-email.php')
```

## Translation files

Dealing with translations can be quite the pain. Primarily due to the enormous language files commonly seen.
Here we can benefit from the bundle structure. Each bundle can have their own translation files, the translation file name doesn't have to be unique meaning that.

If we have two bundles:

- NiceBundle

- NotSoNiceBundle

each bundle can have their own separate ``` explenation.php ```

Using view files in Core Component is just as simple as using standard Laravel.

You can use any of the standard helpers with only a slight modification in syntax

### Tranlslation loading syntax:

```php
// Getting bundle translation file
view('{bundleName}:{pathToTranslation}')
```

```php
// Getting regular resources translation file
view('{pathToTranslation}')
```


example 1:


Lets say we need to get a translation file named ``` exceptions.php ``` in the ``` User ``` bundle with the key ``` title```

```php
// Always use lowercase letters
__('user:exceptions.title')
```

example 2:

Lets say we need to get a view file named ``` exceptions.php ``` in the ``` resources ``` directory with the key ``` title ```

```php
// Just the regular Laravel syntax
__('exceptions.title')
```
