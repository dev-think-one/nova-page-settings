<?php

namespace Thinkone\NovaPageSettings\Tests\Template;

use Thinkone\NovaPageSettings\Model\PageSetting;
use Thinkone\NovaPageSettings\Tests\Fixtures\Templates\HomePageTemplate;
use Thinkone\NovaPageSettings\Tests\TestCase;

class TemplateViewDataTest extends TestCase
{
    /** @test */
    public function view_data_by_default_return_array()
    {
        // Email
        $emailSetting = PageSetting::create([
            'page'  => HomePageTemplate::getSlug(),
            'key'   => 'email',
            'value' => 'test@test.com',
        ]);

        // flexible array example
        $pushImagesSetting = PageSetting::create([
            'page'  => HomePageTemplate::getSlug(),
            'key'   => 'push_images',
            'value' => '[{"layout":"push_image","key":"vYuFvVnWxvNUuqOu","collapsed":false,"attributes":{"enabled":false,"plans":{"bronze":true,"silver":false,"gold":true},"link":null,"title":"qux","content":"<p>bar<\/p>","button":[{"layout":"button","key":"qdpyyahSMOAgdnLn","collapsed":false,"attributes":{"enabled":true,"text":"bar","link":"foo"}}],"image":"LwERSPMr7vozKrLG1YyULzyfe8XOQaACploVob1R.jpg","buttons":[{"layout":"button","key":"YKMwZafWHoKguNCS","collapsed":false,"attributes":{"enabled":false,"text":"baz","link":"bar"}}]}}]',
        ]);

        $viewData = HomePageTemplate::viewData();

        $this->assertIsArray($viewData);
        $this->assertCount(2, $viewData);
        $this->assertEquals($viewData[$emailSetting->key], $emailSetting->value);
        $this->assertEquals($viewData[$pushImagesSetting->key], $pushImagesSetting->value);
    }

    /** @test */
    public function mutate_attribute()
    {
        $template = new HomePageTemplate;

        $this->assertEquals('http://pic', $template->mutateAttribute('image', 'pic'));
        $this->assertEquals('pic', $template->mutateAttribute('link', 'pic'));
    }

    /** @test */
    public function template_key()
    {
        $template = new HomePageTemplate;

        $this->assertEquals('opt_image', $template->templateKey('image'));
    }
}
