<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use DB;

class EmailLogin extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'email_logins';

    public $fillable = ['email', 'token'];

    public function user()
    {
        return $this->hasOne(\App\User::class, 'email', 'email');
    }

    public static function createForEmail($email)
    {
        return self::create([
            'email' => $email,
            'token' => str_random(20)
        ]);
    }

    public static function validFromToken($token)
    {
        return self::where('token', $token)
            ->where('created_at', '>', Carbon::parse('-1440 minutes'))
            ->firstOrFail();
    }

    public static function updateUserStatus($token)
    {
        return DB::table('email_logins')->where('token', $token)->update('confirmed',1);
    }

    public static function deleteOldTokens($email)
    {
        return self::where('email', $email)->delete();
    }
}
