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
        $this->assertEquals('Test foo.', page_setting_value($data, 'foo-key'));
        $this->assertEquals('Test foo.', page_setting_value($data, 'foo-key', 'string'));
        $this->assertTrue('' === page_setting_value($data, 'bar-key'));
        $this->assertTrue(null === page_setting_value($data, 'baz-key'));

        // Cast to bool
        $this->assertTrue(true === page_setting_value($data, 'foo-key', 'bool'));
        $this->assertTrue(false === page_setting_value($data, 'bar-key', 'bool'));
        $this->assertTrue(null === page_setting_value($data, 'baz-key', 'bool'));

        // Cast to array
        $this->assertIsArray(page_setting_value($data, 'foo-key', 'array'));
        $this->assertEmpty(page_setting_value($data, 'foo-key', 'array'));
        $this->assertIsArray(page_setting_value($data, 'bar-key', 'array'));
        $this->assertEmpty(page_setting_value($data, 'bar-key', 'array'));
        $this->assertTrue(null === page_setting_value($data, 'baz-key', 'array'));


        // Cast to undefined
        $this->assertEquals('Test foo.', page_setting_value($data, 'foo-key', 'foo'));
        $this->assertEquals('', page_setting_value($data, 'bar-key', 'foo'));

        // Use default value
        $this->assertEquals('Test foo.', page_setting_value($data, 'foo-key', 'string', 'DefaultTest'));
        $this->assertTrue('' === page_setting_value($data, 'bar-key', 'string', 'DefaultTest'), );
        $this->assertTrue('DefaultTest' === page_setting_value($data, 'baz-key', 'string', 'DefaultTest'));
        $this->assertTrue(true === page_setting_value($data, 'foo-key', 'bool', false));
        $this->assertTrue(false === page_setting_value($data, 'bar-key', 'bool', true));
        $this->assertTrue(true === page_setting_value($data, 'baz-key', 'bool', true));
        $this->assertEmpty(page_setting_value($data, 'foo-key', 'array', ['Test', 'DefaultTest']));
        $this->assertEmpty(page_setting_value($data, 'bar-key', 'array', ['Test', 'DefaultTest']));
        $this->assertTrue('DefaultTest' === page_setting_value($data, 'baz-key', 'array', ['Test', 'DefaultTest'])[1]);
    }
}
