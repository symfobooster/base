<?php

namespace Symfobooster\Base\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * @mixin WebTestCase
 */
trait ClientTrait
{
    use StatusTrait;

    private KernelBrowser $browser;
    private $response;
    private array $headers = [];
    private ?array $content;

    protected function sendRequest(string $method, string $url, array $data)
    {
        $browser = $this->createBrowser();
        // TODO cookies
        // TODO authontification

        $headers = array_merge([
            'CONTENT_TYPE' => 'application/json',
        ], $this->headers);
//        $browser->setServerParameters('HTTP_USER_AGENT', 'Symfobooster test process');
        $browser->request($method, $url, [], [], $headers, json_encode([
            'email' => 'test@permit.com',
            'username' => 'zabachok',
        ]));
        
        $response = $browser->getResponse();
        $this->content = json_decode($response->getContent(), true);
        $this->headers = [];
        
        return $this->content;
    }
    
    protected function sendPost(string $url, array $data): ?array
    {
        return $this->sendRequest('POST', $url, $data);
    }

    private function createBrowser(): KernelBrowser
    {
        if (!isset($this->browser)) {
            $this->browser = static::createClient();
        }

        return $this->browser;
    }
}