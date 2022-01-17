<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const ROUTE_PREFIX = 'api/v1/';

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();

        $methods = [
            'view_any' => [
                'method' => 1,
                'uri' => ''
            ],
            'view_single' => [
                'method' => 1,
                'uri' => '/{id}'
            ],
            'create' => [
                'method' => 2,
                'uri' => ''
            ],
            'update' => [
                'method' => 3,
                'uri' => '/{id}'
            ],
            'delete' => [
                'method' => 5,
                'uri' => '/{id}'
            ]
        ];

        $modules = [
            'division',
            'district',
            'upazila',
            'user',
            'role',
            'permission',
            'permission_group',
            'permission_sub_group',
            'organization_type',
            'organization',
            'rank_type',
            'rank',
            'service',
            'skill',
            'job_sector',
            'occupation',
            'organization_unit_type',
            'organization_unit',
            'human_resource',
            'human_resource_template',
            'branch',
            'batch',
            'course',
            'institute',
            'program',
            'training_center',
            'trainer',
            'course_enrollment',
            'industry_association',
            'publication',
            'contact_info',
            'banner',
            'calender_event',
            'faq',
            'gallery_album',
            'gallery_image_video',
            'nise3_partner',
            'notice_or_news',
            'recent_activity',
            'slider',
            'static_page_content_or_page_block',
            'static_page_type',
            'visitor_feedback_suggestion',
            'industry_association_hr_demand',
            'institute_hr_demand'
        ];
        $menuOrder = 1;
        foreach ($modules as $module) {
//            $menuId=DB::table('menus')->insertGetId(
//                [
//                    'name'=>$module
//                ]
//            );
//            $order=1;
            foreach ($methods as $key => $method) {
                $permissionKey = $key . '_' . $module;
                $title = ucfirst(str_replace('_', ' ', $permissionKey));
                Permission::create([
                    'title_en' => $title,
                    'title' => $title,
                    'key' => $permissionKey,
                    'uri' => self::ROUTE_PREFIX . str_replace('_', '-', $module) . $method['uri'],
                    'method' => $method['method'],
                    'module' => $module
                ]);
//                $parentId=DB::table('menu_items')->insertGetId([
//                    'menu_id'=>$menuId,
//                    'title'=>$permissionKey,
//                    'title_lang_key'=>'EN',
//                    'type'=>'item',
//                    'permission_key'=>$permissionKey,
//                    'url'=>self::ROUTE_PREFIX . $module . $method['uri'],
//                    'order'=>$order++
//                ]);
            }

        }

        /** For custom API permissions */
        $customPermissions = [
            'update_institute_hr_demand_by_institute' => [
                'uri' => 'update-hr-demand-institute-by-institute/{id}',
                'method' => '3',
                'module' => 'institute_hr_demand'
            ],
            'view_any_industry_association_member' => [
                'uri' => 'view-any-industry-association-member',
                'method' => '1',
                'module' => 'industry_association'
            ],
            'view_single_industry_association_member' => [
                'uri' => 'view-single-industry-association-member /{industryId}',
                'method' => '1',
                'module' => 'industry_association'
            ],
            'create_job' => [
                'uri' => 'create_job',
                'method' => '2',
                'module' => 'job'
            ],
            'view_single_job' => [
                'uri' => 'view_single_job/{jobId}',
                'method' => '1',
                'module' => 'job'
            ],
            'view_any_job' => [
                'uri' => 'view_any_job/{jobId}',
                'method' => '1',
                'module' => 'job'
            ]
        ];
        foreach ($customPermissions as $permission => $details) {
            $title = ucfirst(str_replace('_', ' ', $permission));
            Permission::create([
                'title_en' => $title,
                'title' => $title,
                'key' => $permission,
                'uri' => self::ROUTE_PREFIX . $details['uri'],
                'method' => $details['method'],
                'module' => $details['module']
            ]);
        }
        Schema::enableForeignKeyConstraints();

        $role = Role::find(1);
        $permissions = Permission::orderBy('id', 'ASC')->pluck('id')->toArray();
        $role->permissions()->sync($permissions);
        Cache::flush();
    }
}
