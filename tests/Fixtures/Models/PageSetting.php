<?php

namespace Thinkone\NovaPageSettings\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Thinkone\NovaPageSettings\Tests\Fixtures\Factories\PageSettingFactory;

class PageSetting extends \Thinkone\NovaPageSettings\Model\PageSetting
{
    use HasFactory;

    protected $table = 'page_settings';

    protected static function newFactory(): PageSettingFactory
    {
        return new PageSettingFactory();
    }
}
