<?php

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Tests\Feature;

use Guanguans\Notify\Factory;
use Guanguans\Notify\Tests\TestCase;

class BarkTest extends TestCase
{
    public function testBark()
    {
        $this->expectException(\GuzzleHttp\Exception\ClientException::class);

        $ret = Factory::bark()
            ->setToken('tU2mk6FvyiScEyWrt6xGF')
            ->setMessage((new \Guanguans\Notify\Messages\BarkMessage([
                'text' => 'text',
            ])))
            ->send();
    }
}