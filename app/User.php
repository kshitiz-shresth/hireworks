<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    protected $guarded = [];
    // protected $fillable = [
    //     'name', 'email', 'password', 'image','company_id','customer_id', 'package'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends =[
        'profile_image_url'
    ];

    public function getProfileImageUrlAttribute(){
        if(is_null($this->image)){
            return asset('avatar.png');
        }
        return asset('user-uploads/profile/'.$this->image);
    }

    public function role() {
        return $this->hasOne(RoleUser::class, 'user_id');
    }

    public function company(){
        return $this->belongsTo(CompanySetting::class,'company_id');
    }

    public static function allAdmins($exceptId = NULL)
    {
        $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->where('roles.name', 'admin');

        if(!is_null($exceptId)){
            $users->where('users.id', '<>', $exceptId);
        }

        return $users->get();
    }


}
