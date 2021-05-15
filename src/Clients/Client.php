<?php

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Clients;

use Guanguans\Notify\Contracts\GatewayInterface;
use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Contracts\RequestInterface;
use Guanguans\Notify\Exceptions\Exception;
use Guanguans\Notify\Messages\Message;
use Guanguans\Notify\Traits\HasHttpClient;
use Guanguans\Notify\Traits\HasOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class Client implements GatewayInterface, RequestInterface
{
    use HasHttpClient;
    use HasOptions;

    /**
     * @var string
     */
    protected $requestMethod = 'post';

    /**
     * @var string[]
     */
    protected $defined = [
        'token',
        'message',
    ];

    /**
     * Client constructor.
     */
    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    protected function configureOptionsResolver(OptionsResolver $resolver): OptionsResolver
    {
        return tap($resolver, function ($resolver) {
            $resolver->setDefined($this->defined);
        });
    }

    public function getName(): string
    {
        return str_replace([__NAMESPACE__.'\\', 'Client'], '', get_class($this));
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getToken(): string
    {
        return $this->getOptions('token');
    }

    /**
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->setOption('token', $token);

        return $this;
    }

    public function getMessage(): Message
    {
        return $this->getOptions('message');
    }

    /**
     * @return $this
     */
    public function setMessage($message)
    {
        $this->setOption('message', $message);

        return $this;
    }

    /**
     * @throws \Guanguans\Notify\Exceptions\Exception
     */
    public function getRequestParams(): array
    {
        if (null === $this->getMessage()) {
            throw new Exception('No Message!');
        }

        if (! $this->getMessage() instanceof MessageInterface) {
            throw new Exception(sprintf('The message no instanceof %s', MessageInterface::class));
        }

        return $this->getMessage()->transformToRequestParams();
    }

    /**
     * @return mixed
     *
     * @throws \Guanguans\Notify\Exceptions\Exception
     */
    public function send(MessageInterface $message = null)
    {
        $message && $this->setMessage($message);

        return $this->getHttpClient()->{$this->getRequestMethod()}($this->getRequestUrl(), $this->getRequestParams());
    }
}