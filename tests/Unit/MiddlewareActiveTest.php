<?php

namespace Tests\Unit;

use App\Http\Middleware\TrimStrings;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MiddlewareActiveTest extends TestCase
{
    public function testRouteHasMiddleware()
    {
        $this->assertArrayHasKey(
            TrimStrings::class,
            array_flip(Route::getRoutes()->getByName('test-middleware')->gatherMiddleware())
        );
    }
}
