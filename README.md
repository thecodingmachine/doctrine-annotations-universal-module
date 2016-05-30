[![Build Status](https://travis-ci.org/thecodingmachine/doctrine-annotations-universal-module.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/doctrine-annotations-universal-module)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/doctrine-annotations-universal-module/badge.svg?branch=1.0&service=github)](https://coveralls.io/github/thecodingmachine/doctrine-annotations-universal-module?branch=1.0)


# PSR6 to Doctrine cache universal module

This package integrates [doctrine/annotations](https://github.com/doctrine/annotations) (the Doctrine annotation library) in any [container-interop/service-provider](https://github.com/container-interop/service-provider) compatible framework/container.

## Installation

```
composer require thecodingmachine/doctrine-annotations-universal-module
```

Once installed, you need to register the [`TheCodingMachine\DoctrineAnnotationsServiceProvider`](src/DoctrineAnnotationsServiceProvider.php) into your container.

If your container supports Puli integration, you have nothing to do. Otherwise, refer to your framework or container's documentation to learn how to register *service providers*.

## Introduction

This service provider will provide a default Doctrine AnnotationReader implementation. It will use a Doctrine cache if the cache is available.

Note: you can get a service provider providing a working Doctrine cache using the following packages:
 
```
composer require thecodingmachine/stash-universal-module
composer require thecodingmachine/psr-6-doctrine-bridge-universal-module
```

This will install Stash and its related service-provider and a PSR-6 to Doctrine cache bridge.

### Usage

```php
use Doctrine\Common\Annotations\AnnotationReader;

$annotationReader = $container->get(AnnotationReader::class);
```

### Default behaviour

This service provider will lookup for a `Doctrine\Common\Cache\Cache` service. If available, this cache system will be used to cache annotations.

## Expected values / services

This *service provider* expects the following configuration / services to be available:

| Name            | Compulsory | Description                            |
|-----------------|------------|----------------------------------------|
| `Doctrine\Common\Cache\Cache` | *no* | A Doctrine cache.  |
| `thecodingmachine.stash-universal-module.debug` | *no* | Whether debug mode is enabled or not. Defaults to `true`. In debug mode, cache is invalidated with a PHP file changes.  |


## Provided services

This *service provider* provides the following services:

| Service name                | Description                          |
|-----------------------------|--------------------------------------|
| `Doctrine\Common\Annotations\AnnotationReader` | A Doctrine annotation reader instance.  |

## Extended services

This *service provider* does not extend any service.
