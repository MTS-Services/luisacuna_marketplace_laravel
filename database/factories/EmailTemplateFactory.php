<?php


namespace Database\Factories;

use App\Models\EmailTemplate;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailTemplateFactory extends Factory
{
    protected $model = EmailTemplate::class;

    public function definition(): array
    {
        return [
            'sort_order' => $this->faker->numberBetween(0, 10),
            'key' => $this->faker->unique()->slug(),
            'name' => $this->faker->sentence(2),
            'subject' => $this->faker->sentence(5),
            'template' => '<p>Hello {user_name}, welcome to our system!</p>',
            'variables' => json_encode(['{user_name}', '{email}', '{link}']),
            'created_by' => Admin::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
