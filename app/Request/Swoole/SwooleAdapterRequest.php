<?php

declare(strict_types=1);

namespace App\Request\Swoole;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Swoole\Http\Request;

class SwooleAdapterRequest implements RequestInterface
{
    private Request $swooleRequest;

    public function __construct(Request $swooleRequest)
    {
        $this->swooleRequest = $swooleRequest;
    }

    public function getSwooleRequest()
    {
        return $this->swooleRequest;
    }

    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
    }

    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }

    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
    }

    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
    }

    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
    }

    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
    }

    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
    }

    public function getBody()
    {
        $body = new RequestBody($this->swooleRequest->rawContent());

        return $body->getContents();
    }

    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.
    }

    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    public function getMethod()
    {
        return $this->swooleRequest->server['request_method'];
    }

    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    public function getUri()
    {
        return $this->swooleRequest->server['request_uri'];
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}