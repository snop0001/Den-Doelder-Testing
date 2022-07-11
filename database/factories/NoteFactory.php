<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->sentence,
            'content'=>$this->faker->realTextBetween(100),
            'label'=>$this->faker->randomElement(['Mechanical Issue', 'Material Issue', 'Technical Issue', 'Lunch Break',
                                                    'End of shift']),
            'priority'=>$this->faker->randomElement(['low']),
            'creator' =>$this->faker->randomElement(['Administrator', 'Production', 'Driver']),
            'order_id' => Order::all()->random()->id,
        ];
    }
}
