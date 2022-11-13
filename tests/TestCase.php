<?php

namespace Tests;

use Http;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Notification;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();


        Notification::fake();
        Http::preventStrayRequests();

    }
}
