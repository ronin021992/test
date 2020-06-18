$(function () {
    $('.btn_nav a').click(function () {
        var page = Number($(this).attr("data-page"));
        var limit = Number($(this).attr("data-limit"));
        BX.ajax.runComponentAction(
            'test:users.list',
            'getUsers',
            {
                mode: 'class',
                data: {post: {page : page, limit: limit}}
            })
            .then(function (response) {
                if (response.status === 'success') {
                    var html = '';
                    $.each(response.data, function (i, value) {
                        html = html + "<tr><td>"+value.ID+"</td><td>"+value.NAME+"</td></tr>";
                    });
                    $('tbody').html(html);
                }
            });
    });
});