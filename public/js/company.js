
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
    $('.modal-title').text("Add New Record");
    $('#action_button').val("Add");
    $('#action').val("Add");
    $('#formModal').modal('show');
    $('#form_result_store').empty();
    $('#sample_form')[0].reset();
    $('#store_logo').html('');
});

$('#sample_form').on('submit', function(event) {
    event.preventDefault();
    $('#form_result_store').empty();

    if($('#action').val() == 'Add') {
        $('#form_result_store').empty();

        $.ajax({
            url: "companies",
            method:"POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            dataType:"json",
            success:function(data) {
                let html = '';
                $('#form_result_store').empty();

                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#companies').DataTable().ajax.reload();
                }

                $('#form_result_store').html(html);
            },
            error: function (data) {
                let html = '';

                if (data && data.responseJSON && data.responseJSON.messages) {
                    let errors = data.responseJSON.messages;

                    html = '<div class="alert alert-danger">';

                    for(let i = 0; i <= errors.length - 1; i++) {
                        html += '<p>' + errors[i] + '</p>';
                    }

                    html += '</div>';
                    $('#form_result_store').html(html);
                }
            }
        })
    }

    if($('#action').val() == "Edit") {
        let id = $('#hidden_id').val();
        $('#form_result_store').empty();

        $.ajax({
            url: `companies/update/${id}`,
            data: new FormData(this),
            method: "POST",
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data) {
                let html = '';
                $('#form_result_store').empty();

                if(data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#store_logo').html('');
                    $('#companies').DataTable().ajax.reload();
                }
                $('.modal-header custom-modal-header')
                $('#form_result_store').html(html);
            },
            error: function (data) {
                let html = '';

                if(data && data.responseJSON && data.responseJSON.messages) {
                    let errors = data.responseJSON.messages;
                    html = '<div class="alert alert-danger">';

                    for(let i = 0; i <= errors.length - 1; i++) {
                        html += '<p>' + errors[i] + '</p>';
                    }

                    html += '</div>';
                    $('#form_result_store').html(html);
                }
            }
        });
    }
});

$(document).on('click', '.edit', function() {
    let id = $(this).attr('id');
    $('#form_result_store').empty();

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
    $('.custom-modal-header').remove();

    $.ajax({
        url: `companies/${user_id}?_token=${crsf}`,
        method:"DELETE",
        beforeSend:function(){
            $('#ok_button').text('Deleting...');
        },
        success:function(data) {
            setTimeout(function(){
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
            }
        }
    })
});

