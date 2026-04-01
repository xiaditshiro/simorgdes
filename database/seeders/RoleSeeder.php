<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'display_name' => 'Super Admin'],
            ['name' => 'admin_desa', 'display_name' => 'Admin Desa'],
            ['name' => 'ketua', 'display_name' => 'Ketua'],
            ['name' => 'sekretaris', 'display_name' => 'Sekretaris'],
            ['name' => 'bendahara', 'display_name' => 'Bendahara'],
            ['name' => 'anggota', 'display_name' => 'Anggota'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['display_name' => $role['display_name']]
            );
        }
    }
}