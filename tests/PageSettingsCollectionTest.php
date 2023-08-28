<?php

namespace Thinkone\NovaPageSettings\Tests;

use Thinkone\NovaPageSettings\Model\PageSettingsCollection;

class PageSettingsCollectionTest extends TestCase
{
    /** @test */
    public function collection_supports_arrays()
    {
        $collection = PageSettingsCollection::make([
            [
                'key'   => 'foo',
                'value' => 'FOO',
            ],
            [
                'key'   => 'bar',
                'value' => 'FOO-bar',
            ],
        ]);

        $this->assertEquals('FOO-bar', $collection->getSettingValue('bar'));
        $this->assertEquals('FOO-bar', $collection->get(1)['value']);
    }

    /** @test */
    public function allow_override()
    {
        PageSettingsCollection::macro('getWithPref', function ($index, $pref) {
            return $pref . $this->get(1)['value'];
        });
        $collection = PageSettingsCollection::make([
            [
                'key'   => 'foo',
                'value' => 'FOO',
            ],
            [
                'key'   => 'bar',
                'value' => 'FOO-bar',
            ],
        ]);

        $this->assertEquals('baz_FOO-bar', $collection->getWithPref(1, 'baz_'));
    }
}
