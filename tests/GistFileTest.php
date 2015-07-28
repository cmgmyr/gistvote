<?php

use Gistvote\Gists\GistFile;

class GistFileTest extends TestCase
{
    use GistFixtureHelpers;

    protected function getFile($id)
    {
        $githubGist = $this->loadFixture($id . '.json');
        $firstFile = $githubGist['files'][array_keys($githubGist['files'])[0]];

        return new GistFile($firstFile['filename'], $firstFile['language'], $firstFile['content']);
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
        $file = new GistFile('testfile', 'NOLANG', null);

        $this->assertEquals('bash', $file->syntaxLanguage());
    }

    /** @test */
    public function it_should_return_file_html()
    {
        $file = $this->getFile('d34110daaaeaf12f9fe4');

        $expectedHtml = <<<FILEHTML
<pre><code class="language-php line-numbers">&lt;?php

Route::get('/', ['as' =&gt; 'home', 'uses' =&gt;'GistsController@index']);

// Gists
Route::get('{username}/{id}', ['as' =&gt; 'gists.show', 'uses' =&gt;'GistsController@show']);
Route::get('refresh', ['as' =&gt; 'gists.refresh', 'uses' =&gt;'GistsController@refresh']);

// API-ish stuff, excluded from CSRF validation. @todo: maybe find a better solution
Route::group(['prefix' =&gt; 'api'], function () {
    Route::patch('gists/{id}/activate', 'GistsController@activateGist');
    Route::patch('gists/{id}/deactivate', 'GistsController@deactivateGist');
});

// Authentication
Route::get('login', ['as' =&gt; 'login', 'uses' =&gt;'AuthController@login']);
Route::get('logout', ['as' =&gt; 'logout', 'uses' =&gt;'AuthController@logout']);
</code></pre>
FILEHTML;
        $this->assertEquals($expectedHtml, $file->renderFileHtml());
        $this->assertEquals($expectedHtml, $file->renderHtml($file->content));

        // Markdown test
        $secondFile = new GistFile('testfile', 'markdown', '# This is a heading');
        $expectedHtml = <<<FILEHTML
<div class="markdown"><h1>This is a heading</h1>
</div>
FILEHTML;
        $this->assertEquals($expectedHtml, $secondFile->renderFileHtml());
    }
}
