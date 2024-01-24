<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auther;

class AutherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auther::create(['name' => 'فاطمة حيشية']);
        Auther::create(['name' => 'محمد عرابي']);
        Auther::create(['name' => 'محمد الزاير']);
        Auther::create(['name' => 'عمر النواوي']);
        Auther::create(['name' => 'ماجد عطوي']);
        Auther::create(['name' => 'رياض سامر']);
    }
}
