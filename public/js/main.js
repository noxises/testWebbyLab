$(document).ready(() => {
    if (localStorage.Response) {
        let response = localStorage.Response;
        let status = localStorage.Status;
        $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${status}`).html(response);
        localStorage.clear();
    }
    $('#txt_film').submit(function (e) {
        e.preventDefault();
        let input;
        input = $("input[name*='file']");
        var file_data = input.prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        $.ajax({
            url: '/movie/savefromfile',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                var message = $.parseJSON(php_script_response);
                if (message.status==='success'){
                    window.location.replace('/');
                    localStorage.setItem("Response", message.message)
                    localStorage.setItem("Status", message.status)
                }else{
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${message.status}`).html(message.message);

                }

            }
        });

    });

    $('#delete').click(function (e) {
        e.preventDefault();
        let item = {};
        item[0] = $(this).attr('name');

        $.ajax({
            url: '/movie/delete',
            cache: false,
            processData: true,
            data: item,
            type: 'post',
            success: function (php_script_response) {
                window.location.replace('/');
                localStorage.setItem("Response", php_script_response.message)
                localStorage.setItem("Status", php_script_response.status)
            },
        });

    });
    $('#delete_selected').submit(function (e) {
        e.preventDefault();
        let items = {};
        $.each($("input[name='products[]']:checked"), function (index) {
            items[index] = $(this).val();
        });
        $.ajax({
            url: '/movie/delete',
            cache: false,
            processData: true,
            data: items,
            type: 'post',
            success: function (php_script_response) {
                localStorage.setItem("Response", php_script_response.message)
                localStorage.setItem("Status", php_script_response.status)
                window.location.reload();


            },
        });

    });

    $('#create').submit(function (e) {
        e.preventDefault();
        let inputs = {};
        $(this).find(':input').each(function () {
            inputs[$(this).attr("name")] = $(this).val();
        });

        $.ajax({
            url: '/movie/create',
            cache: false,
            processData: true,
            data: inputs,
            type: 'post',
            success: function (php_script_response) {
                $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);

                if(php_script_response.id != undefined){
                    $('#link_to_movie').show().attr("href", "/movie/" + php_script_response.id)

                }

            }
        });

    });

    $('#login_form').submit(function (e) {
        e.preventDefault();
        let inputs = {};
        $(this).find(':input').each(function () {
            inputs[$(this).attr("name")] = $(this).val();
        });

        $.ajax({
            url: '/login/authorization',
            cache: false,
            processData: true,
            data: inputs,
            type: 'post',
            success: function (php_script_response) {
                if (php_script_response.status === 'danger') {
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);
                } else {
                    window.location.replace('/');
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                }

            }
        });

    });

    $('#registration_form').submit(function (e) {
        e.preventDefault();
        let inputs = {};
        $(this).find(':input').each(function () {
            inputs[$(this).attr("name")] = $(this).val();
        });
        $.ajax({
            url: '/registration/create',
            cache: false,
            processData: true,
            data: inputs,
            type: 'post',
            success: function (php_script_response) {
                if (php_script_response.status === 'danger') {
                    $('#message').show().removeClass('alert-success alert-danger').addClass(`alert-${php_script_response.status}`).html(php_script_response.message);
                } else {
                    window.location.replace('/');
                    localStorage.setItem("Response", php_script_response.message)
                    localStorage.setItem("Status", php_script_response.status)
                }

            }
        });

    });
    $('#logout').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: '/logout',
            success: function (php_script_response) {
                window.location.replace('/');
                localStorage.setItem("Response", php_script_response.message)
                localStorage.setItem("Status", php_script_response.status)
            }
        });
    });


});

