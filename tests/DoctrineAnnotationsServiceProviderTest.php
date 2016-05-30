<?php

namespace TheCodingMachine;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\VoidCache;
use Simplex\Container;

class DoctrineAnnotationsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testReader()
    {
        $simplex = new Container();
        $simplex->register(new DoctrineAnnotationsServiceProvider());

        $reader = $simplex->get(Reader::class);
        $this->assertInstanceOf(Reader::class, $reader);

    }

    public function testCachedReader()
    {
        $simplex = new Container();
        $simplex->register(new DoctrineAnnotationsServiceProvider());
        $simplex[Cache::class] = function() {
            return new VoidCache();
        };

        $reader = $simplex->get(Reader::class);
        $this->assertInstanceOf(CachedReader::class, $reader);

    }

    public function testNoDebugCachedReader()
    {
        $simplex = new Container();
        $simplex->register(new DoctrineAnnotationsServiceProvider());
        $simplex[Cache::class] = function() {
            return new VoidCache();
        };
        $simplex['thecodingmachine.stash-universal-module.debug'] = false;

        $reader = $simplex->get(Reader::class);
        $this->assertInstanceOf(CachedReader::class, $reader);
    }
}
