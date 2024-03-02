<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fname = $this->faker->firstName;
        $lname = $this->faker->lastName;
        $fullname = Str::lower($fname).Str::lower($lname);
        $status = $this->faker->numberBetween(0,2);
        switch ($status) {
            case 1:
                $status = 'active'; 
                break;

            case 2:
                $status = 'inactive';
                break;

                default:
                $status = 'pending';
                break;
        }
        return [
            'username' => $fullname,
            'nama' => $fname,
            'nomor_telp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'nomor_telp' => $this->faker->phoneNumber,
            'alamat' => 'pamulang',
            'user_type' => 'admin',
            'status' => $status
        ];
    }
}
