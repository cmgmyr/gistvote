$(function () {
    $('.enable_voting').change(function() {
        var url;
        var gistId = $(this).data('id');

        if ($(this).is(':checked')) {
            console.log(gistId, 'has been turned on.');
            url = '/api/gists/' + gistId + '/activate';
        } else {
            console.log(gistId, 'has been turned off.');
        }

        $.post(url, {_method: 'patch'}, function(data) {
            console.log('everything ok');
        });
    });
});