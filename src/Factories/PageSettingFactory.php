<?php

namespace Thinkone\NovaPageSettings\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Thinkone\NovaPageSettings\Model\PageSetting;

/**
 * @extends Factory<PageSetting>
 */
class PageSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'  => 'default',
            'page'  => $this->faker->unique()->word(),
            'key'   => $this->faker->unique()->word(),
            'value' => $this->faker->unique()->sentence(),
        ];
    }

    public function page(string $page)
    {
        return $this->state([
            'page' => $page,
        ]);
    }

    public function key(string $key)
    {
        return $this->state([
            'key' => $key,
        ]);
    }

    public function setData(string $key, string $value)
    {
        return $this->state([
            'key'   => $key,
            'value' => $value,
        ]);
    }
}
