<?php

namespace Vikuraa\Helpers;

use Branca\Branca;
use Psr\Http\Message\ServerRequestInterface as Request;
use RuntimeException;
use Vikuraa\Exceptions\AuthException;
use Psr\Log\LoggerInterface;

class Jwt
{
    protected $container;
    protected $branca;

    public function __construct($container)
    {
        $this->container = $container;

        $this->branca = new Branca($this->container->get('settings')['security']['jwt_key']);
    }

    public function create($data)
    {
        $payload = json_encode([
            'provider'  => $this->container->get('settings')['app']['domain'],
            'subject'   => $this->container->get('settings')['app']['name'],
            'payload'   => $data
        ]);

        return $this->branca->encode($payload);
    }

    public function add(array $data, $token)
    {
        $payload = json_decode($this->decode($token));

        $payload = array_merge((array)$payload->payload, $data);

        return $this->create($payload);
    }

    public function decode($token, $ttl = null)
    {
        try {
            $decoded = $ttl == null ? $this->branca->decode($token) : $this->branca->decode($token, $ttl);

            if (is_string($decoded)) {
                return json_decode($decoded);
            }
            return $decoded;
        } catch (RuntimeException $e) {
            throw new AuthException($e->getMessage());
        }
    }

    public function getToken(Request $request)
    {
        $header = $request->getHeaderLine('Authorization');

        if (false === empty($header)) {
            if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
                return $matches[1];
            }
        }
    }

    public function getUserData(Request $request)
    {
        $token =  $this->getToken($request);
        return $this->decode($token);
    }

    public function timestamp($token)
    {
        return $this->branca->timestamp($token);
    }
}