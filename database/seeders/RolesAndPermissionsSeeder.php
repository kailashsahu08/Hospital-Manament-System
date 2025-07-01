<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        $policies = ['view-any', 'view', 'create', 'update', 'delete', 'restore', 'force-delete'];
        $models = [ 'User', 'Role', 'Permission','Appointment', 'Doctor', 'Patient', 'Department','Payment','TestReport'];
        foreach ($policies as $policy) {
            foreach ($models as $model) {
                Permission::create([
                    'name' => "{$policy} {$model}",
                    'guard_name' => "web",
                ]);
            }
        }

   
        // this can be done as separate statements
        Role::findOrCreate( 'admin')
            ->givePermissionTo(Permission::all());
        Role::findOrCreate( 'doctor')
        ->givePermissionTo([
            'view-any User',
            'view User',
            'view-any Appointment',
            'view Appointment',
            'view-any Doctor',
            'view Doctor',
            'view-any Patient',
            'view Patient',
            'view-any Department',
            'view Department',
            'view-any Payment',
            'view Payment',
            'view-any TestReport',
            'view TestReport',
            'create User',
            'create Appointment',
            'create Doctor',
            'create Patient',
            'create Department',
            'create Payment',
            'create TestReport',
        ]);
        Role::findOrCreate( 'patient')
            ->givePermissionTo([
                'view-any User',
                'view User',
                'view-any Appointment',
                'view Appointment',
                'view-any Doctor',
                'view Doctor',
                'view-any Patient',
                'view Patient',
                'view-any Department',
                'view Department',
                'view-any Payment',
                'view Payment',
                'view-any TestReport',
                'view TestReport'
            ]);
    }
}
