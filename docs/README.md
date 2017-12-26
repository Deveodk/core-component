[![Build Status](https://travis-ci.org/Deveodk/core-component.svg?branch=master)](https://travis-ci.org/Deveodk/core-component)
[![Coverage Status](https://coveralls.io/repos/github/Deveodk/core-component/badge.svg?branch=master)](https://coveralls.io/github/Deveodk/core-component?branch=master)
[![Coding Standards](https://img.shields.io/badge/cs-PSR--2--R-yellow.svg)](https://github.com/php-fig-rectified/fig-rectified-standards)
[![Latest Stable Version](https://poser.pugx.org/deveodk/core-component/v/stable)](https://packagist.org/packages/deveodk/core-component)
[![Total Downloads](https://poser.pugx.org/deveodk/core-component/downloads)](https://packagist.org/packages/deveodk/core-component)
[![License](https://poser.pugx.org/deveodk/core-component/license)](https://packagist.org/packages/deveodk/core-component)

## Core component

| To be used explicitly with Core by Deveo

## Requirements

This package requires the following:

* Composer
* PHP 7.1 / 7.2
* Core by Deveo

## Installation

Installation via Composer:

```bash
composer require deveodk/core-components
```

## Disclaimer

Core components is an opinionated approach to designing modern Application Programming Interfaces (APIs). Every component is specifically designed to be used with Core by Deveo and is therefore not compatible with other frameworks such as standard Laravel.


## What it does

Core Component divides the Laravel class-based directory structure into a domain based one. This essentially allows us to have what we call a bundle with a contained logic.

**Example of this structure:**

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
├── *resources
├── public
├── storage
└── tests
</pre>

*\* This folder is present because of compatibility with the Laravel ecosystem*

## Routing

When using the bundle logic we need to place our routes in a different way than usual.

To create a new route simply place it in the bundle.

**Example:**

Lets say we have a bundle named ``` User ``` and we want to create a new route. We can do this in two ways:

1. Create a ``` routes.php ``` file
2. Create a ``` routes_public.php ``` file

The content of the files would, in both cases, be:

```php
// The $router variable automatically gets injected
// Core Component knows the current namespace so you don't need to specify it in the controller

$router->get('/users', 'UserController@findAll');
```

**When to use which file?**

* ``` routes.php``` 
   * This file is intended for use with protected endpoints
   * The middlewares are configurable under:  
``` config->core->components['protection_middleware'] ```

* ``` routes_public.php ```
   * This file is intended for use with public accessable endpoints
   * The middlewares are configurable under:  
 ``` config->core->components['middleware'] ```

## View files

Using view files in Core Component is just as simple as using standard Laravel.

You can use any of the standard helpers with only a slight modification in syntax.

### View loading syntax


```php
// Getting bundle view file
view('{bundleName}:{pathToView}')
```

```php
// Getting regular resources view file
view('{pathToView}')
```

**Example #1:**

Let's say we need to get a view file named ``` list.blade.php ``` in the ``` User ``` bundle

```php
// Always use lowercase letters
view('user:list')
```

**Example #2:**

Let's say we need to get a view file named ``` welcome-email.blade.php ``` in the ``` resources ``` directory

```php
// Just the regular Laravel syntax
view('welcome-email.php')
```

## Translation files

Translation handling can be quite a pain. Primarily due to the enormous language files commonly seen. Here we can benefit from the bundle structure. Each bundle can have their own translation file. This makes it far simpler to manage and the translation files don't have to be unique.

**Example:**

If we have two bundles:

- NiceBundle

- NotSoNiceBundle

Each bundle can have their own separate ``` explanation.php ``` file.

As stated before, using view files in Core Component is just as simple as using standard Laravel. You can use any of the standard helpers with only a slight modification in syntax.

### Translation loading syntax:

```php
// Getting bundle translation file
view('{bundleName}:{pathToTranslation}')
```

```php
// Getting regular resources translation file
view('{pathToTranslation}')
```

**Example #1:**

Let's say we need to get a translation file named ``` exceptions.php ``` in the ``` User ``` bundle with ``` title``` as the key

```php
// Always use lowercase letters
__('user:exceptions.title')
```

**Example #2:**

Let's say we need to get a view file named ``` exceptions.php ``` in the ``` resources ``` directory with ``` title ``` as the key

```php
// Just use the regular Laravel syntax
__('exceptions.title')
```