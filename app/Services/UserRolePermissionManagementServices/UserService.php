<?php


namespace App\Services\UserRolePermissionManagementServices;

use App\Models\BaseModel;
use App\Models\InstitutePermissions;
use App\Models\OrganizationPermissions;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;

class UserService
{

    /**
     * @var Carbon
     */
    public Carbon $startTime;

    const ROUTE_PREFIX = 'api.v1.users.';

    /**
     * PermissionService constructor.
     * @param Carbon $startTime
     */
    public function __construct(Carbon $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllUsers(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $paginate = $request->query('page');
        $name_en = $request->query('name_en');
        $name_bn = $request->query('name_bn');
        $email=$request->query('email');

        $order = !empty($request->query('order')) ? $request->query('order') : "ASC";

        $users = User::select([
            "users.id",
            "users.name_en",
            "users.name_bn",
            "users.email",
            "users.profile_pic",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.organization_id",
            "users.institute_id",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
        ]);
        $users->leftJoin('roles','roles.id','users.role_id');
        $users->leftJoin('loc_divisions','loc_divisions.id','users.loc_division_id');
        $users->leftJoin('loc_districts','loc_districts.id','users.loc_district_id');
        $users->leftJoin('loc_upazilas','loc_upazilas.id','users.loc_upazila_id');
        $users->orderBy('users.id',$order);

        if (!empty($name_en)) {
            $users = $users->where('users.name_en', 'like', '%' . $name_en . '%');
        }
        if (!empty($name_bn)) {
            $users = $users->where('users.name_bn', 'like', '%' . $name_bn . '%');
        }
        if (!empty($email)) {
            $users = $users->where('users.email', 'like', '%' . $email . '%');
        }
        $users->where('users.row_status',User::ROW_STATUS_ACTIVE);
        $users->orderBy('users.id',$order);

        if (!empty($paginate)) {
            $users = $users->paginate(10);
            $paginate_data = (object)$users->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $users = $users->get();
        }
        $data = [];
        foreach ($users as $user) {
            $_links['read'] = route(self::ROUTE_PREFIX . 'read', ['id' => $user->id]);
            $_links['update'] = route(self::ROUTE_PREFIX . 'update', ['id' => $user->id]);
            $_links['delete'] = route(self::ROUTE_PREFIX . 'destroy', ['id' => $user->id]);
            $user['_links'] = $_links;
            $data[] = $user->toArray();
        }
        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'name',
                        'key'
                    ],
                    '_link' => route(self::ROUTE_PREFIX . 'get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];

    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function getOneUser(Request $request, int $id): array
    {
        $user = User::select([
            "users.id",
            "users.name_en",
            "users.name_bn",
            "users.email",
            "users.profile_pic",
            "users.role_id",
            'roles.title_en as role_title_en',
            'roles.title_bn as role_title_bn',
            "users.organization_id",
            "users.institute_id",
            "users.loc_division_id",
            'loc_divisions.title_en as loc_divisions_title_en',
            'loc_divisions.title_bn as loc_divisions_title_bn',
            "users.loc_district_id",
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title_bn as loc_district_title_bn',
            "users.loc_upazila_id",
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title_bn as loc_upazila_title_bn',
        ]);
        $user->leftJoin('roles','roles.id','users.role_id');
        $user->leftJoin('loc_divisions','loc_divisions.id','users.loc_division_id');
        $user->leftJoin('loc_districts','loc_districts.id','users.loc_district_id');
        $user->leftJoin('loc_upazilas','loc_upazilas.id','users.loc_upazila_id');
        $user->where('users.row_status',User::ROW_STATUS_ACTIVE);
        $user=$user->where('users.id', $id)->first();

        $links = [];

        if (!empty($user)) {
            $links = [
                'update' => route(self::ROUTE_PREFIX . 'update', ['id' => $user->id]),
                'delete' => route(self::ROUTE_PREFIX . 'destroy', ['id' => $user->id])
            ];
        }
        return [
            "data" => $user ? $user : [],
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $this->startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function store(array $data, User $user): User
    {
        return $user->create($data);

    }

    /**
     * @param array $data
     * @param User $user
     * @return User
     */
    public function update(array $data, User $user): User
    {
        $user->fill($data);
        $user->save($data);
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function destroy(User $user): User
    {
        $user->row_status=99;
        $user->save();
        return $user;
    }


    /**
     * @param int $role_id
     * @param User $user
     * @return User
     */
    public function setRole(int $role_id,User $user): User
    {
        $user->role_id=$role_id;
        $user->save();
        return $user;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
            $rules = [
            "role_id"=>'nullable|exists:roles,id',
            "name_en"=>'required|min:3',
            "name_bn"=>'required|min:3',
            "organization_id"=>'nullable|numeric',
            "institute_id"=>'nullable|numeric',
            "loc_district_id"=>'nullable|exists:loc_divisions,id',
            "loc_division_id"=>'nullable|exists:loc_districts,id',
            "loc_upazila_id"=>'nullable|exists:loc_upazilas,id',
            "password"=>'nullable|min:6'
            ];
            if (!empty($id)) {
                $rules['email'] = 'required|email|unique:users,email,' . $id;
            } else {
                $rules['email'] = 'required|email|unique:users,email';
            }

        return Validator::make($request->all(), $rules);
    }


}
