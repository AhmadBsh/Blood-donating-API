<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->insert([

            'name' => 'admin',
            'password' => Hash::make('admin'),
            'phone_number' => '007',
            'address' => 'homs',
            'blood_type_id' => '1',
            'national_number' => '12345',
            'city' => 'homs',
            'weight' => '69',
            'age' => '30',
            'sex' => 'male',
        ]);
        DB::table('users')->insert([

            'name' => 'ahmad',
            'password' => Hash::make('ahmad'),
            'phone_number' => '006',
            'address' => 'homs',
            'blood_type_id' => '1',
            'national_number' => '123',
            'city' => 'homs',
            'weight' => '69',
            'age' => '30',
            'sex' => 'male',
        ]);
        Permission::create(['name' => 'create-normal-user']);
        Permission::create(['name' => 'create-nurse']);
        Permission::create(['name' => 'create-donate-schedule']);
        Permission::create(['name' => 'create-take-schedule']);
        Permission::create(['name' => 'verify-donation']);
        Permission::create(['name' => 'verify-take']);
        Permission::create(['name' => 'view-all']);
        Permission::create(['name' => 'edit-all']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'view-nurse']);
        Permission::create(['name' => 'view-donate-schedule']);
        Permission::create(['name' => 'view-take-schedule']);

        $adminRole = Role::create(['name' => 'admin']);
        $nurseRole = Role::create(['name' => 'nurse']);
        $donatorRole = Role::create(['name' => 'donator']);
        $takerRole = Role::create(['name' => 'taker']);

        $adminRole->givePermissionTo([
            'create-normal-user',
            'create-nurse',
            'create-donate-schedule',
            'create-take-schedule',
            'verify-donation',
            'verify-take',
            'view-all',
            'edit-all',
            'view-user',
            'view-nurse',
            'view-donate-schedule',
        ]);
        $nurseRole->givePermissionTo([
            'verify-donation',
            'verify-take',
            'view-user',
            'view-nurse',
            'view-donate-schedule',
        ]);
        $donatorRole->givePermissionTo([
            'create-normal-user',
            'create-donate-schedule',
            'view-nurse',
            'view-donate-schedule',
        ]);
        $takerRole->givePermissionTo([
            'create-normal-user',
            'create-take-schedule',
            'view-nurse',
            'view-take-schedule',
        ]);
        $user = User::first();
        $user->assignRole('admin');
        
    }
}
