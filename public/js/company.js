
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(function () {
    $('#companies').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            "url": 'companies',
            "type": "GET",
        },
        columns:[
            {
                data: 'name',
                name: 'name',
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'logo',
                name: 'logo',
                render: function (data, type, full, meta) {
                    let path =  `${storage}/images/${data}`;
                    return "<img src=" + path + " width='70' class='img-thumbnail' />";
                },
                orderable: false
            },
            {
                data: 'website',
                name: 'website',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ]
    });
});

$('#create_record').click(function() {
    $('.modal-title').text('Add New Record');
    $('#action_button').val('Add');
    $('#action').val('Add');
    $('#formModal').modal('show');
    $('#form_result_store').empty();
    $('#sample_form')[0].reset();
    $('#store_logo').html('');
});

$('#sample_form').on('submit', function(event) {
    event.preventDefault();
    set_empty_result_store();
    let actionVal = $('#action').val();

    console.log(actionVal)
    if(actionVal === 'Add') {
        let url = 'companies';
        let data = new FormData(this);
        ajaxAction(url, data);
    }

    if(actionVal === 'Edit') {
        let id = $('#hidden_id').val();
        let url = `companies/update/${id}`;
        let data = new FormData(this);
        ajaxAction(url, data);
    }
});

$(document).on('click', '.edit', function() {
    let id = $(this).attr('id');
    set_empty_result_store();

    $.ajax({
        url: `/admin/companies/${id}/edit`,
        dataType:"json",
        success:function(html) {
            $('#name').val(html.data.name);
            $('#email').val(html.data.email);
            $('#store_logo').html("<img src=" + storage + "/images/" + html.data.logo + " width='70' class='img-thumbnail' />");
            $('#store_logo').append("<input type='hidden' name='hidden_image' value='" + html.data.logo + "' />");
            $('#website').val(html.data.website);
            $('#hidden_id').val(html.data.id);
            $('.modal-title').text("Edit New Record");
            $('#action_button').val("Edit");
            $('#action').val("Edit");
            $('#formModal').modal('show');
        }
    })
});

$(document).on('click', '.delete', function() {
    $('.custom-modal-header').remove();
    user_id = $(this).attr('id');
    $('.modal-title').text('Are you sure?');
    $('#confirmModal').modal('show');
});

$('#ok_button').click(function() {
    action_button(true);
    $('.custom-modal-header').remove();

    $.ajax({
        url: `companies/${user_id}?_token=${crsf}`,
        method: 'DELETE',
        beforeSend:function(){
            $('#ok_button').text('Deleting...');
        },
        success:function(data) {
            setTimeout(function(){
                action_button(false);
                $('#confirmModal').modal('hide');
                $('#companies').DataTable().ajax.reload();
            }, 1000);
        },
        error: function (data) {
            $('.modal-content')
                .prepend(
                    '<div class="modal-header custom-modal-header">\n' +
                    '<div class="confirm_modal_result_store"></div>\n' +
                    '</div>'
                );

            let html = '';
            $('#ok_button').text('Delete');
            if(data && data.responseJSON && data.responseJSON.messages) {
                let errors = data.responseJSON.messages;
                html = '<div class="alert alert-danger">';

                for(let i = 0; i <= errors.length - 1; i++) {
                    html += '<p>' + errors[i] + '</p>';
                }

                html += '</div>';
                $('.confirm_modal_result_store').html(html);
                action_button(false);
            }
        }
    })
});



let ajaxAction = (url, data) => {
    $.ajax({
        url: url,
        method:"POST",
        data: data,
        contentType: false,
        cache:false,
        processData: false,
        dataType: 'json',
        success:function(data) {
            success_data(data);
        },
        error: function (data) {
            error_data(data);
        }
    })
};

let action_button = (bool) => {
    $('#ok_button').prop('disabled', bool);
}

let set_empty_result_store = () => {
    $('#form_result_store').empty();
};

let set_html_result_storage = (html) => {
    $('#form_result_store').html(html);
};

let success_data = (data) => {
    let html = '';

    if (data.success) {
        html = '<div class="alert alert-success">' + data.success + '</div>';
        $('#sample_form')[0].reset();
        $('#store_logo').html('');
        $('#companies').DataTable().ajax.reload();
    }

    set_html_result_storage(html);
};

let error_data = (data) => {
    let html = '';

    if (data && data.responseJSON && data.responseJSON.messages) {
        let errors = data.responseJSON.messages;
        html = '<div class="alert alert-danger">';

        for(let i = 0; i <= errors.length - 1; i++) {
            html += '<p>' + errors[i] + '</p>';
        }

        html += '</div>';
        set_html_result_storage(html);
    }
};

