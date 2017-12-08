<?php

namespace Tests\Unit;

use App\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    /** @test */
    public function testMiddleware()
    {
        Route::middleware(TrimStrings::class)->group(function () {
            Route::post('trim-strings-test', function (Request $request) {
                return response()->json([
                    'string' => $request->post('string'),
                ]);
            });
        });

        tap(
            $this->post('trim-strings-test', ['string' => ' bar   ']),
            function (TestResponse $response) {
                $this->assertEquals('bar', $response->json()['string']);
            }
        );
    }
}
