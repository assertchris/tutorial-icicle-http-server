<?php

require __DIR__ . "/vendor/autoload.php";

use Icicle\Http\Message\RequestInterface;
use Icicle\Http\Message\Response;
use Icicle\Http\Server\Server;
use Icicle\Loop;
use Icicle\Socket\Client\ClientInterface;
use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteCollection;
use League\Route\Strategy\UriStrategy;

$server = new Server(
    function(RequestInterface $request, ClientInterface $client) {
        $router = new RouteCollection();
        $router->setStrategy(new UriStrategy());

        require __DIR__ . "/routes.php";

        $dispatcher = $router->getDispatcher();

        try {
            $result = $dispatcher->dispatch(
                $request->getMethod(),
                $request->getRequestTarget()
            );

            $status = 200;
            $content = $result->getContent();
        } catch (NotFoundException $exception) {
            $status = 404;
            $content = "not found";
        } catch (MethodNotAllowedException $exception) {
            $status = 405;
            $content = "method not allowed";
        }

        $response = new Response($status);
        $response = $response->withHeader(
            "Content-Type", "text/html"
        );

        yield $response->getBody()->end($content);
        yield $response;
    }
);

$server->listen(9001);

Loop\run();
