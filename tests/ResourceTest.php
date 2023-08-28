<?php

namespace Thinkone\NovaPageSettings\Tests;

use Thinkone\NovaPageSettings\Tests\Fixtures\Models\User;
use Thinkone\NovaPageSettings\Tests\Fixtures\Nova\SettingsResource;

class ResourceTest extends TestCase
{

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        $this->actingAs($this->admin);
    }

    /** @test */
    public function detail_screen()
    {
        $uriKey = SettingsResource::uriKey();

        $response = $this->getJson("nova-api/{$uriKey}/0");

        $this->assertEquals('Home Page Template', $response->json('title'));
    }

    /** @test */
    public function index()
    {
        $uriKey = SettingsResource::uriKey();

        $response = $this->getJson("nova-api/{$uriKey}");


        $this->assertCount(2, $response->json('resources.0.fields'));
        $this->assertEquals('id', $response->json('resources.0.fields.0.attribute'));
        $this->assertEquals('__nps_name', $response->json('resources.0.fields.1.attribute'));
    }

    /** @test */
    public function model()
    {
        $model = \Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::find(0);
        $this->assertInstanceOf(\Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::class, $model);
        $this->assertNotNull($model->template());
        $model->setAttribute('__nps_class', null);
        $this->assertNull($model->template());


        $model = \Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::find(6);
        $this->assertNull($model);

        // Always true
        $this->assertTrue(\Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::exists(0));
        $this->assertTrue(\Thinkone\NovaPageSettings\Adapters\CMSPageSettingModel::exists(6));
    }
}
