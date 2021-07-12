<?php

namespace App\Models;


use App\Traits\Scopes\ScopeRowStatusTrait;

/**
 * Class Organization
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property string address
 * @property string mobile
 * @property string email
 * @property string fax_no
 * @property string contact_person_name
 * @property string contact_person_mobile
 * @property string contact_person_email
 * @property string contact_person_designation
 * @property string description
 * @property string logo
 * @property string domain
 * @property int role_id
 */
class Organization extends BaseModel
{
    use ScopeRowStatusTrait;

    protected $guarded = ['id'];


}
