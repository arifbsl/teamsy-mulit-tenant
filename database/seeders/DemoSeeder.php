<?php

namespace Database\Seeders;

use App\Models\Login;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tenant::factory()->count(3)->create();

        foreach (Tenant::all() as $tenant) {
            User::factory()->count(20)->create([
                'tenant_id' => $tenant->id,
            ]);
        }

        foreach (User::all() as $user) {
            Login::factory()->count(5)->create([
                'user_id' => $user->id,
                'tenant_id' => $user->tenant_id,
            ]);
        }

        User::factory()->create([
            'tenant_id' => null,
            'email' => 'admin@admin.com',
        ]);
    }
}
