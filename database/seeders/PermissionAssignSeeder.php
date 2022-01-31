<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionSubGroup;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionAssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accessModules = array(
            'tsp' => array(
                'user',
                'role',
                'branch',
                'batch',
                'course',
                'program',
                'training_center',
                'trainer',
                'course_enrollment',
                'banner',
                'calender_event',
                'faq',
                'gallery_album',
                'gallery_image_video',
                'notice_or_news',
                'recent_activity',
                'slider',
                'static_page_content_or_page_block',
                'static_page_type',
                'visitor_feedback_suggestion',
                'institute_hr_demand',
                'view_institute_profile',
                'update_institute_profile',
                'cv_bank',
                'freelance_corner',
            ),
            'industry' => array(
                'user',
                'role',
                'rank_type',
                'rank',
                'organization_unit_type',
                'organization_unit',
                'human_resource',
                'human_resource_template',
                'view_organization_profile',
                'update_organization_profile',
                'cv_bank',
                'freelance_corner',
            ),
            'industry_association' => array(
                'user',
                'role',
                'organization_type',
                'organization',
                'organization_unit_type',
                'organization_unit',
                'publication',
                'contact_info',
                'banner',
                'calender_event',
                'faq',
                'gallery_album',
                'gallery_image_video',
                'notice_or_news',
                'recent_activity',
                'slider',
                'static_page_content_or_page_block',
                'static_page_type',
                'visitor_feedback_suggestion',
                'industry_association_hr_demand',
                'view_industry_association_profile',
                'update_industry_association_profile',
                'job',
                'cv_bank',
                'freelance_corner',
            )
        );

        DB::table('permission_group_permissions')->truncate();
        DB::table('permission_sub_group_permissions')->truncate();
        DB::table('role_permissions')->truncate();

        foreach ($accessModules as $key=>$modules){
            foreach ($modules as $module){
                $permissionGroup = PermissionGroup::where('key',$key)->firstOrFail();
                $permissionSubGroup = PermissionSubGroup::where('key',$key)->firstOrFail();
                $role = Role::where('key',$key . '_admin')->firstOrFail();

                $permissionIds = Permission::where('module',$module)->pluck('id');

                $permissionGroup->permissions()->attach($permissionIds);
                $permissionSubGroup->permissions()->attach($permissionIds);
                $role->permissions()->attach($permissionIds);
            }
        }
    }
}
