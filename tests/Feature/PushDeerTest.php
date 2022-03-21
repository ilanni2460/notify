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

class PushDeerTest extends TestCase
{
    public function testText()
    {
        $ret = Factory::pushDeer()
            ->setToken('PDU8024TTt9Yvx4wkm08SmSXAY9pnPycl5RrB')
            ->setMessage(new \Guanguans\Notify\Messages\PushDeer\TextMessage('This is text.', 'This is desp.'))
            ->send();

        $this->assertEmpty($ret['content']['result']);
    }

    public function testMarkdown()
    {
        $ret = Factory::pushDeer()
            ->setToken('PDU8024TTt9Yvx4wkm08SmSXAY9pnPycl5RrB')
            ->setMessage(new \Guanguans\Notify\Messages\PushDeer\MarkdownMessage('## This is markdown.', '## This is desp.'))
            ->send();

        $this->assertEmpty($ret['content']['result']);
    }

    public function testImage()
    {
        $ret = Factory::pushDeer()
            ->setToken('PDU8024TTt9Yvx4wkm08SmSXAY9pnPycl5RrB')
            ->setMessage(new \Guanguans\Notify\Messages\PushDeer\ImageMessage('https://avatars.githubusercontent.com/u/22309277?v=4', 'This is desp.'))
            ->send();

        $this->assertEmpty($ret['content']['result']);
    }
}
