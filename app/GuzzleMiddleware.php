<?php
namespace App;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleMiddleware
{
    /**
     * @param $numberOfRetries
     * @return callable
     */
    public static function retryRequest($numberOfRetries)
    {
        return \GuzzleHttp\Middleware::retry(
            self::retryDecider($numberOfRetries),
            self::exponentialDelay()
        );
    }

    /**
     * @param $numberOfRetries
     * @return \Closure
     */
    public static function retryDecider($numberOfRetries)
    {
        return function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null,
            RequestException $exception = null
        ) use ($numberOfRetries) {
            if ($retries >= $numberOfRetries) {
                return false;
            }

            // Retry connection exceptions
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
                // Retry on server errors
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * @return \Closure
     */
    public static function exponentialDelay()
    {
        return function ($retries) {
            return (int) pow(2, $retries - 1);
        };
    }
}