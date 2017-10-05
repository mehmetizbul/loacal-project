<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\PermissionRole;
class RolesAndPermissionsSeeder extends Seeder
{


    protected $roles = [
        [
            'name'  => 'super_admin',
            'display_name' => 'Super Admin', // optional
            'description' => 'God-like creature', // optional
            'permissions' => ['manage_roles', 'see_stats'] // optional
        ],
        [
            'name' =>'admin',
            'display_name' => 'Admin',
            'description' => 'Semi-God',
            'permissions' => []
        ],
        [
            'name' => 'loacal_agent',
            'display_name' => 'Loacal Agent',
            'description' => '',
            'permissions' => []
        ],
        [
            'name' => 'loacal_person',
            'display_name' => 'Loacal Person',
            'description' => '',
            'permissions' => []
        ],
        [
            'name' => 'translator',
            'display_name' => 'Translator',
            'description' =>'',
            'permissions' => []
        ],
        [
            'name' => 'traveller',
            'display_name' => 'Traveller',
            'description' =>'',
            'permissions' => []
        ]
    ];

    protected $permission = [
        [
            'name' => 'manage_roles',
            'display_name' => 'Role Manager',
            'description' => 'Manage User Roles. Only available to Super-Admins'
        ],
        [
            'name' => 'manage_categories',
            'display_name' => 'Category Manager',
            'description' => 'Manage Experience Categories.'
        ],
        [
            'name' => 'see_stats',
            'display_name' => 'Statistician',
            'description' => 'Manage User Roles (add,edit,delete). Only available to Super-Admins'
        ],
        [
            'name' => 'manage_translations',
            'display_name' => 'Translator',
            'description' => 'Manage Translations'
        ],
        [
            'name' => 'manage_users',
            'display_name' => 'User Manager',
            'description' => 'Manage Users (add,edit,delete)'
        ],
        [
            'name' => 'manage_experiences',
            'display_name' => 'Experience Manager',
            'description' => 'Manage Experiences of others (add,edit,delete)'
        ],
        [
            'name' => 'manage_own_experiences',
            'display_name' => 'Manage Own Experiences',
            'description' => 'Advanced Member. Can manage his/her own Experience listings'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permission as $key => $value) {
            Permission::firstOrCreate($value);
        }

        foreach ($this->roles as $key => $value) {
            $permission_names = $value["permissions"];
            unset($value["permissions"]);
            $oRole = Role::firstOrCreate($value);
            foreach($permission_names as $value) {
                $oPerm = Permission::whereName($value)->first();
                PermissionRole::firstOrCreate([
                    "permission_id" =>$oPerm->id,
                    "role_id"=>$oRole->id
                ]);
            }
        }
    }
}