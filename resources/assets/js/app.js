$(function () {
    $('.enable_voting').change(function() {
        var gistId = $(this).data('id');
        var url = '/api/gists/' + gistId + '/deactivate';

        if ($(this).is(':checked')) {
            url = '/api/gists/' + gistId + '/activate';
        }

        $.post(url, {_method: 'patch'}).fail(function(data) {
            // @todo: handle failure
            console.log('oops, something went wrong!');
        });
    });
});