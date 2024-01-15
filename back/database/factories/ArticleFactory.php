<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'slug' => Str::slug($this->faker->unique()->sentence(5)),
            'title' => $this->faker->sentence(6),
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => User::inRandomOrder()->first()->id
        ];
    }
}

