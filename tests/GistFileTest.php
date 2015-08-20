<?php

use Gistvote\Gists\Gist;
use Gistvote\Gists\GistFile;
use Mockery as m;

class GistFileTest extends TestCase
{
    use GistFixtureHelpers;

    protected function getFile($id)
    {
        $gist = m::mock(Gist::class);
        $githubGist = $this->loadFixture($id . '.json');
        $firstFile = $githubGist['files'][array_keys($githubGist['files'])[0]];

        return new GistFile($gist, $firstFile['filename'], $firstFile['language'], $firstFile['content']);
    }

    /** @test */
    public function it_should_return_file_snippet()
    {
        $file = $this->getFile('d34110daaaeaf12f9fe4');

        $expectedSnippet = <<<SNIPPET
&lt;?php

Route::get('/', ['as' =&gt; 'home', 'uses' =&gt;'GistsController@index']);

// Gists
Route::get('{username}/{id}', ['as' =&gt; 'gists.show', 'uses' =&gt;'GistsController@show']);
Route::get('refresh', ['as' =&gt; 'gists.refresh', 'uses' =&gt;'GistsController@refresh']);

// API-ish stuff, excluded from CSRF validation. @todo: maybe find a better solution
Route::group(['prefix' =&gt; 'api'], function () {
SNIPPET;
        $this->assertEquals($expectedSnippet, $file->snippet());

        $expectedSnippet = '<pre><code class="language-php line-numbers">'.$expectedSnippet.'</code></pre>';
        $this->assertEquals($expectedSnippet, $file->renderSnippetHtml());
    }

    /** @test */
    public function it_should_return_file_syntax_language()
    {
        $file = $this->getFile('d34110daaaeaf12f9fe4');

        $this->assertEquals('php', $file->syntaxLanguage());
    }

    /** @test */
    public function it_should_return_default_file_syntax_language()
    {
        $gist = m::mock(Gist::class);
        $file = new GistFile($gist, 'testfile', 'NOLANG', null);

        $this->assertEquals('bash', $file->syntaxLanguage());
    }
}
