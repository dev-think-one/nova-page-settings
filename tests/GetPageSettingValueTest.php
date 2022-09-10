<?php

namespace Thinkone\NovaPageSettings\Tests;

use Thinkone\NovaPageSettings\Tests\Fixtures\Models\PageSetting;

class GetPageSettingValueTest extends TestCase
{
    /** @test */
    public function get_value_using_helper()
    {
        PageSetting::factory()
                   ->page('foo-page')
                   ->setData('foo-key', 'Test foo.')
                   ->create();
        PageSetting::factory()
                   ->page('foo-page')
                   ->setData('foo-key', 'Example foo.')
                   ->create();
        PageSetting::factory()
                   ->page('foo-page')
                   ->setData('bar-key', '')
                   ->create();

        $data = PageSetting::query()->page('foo-page')->get();

        // Can be multiple
        $this->assertCount(3, $data);

        // Cast to string
        $this->assertEquals('Test foo.', $data->stringSettingValue('foo-key'));
        $this->assertEquals('Test foo.', $data->stringSettingValue('foo-key', 'string'));
        $this->assertTrue('' === $data->stringSettingValue('bar-key'));
        $this->assertTrue(null === $data->stringSettingValue('baz-key'));

        // Cast to bool
        $this->assertTrue(true === $data->boolSettingValue('foo-key'));
        $this->assertTrue(false === $data->boolSettingValue('bar-key'));
        $this->assertTrue(null === $data->boolSettingValue('baz-key'));

        // Cast to array
        $this->assertIsArray($data->arraySettingValue('foo-key'));
        $this->assertEmpty($data->arraySettingValue('foo-key'));
        $this->assertIsArray($data->arraySettingValue('bar-key'));
        $this->assertEmpty($data->arraySettingValue('bar-key'));
        $this->assertTrue(null === $data->arraySettingValue('baz-key'));


        // Cast to undefined
        $this->assertEquals('Test foo.', $data->stringSettingValue('foo-key', 'foo'));
        $this->assertEquals('', $data->stringSettingValue('bar-key', 'foo'));

        // Use default value
        $this->assertEquals('Test foo.', $data->getSettingValue('foo-key', 'string', 'DefaultTest'));
        $this->assertTrue('' === $data->getSettingValue('bar-key', 'string', 'DefaultTest'), );
        $this->assertTrue('DefaultTest' === $data->getSettingValue('baz-key', 'string', 'DefaultTest'));
        $this->assertTrue(true === $data->getSettingValue('foo-key', 'bool', false));
        $this->assertTrue(false === $data->getSettingValue('bar-key', 'bool', true));
        $this->assertTrue(true === $data->getSettingValue('baz-key', 'bool', true));
        $this->assertEmpty($data->arraySettingValue('foo-key', ['Test', 'DefaultTest']));
        $this->assertEmpty($data->arraySettingValue('bar-key', ['Test', 'DefaultTest']));
        $this->assertTrue('DefaultTest' === $data->arraySettingValue('baz-key', ['Test', 'DefaultTest'])[1]);
    }
}
