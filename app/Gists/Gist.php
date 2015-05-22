<?php namespace Gistvote\Gists;

use Illuminate\Database\Eloquent\Model;

class Gist extends Model
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

    public function getFileContentSnippetAttribute()
    {
        $content = $this->attributes['file_content'];

        // split content by lines
        $contents = explode(PHP_EOL, $content);

        $newContents = array_slice($contents, 0, 10);

        return implode(PHP_EOL, $newContents);
    }

    public function getFileLanguageHighlightAttribute()
    {
        $language = strtolower($this->attributes['file_language']);

        if ($language == '' || !in_array($language, \Config::get('prismjs'))) {
            $language = 'bash';
        }

        return $language;
    }
}
