<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Mpociot\Reauthenticate\Middleware\Reauthenticate;
use PHPUnit\Framework\Assert;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker, DatabaseTransactions;

    /**
     * @param object $instance
     * @param string $method
     * @param array $arguments
     * @return object
     * @throws \ReflectionException
     */
    protected function invokePrivateMethod($instance, $method, array $arguments = [])
    {
        $reflection = new \ReflectionClass($instance);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($instance, $arguments);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(Reauthenticate::class);

        TestResponse::macro('url', function () {
            return json_decode(json_encode($this->original->getData()['page']['url']), JSON_OBJECT_AS_ARRAY);
        });

        TestResponse::macro('assertUrl', function ($value) {
            Assert::assertEquals($value, $this->url());

            return $this;
        });

        TestResponse::macro('component', function () {
            return json_decode(json_encode($this->original->getData()['page']['component']), JSON_OBJECT_AS_ARRAY);
        });

        TestResponse::macro('assertComponent', function ($value) {
            Assert::assertEquals($value, $this->component());

            return $this;
        });

        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });

        TestResponse::macro('assertPropCount', function ($key, $count) {
            $this->assertHasProp($key);

            Assert::assertCount($count, $this->props($key));

            return $this;
        });
    }
}
