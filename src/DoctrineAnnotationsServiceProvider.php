<?php

namespace TheCodingMachine;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Interop\Container\ContainerInterface;
use Interop\Container\Factories\Alias;
use Interop\Container\ServiceProvider;

class DoctrineAnnotationsServiceProvider implements ServiceProvider
{
    public function getServices()
    {
        return [
            Reader::class => [self::class,'createAnnotationReader'],
        ];
    }

    public static function createAnnotationReader(ContainerInterface $container) : Reader
    {
        $loader = self::getComposerAutoloader();

        AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

        // Creating a new AnnotationReader
        $reader = new AnnotationReader();

        if ($container->has('Doctrine\Common\Cache\Cache')) {
            $cache = $container->get('Doctrine\Common\Cache\Cache');

            if ($container->has('thecodingmachine.stash-universal-module.debug')) {
                $debug = $container->has('thecodingmachine.stash-universal-module.debug');
            } else {
                $debug = true;
            }

            return new CachedReader($reader, $cache, $debug);
        } else {
            return $reader;
        }
    }

    private static function getComposerAutoloader() {
        if (file_exists(__DIR__ . '/../../../../vendor/autoload.php')) {
            return require __DIR__ . '/../../../../vendor/autoload.php';
        } elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
            // For unit tests
            return require __DIR__ . '/../vendor/autoload.php';
        } else {
            throw new DoctrineAnnotationsServiceProviderException('Could not find Composer autoload file');
        }
    }
}
