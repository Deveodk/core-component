[![Build Status](https://travis-ci.com/Deveodk/core-component.svg?token=5PQPvas2tsQp4Fy3pVoP&branch=master)](https://travis-ci.com/Deveodk/core-component)
[![Coverage Status](https://coveralls.io/repos/github/Deveodk/core-component/badge.svg?branch=master)](https://coveralls.io/github/Deveodk/core-component?branch=master)

# Core components

| for use with Core by deveo

## Installation

```bash
composer require deveodk/core-components
```


## Disclaimer

Core components is a opinionated approach to designing API´s.
Every component is specifically designed for Core and therefore is not compatible with other frameworks. Not event standard laravel.

## View files

 Every now and then we are feeling the need to write a beautiful email.
 Laravel provides a brilliant templating engine called blade.
 But Laravel excepts us to put every blade file into the ```resources->views``` directory this however does not comply with our domain specific approach.
 
 Due to compatibility issues we a still in the need to have the ```resources->views``` directory.
 But Core components give you a way to split up views in domains(bundles)
 
 You can just use the ``` view('{bundleName}:{pathToView}') ``` helper which you are used to. So as an example i have a bundle
 
 ``` Api -> TestBundle -> Views -> email.blade.php```
 
 To retrieve this simply write ``` view('TestBundle:email)```

## Translation files

Dealing with translations can be quite the pain. Primarily due to the enormous language files commonly seen.
Here we can benefit from the bundle structure. Each bundle can have their own translation files, the translation file name doesn't have to be unique meaning that.

If we have two bundles:

- NiceBundle

- NotSoNiceBundle

each bundle can have their own separate ``` explanation.php```

To get the specific translation simply use the laravel helper methods:

- ``` trans('{bundleName}:{pathToTranslation}') ```

- ``` __('{bundleName}:{pathToTranslation}') ```

you can still use the helpers as you normally would when not using bundle translations

## Routes

When using laravel we normally define every api route in the api.php file. This file quickly becomes very big and unmaintainable.
So when using Core we apply the same domain specific bundle logic. Therefore when you declare your routes simply create a routes.php / routes_public.php file in the root of your bundle

The ``` routes.php ``` is meant for protected routes and should therefore only contain routes directly related to authenticated users.

The ``` routes_public.php ``` is meant for public routes and should be used for publicly accessible endpoints.

