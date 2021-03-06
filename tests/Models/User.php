<?php

/*
 * This file is part of CarePlan Manager by CircleLink Health.
 */

namespace Venturecraft\Revisionable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Add a revisionable model for testing purposes
 * I've chosen User, purely because the migration will already exist.
 * 
 * Class User
 *
 * @property int $id
 * @property int|null $saas_account_id
 * @property int $skip_browser_checks Skip compatible browser checks when the user logs in
 * @property int $count_ccm_time
 * @property string $username
 * @property string $program_id
 * @property string $password
 * @property string $email
 * @property string|null $user_registered
 * @property int $user_status
 * @property int $auto_attach_programs
 * @property string $display_name
 * @property string $first_name
 * @property string $last_name
 * @property string|null $suffix
 * @property string $address
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string|null $timezone
 * @property string $status
 * @property int $access_disabled
 * @property int|null $is_auto_generated
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $last_login
 * @property int $is_online
 * @property string|null $last_session_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereAccessDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereAutoAttachPrograms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereCountCcmTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereIsAutoGenerated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereIsOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereLastSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereSaasAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereSkipBrowserChecks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereUserRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Venturecraft\Revisionable\Tests\Models\User whereZip($value)
 * @mixin \Eloquent
 * @property-read int|null $revision_history_count
 */
class User extends Model
{
    use RevisionableTrait;

    protected $guarded = [];
}
