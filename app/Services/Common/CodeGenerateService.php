<?php

namespace App\Services\Common;

use App\Models\BaseModel;
use App\Models\UserCodePessimisticLocking;
use Illuminate\Support\Facades\DB;
use Throwable;

class CodeGenerateService
{
    /**
     * @throws Throwable
     */
    public static function getUserCode(int $userType): string
    {
        $userCode = "";
        DB::beginTransaction();
        try {
            /** @var UserCodePessimisticLocking $existingSSPCode */
            $existingCode = UserCodePessimisticLocking::lockForUpdate()->first();
            $code = !empty($existingCode) && !empty($existingCode->last_incremental_value) ? $existingCode->last_incremental_value : 0;
            $code = $code + 1;
            $padSize = BaseModel::USER_CODE_SIZE - strlen($code);

            /**
             * Prefix+000000N. Ex: USYS+incremental number
             */
            $userCode = str_pad(BaseModel::USER_CODE_PREFIXES[$userType],$padSize, '0', STR_PAD_RIGHT) . $code;

            /**
             * Code Update
             */
            if ($existingCode) {
                $existingCode->last_incremental_value = $code;
                $existingCode->save();
            } else {
                UserCodePessimisticLocking::create([
                    "last_incremental_value" => $code
                ]);
            }
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
        return $userCode;
    }
}
