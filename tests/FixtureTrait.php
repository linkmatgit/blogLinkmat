<?php

namespace App\Tests;

use App\Infrastructure\Helper\PathHelper;

trait FixtureTrait
{
    public function loadsFixtures(array $fixtures): array
    {

        $fixturesPath = $this->getFixturePath();
        $files =  array_map(
            fn ($fixture) =>
            PathHelper::join($fixturesPath, $fixture . '.yaml'),
            $fixtures
        );
        $loader = static::getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        return $loader->load($files);
    }

    public function getFixturePath(): string
    {
        return __DIR__ . '/fixtures/';
    }
}
