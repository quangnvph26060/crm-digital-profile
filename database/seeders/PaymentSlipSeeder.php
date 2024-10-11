<?php

namespace Database\Seeders;

use App\Models\PaymentSlip;
use Illuminate\Database\Seeder;

class PaymentSlipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentSlip::factory()->count(20)->create();
    }
}
