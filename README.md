[![Build Status](https://travis-ci.com/Deveodk/core-component.svg?token=5PQPvas2tsQp4Fy3pVoP&branch=master)](https://travis-ci.com/Deveodk/core-component)
[![Coverage Status](https://coveralls.io/repos/github/Deveodk/core-component/badge.svg?branch=master)](https://coveralls.io/github/Deveodk/core-component?branch=master)

# Core components

| for use with laravel 5.5+

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
