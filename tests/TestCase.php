<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setup(): void {
        parent::setup();

        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->withExceptionHandling();
    }
}
