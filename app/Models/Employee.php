<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $no_upper = ['your', 'keys', 'here'];

    public $approvalScopeDisabled = true;


    protected $fillable = [
        'avatar',
        'man_no',
        'title_id',
        'title',
        'firstname',
        'middlename',
        'lastname',
        'maiden_name',

        'blood_group_id',

        'tpin',

        'nrc_number',
        'nrc_issue_place',
        'nrc_date_of_issue',

        'passport_number',
        'passport_issue_place',
        'passport_date_of_issue',

        'driving_licence_number',
        'driving_licence_issue_place',
        'driving_licence_date_of_issue',

        'date_of_birth',
        'place_of_birth',
        'date_of_death',
        'gender',
        'height',
        'weight',
        'religion_id',
        'marital_status_id',
        'marital_status',
        'spouse_id',
        'status_id',

        'email',
        'personal_email',
        'mobile_number',
        'phone_extension',

        'password',
        'access_token',

        'ethnic_id',
        'village',
        'chief',
        'ethnic_location',
        'ethnic_sub_location',
        'division',
        'district_id',
        'country_id',
        'nationality_id',

        'pension_scheme_id',
        'pension_scheme_number',

        'user_access_level_id',
        'user_group_id',
        'status',

        'personnel_number',
        'employment_status',
        'employment_type_id',
        'posting_sub_unit',
        'position_id',
        'salary',
        'offer_date',
        'actual_joining_date',
        'probation_end_date',
        'confirmation_date',
        'next_increment_date',
        'last_working_date',
        'termination_date',
        'leave_entitlement_start_date',
        'banned_until',
        'remarks',
        'bu_code',
        'cc_code',

        'grade_id',
        'sub_grade',

        'user_unit_code',
        'user_unit_id',

        'directorate',
        'location_id',
        'station',
        'union_id',
        'functional_section_id',

        'contract_type',
        'con_st_code',
        'con_wef_date',
        'con_wet_date',

        'registering_officer_name',
        'registering_officer_man_no',
        'registering_officer_job_title',
        'registered_date',

        'appointing_officer_name',
        'appointing_officer_man_no',
        'appointing_officer_job_title',
        'appointing_date',
        'password',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'actual_joining_date' => 'date',
//        'status_id' => EmployeeStatus::class
    ];

    protected $appends = ['fullname'];
    protected $with = [
        'location',
        'functionalSection',
        'position',
        'grade'
    ];



    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200);

        //You can also register multiple conversions for the same model, just add more rules to the method:
        $this->addMediaConversion('bigthumb')
            ->width(300)
            ->height(300);
    }


}
