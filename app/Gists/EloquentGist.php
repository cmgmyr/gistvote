<?php namespace Gistvote\Gists;

use Illuminate\Database\Eloquent\Model;

class EloquentGist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gists';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'file',
        'file_language',
        'file_content',
        'description',
        'public',
        'files',
        'comments',
        'enable_voting',
        'created_at',
        'updated_at',
        'last_scan'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'last_scan'];
}
