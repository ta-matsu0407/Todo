<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tel = str_replace('-', '', fake()->phoneNumber());
        $address = mb_substr(fake()->address(), 9);
        // 電話番号-> ハイフンを削除
        // 住所-> 郵便番号と半角スペースをカット,何文字目から使用するか

        return [
            'name' => fake()->name(),
            'kana' => fake()->kanaName(),
            'tel' => $tel,
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'postcode' => fake()->postcode(),
            'address' => $address,
            'birthday' => fake()->dateTime(),
            'gender' => fake()->numberBetween(0, 2),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'memo' => fake()->realText(15),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
