<?php namespace App\Http\Models;

use App\Http\Models\Notification;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', "about", "fullname", "avatar", "background"];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function invites(){
        return $this->hasMany("App\\Http\\Models\\Invite")->where("registered", "=", false);
    }

    public function myEvents(){
        return $this->belongsToMany("App\\Http\\Models\\Event", "event_guests")->where("date", ">=", \DB::raw("CURDATE()"))->orderBy("date")->where("event_guests.type", "!=", "no");
    }

    public function myPastEvents(){
        return $this->belongsToMany("App\\Http\\Models\\Event", "event_guests")->where("date", "<", \DB::raw("CURDATE()"))->orderBy("date", "desc")->where("event_guests.type", "!=", "no");
    }

    public function eventsFiltered($date1, $date2){
        $date1 = date('Y-m-d', $date1);
        $date2 = date('Y-m-d', $date2);
        return $this->belongsToMany("App\\Http\\Models\\Event", "event_guests")
            ->where("event_guests.type", "!=", "no")
            ->where("date", ">=", $date1)
            ->where("date", "<", $date2)->paginate(20);
    }

    public function getFullname(){
        if($this->fullname){
            return $this->fullname;
        }else{
            return $this->username;
        }
    }

    public function circles(){
        return $this->hasMany("App\\Http\\Models\\Circle");
    }

    public function circle(){
        return $this->belongsToMany("App\\Http\\Models\\Circle");
    }

    public function getAvatar(){
        if($this->avatar){
            return "/avatars/" . $this->avatar;
        }else{
            return "/img/nouser.png";
        }
    }

    public function events(){
        return $this->hasMany("App\\Http\\Models\\Event");
    }

    public function getBackground(){
        if($this->background){
            return "/backgrounds/" . $this->background;
        }else{
            return "/img/pattern.jpg";
        }
    }

    public function setNotification($target, $type, $post = null){
        $notification = new Notification;
        $notification->user_id = $this->id;
        $notification->target_id = $target;
        $notification->type = $type;
        $notification->event_id = $post;
        $notification->save();
    }

    public function conversations(){
        return $this->belongsToMany("App\\Http\\Models\\Conversation")->withPivot("conversation_id");
    }

    public function isAdmin(){
        if($this->role == "admin"){
            return true;
        }

        return false;
    }

    public function checkInvite(){
        $user = $this;

        if($user->invites){
            DB::table("invites")->where("email", "=", $user->email)->update(["registered" => true]);

            $circle_ids = DB::table("invites")->where("email", "=", $user->email)->lists("circles");
            if($circle_ids){
                $user->circle()->sync(explode(",", $circle_ids[0]));
            }

            $user_id = DB::table("invites")->where("email", "=", $user->email)->lists("user_id");
            $user->setNotification($user_id[0], "registered");
        }
    }

}
