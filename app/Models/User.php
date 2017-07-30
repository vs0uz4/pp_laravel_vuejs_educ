<?php

namespace SiGeEdu\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SiGeEdu\Notifications\MyOwnResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements TableInterface
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_TEACHER = 2;
    const ROLE_STUDENT = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enrolment', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $data
     * @return mixed
     */
    public static function createFully($data){
        $password = str_random(6);
        $enrolment = str_random(6);

        $data['password'] = bcrypt($password);
        $data['enrolment'] = $enrolment;

        $user = parent::create($data);
        self::assignEnrolment($user, self::ROLE_ADMIN);
        $user->save();

        return compact('user', 'password');
    }

    /**
     * @param User $user
     * @param $type
     * @return mixed
     */
    public static function assignEnrolment(User $user, $type){
        $types = [
            self::ROLE_ADMIN   => 100000,
            self::ROLE_TEACHER => 400000,
            self::ROLE_STUDENT => 700000,
        ];

        $user->enrolment = $types[$type] + $user->id;

        return $user->enrolment;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return ['ID', 'Enrolment', 'Name', 'Email'];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header){
            case 'ID':
                return $this->id;
            case 'Enrolment':
                return $this->enrolment;
            case 'Name':
                return $this->name;
            case 'Email':
                return $this->email;
        }
    }
}
