
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    $('#employees').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            "url": 'employees',
            "type": "GET",
        },
        columns:[
            {
                data: 'first_name',
                name: 'first_name',
            },
            {
                data: 'last_name',
                name: 'last_name',
            },
            {
                data: 'company',
                name: 'company_id',
                render: function (data, type, full, meta) {
                    return data.name;
                },
            },
            {
                data: 'email',
                name: 'email',
            },
            {
                data: 'phone',
                name: 'phone',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ]
    });
});

$('#create_record').click(function(){
    $('.select-company').select2({
        width: '100%',
        placeholder: 'Select an option',
        ajax: {
            url: `companies/get-all?_token=${crsf}`,
            type: "POST",
            dataType: 'json',
            processResults: function (response) {
                return {
                    results: $.map(response, function (val, i) {
                        return {
                            id: val.id,
                            text: val.name
                        }
                    })
                };
            }
        }
    }).val(null).trigger('change');

    $('.modal-title').text("Add New Record");
    $('#action_button').val("Add");
    $('#action').val("Add");
    $('#formModal').modal('show');
    $('#form_result_store').empty();
    $('#sample_form')[0].reset();
    $('#store_logo').html('');
});


$('#sample_form').on('submit', function(event){
    event.preventDefault();
    $('#form_result_store').empty();

    if($('#action').val() == 'Add') {
        $('#form_result_store').empty();
        $.ajax({
            url: "employees",
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
                    $('.select-company').select2().val(null).trigger('change');
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
        let form = $('#sample_form').serializeArray();

        $.ajax({
            url: `employees/${id}`,
            data: form,
            method: "PUT",
            dataType: "json",
            success:function(data) {
                let html = '';
                $('#form_result_store').empty();

                if(data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#store_logo').html('');
                    $('.select-company').select2().val(null).trigger('change');
                    $('#employees').DataTable().ajax.reload();
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


$(document).on('click', '.edit', function(){
    let id = $(this).attr('id');
    $('#form_result_store').empty();

    $.ajax({
        url: `/admin/employees/${id}/edit`,
        dataType:"json",
        success: function(html) {
            let employee = html.data.employee;
            let { id, name } = html.data.employee.company;
            let companies = html.data.companies;
            let new_companies = companies.map((val) => {
                return {
                    id: val.id,
                    text: val.name
                }
            });

            $('.select-company').select2({
                'width': '100%',
                'tags': true,
                'data': new_companies,
            }).val(id).trigger('change');

            $('#first_name').val(employee.first_name);
            $('#last_name').val(employee.last_name);
            $('#email').val(employee.email);
            $('#phone').val(employee.phone);
            $('#hidden_id').val(employee.id);
            $('.modal-title').text("Edit New Record");
            $('#action_button').val("Edit");
            $('#action').val("Edit");
            $('#formModal').modal('show');
        }
    })
});

$(document).on('click', '.delete', function(){
    $('.custom-modal-header').remove();
    user_id = $(this).attr('id');
    $('.modal-title').text('Are you sure?');
    $('#confirmModal').modal('show');
});

$('#ok_button').click(function() {
    $('.custom-modal-header').remove();
    $.ajax({
        url: `employees/${user_id}?_token=${crsf}`,
        method:"DELETE",
        beforeSend:function(){
            $('#ok_button').text('Deleting...');
        },
        success:function(data) {
            setTimeout(function(){
                $('#confirmModal').modal('hide');
                $('#employees').DataTable().ajax.reload();
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
