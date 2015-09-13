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

    $('#vote-buttons .btn').click(function() {
        var vote = $(this).data('vote');
        var comment = $('#comment-box');
        var commentText = comment.val();

        // search/replace all voting options
        commentText = commentText.replace(':+1:', '');
        commentText = commentText.replace('+1', '');
        commentText = commentText.replace(':-1:', '');
        commentText = commentText.replace('-1', '');

        // append new voting option
        comment.val(':' + vote + '1: ' + commentText.trim()).focus();

        return false;
    });
});
