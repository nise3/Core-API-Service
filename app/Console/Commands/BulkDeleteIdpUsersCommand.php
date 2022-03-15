<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BulkDeleteIdpUsersCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "delete:idpusers";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Delete users from IDP";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usersToIgnore = [
            'f417b6fd-e713-486b-ad86-99abd379a7da',
            '3b32042d-d52d-407c-96ab-0380a8f7bfcd',
            '13772c24-5b67-4996-8a86-284538dc9f77',
            'a1842dfc-c3df-4b5a-af53-964173bc0a8e',
            'ebfc38c1-a990-42ff-a764-8823cd0b618b'
        ];

        try {

            $userQuery = User::select('idp_user_id');
            $allRows = $userQuery->whereNotIn('idp_user_id', $usersToIgnore)->get();

            $idpIds = [];
            foreach ($allRows as $row) {
                $idpIds[] = $row->idp_user_id;
            }

            if (count($idpIds)) {
               /* $response = IdpUser()
                    ->use('wso2idp')
                    ->setPayload($idpIds)
                    ->delete()
                    ->get();*/

                Log::info('Delete users from IDP');
                Log::info($idpIds);
//                Log::info($response);
                $this->info("IDP Users have been deleted");
            }


        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}
