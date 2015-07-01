<?php namespace Gistvote\Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, GitHubUser
{
    use Authenticatable, CanResetPassword;

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
    protected $fillable = ['name', 'email', 'username', 'token', 'avatar'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['token', 'remember_token'];

    /**
     * A User has many Gists
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gists()
    {
        return $this->hasMany('GistVote\Gists\EloquentGist');
    }

    /**
     * Returns the username for the user
     *
     * @return string
     */
    public function username()
    {
        return $this->attributes['username'];
    }

    /**
     * Returns the profile url for the user
     *
     * @return string
     */
    public function profile()
    {
        return 'https://github.com/' . $this->username();
    }

    /**
     * Returns the avatar url for the user
     *
     * @return string
     */
    public function avatar()
    {
        return $this->attributes['avatar'];
    }
}
