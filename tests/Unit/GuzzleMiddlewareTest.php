<?php
namespace Tests\Unit;

use App\GuzzleMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class GuzzleMiddlewareTest extends TestCase
{
    public function testRetryRequestCatchesServerError()
    {
        $middleware = GuzzleMiddleware::retryRequest(2);
        $handler = new MockHandler([
            new Response(501),
            new Response(502),
            new Response(200)
        ]);
        $client = new Client(['handler' => $middleware($handler)]);
        $response = $client->get('http://test.com');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRetryRequestCatchesConnectionError()
    {
        $middleware = GuzzleMiddleware::retryRequest(1);
        $request = new Request('GET', 'http://test.com');
        $connectException = new ConnectException('Connection failed', $request);
        $handler = new MockHandler([$connectException, new Response(200)]);
        $client = new Client(['handler' => $middleware($handler)]);
        $response = $client->send($request, []);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRetryRequestNotCatchesClientError()
    {
        $middleware = GuzzleMiddleware::retryRequest(1);
        $handler = new MockHandler([new Response(400), new Response(202)]);
        $client = new Client(['handler' => $middleware($handler)]);
        $response = $client->get('http://test.com');
        $this->assertEquals(400, $response->getStatusCode());
    }
}
