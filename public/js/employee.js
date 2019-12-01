import {
    error_data, ajaxDelete,
    set_html_result_storage,
    set_empty_result_store
} from './general.js';

$(function () {
    $('#employees').DataTable({
        'processing': true,
        'serverSide': true,
        ajax: {
            'url': 'employees',
            'type': 'GET',
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
            type: 'POST',
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

    $('.modal-title').text('Add New Record');
    $('#action_button').val("Add");
    $('#action').val('Add');
    $('#formModal').modal('show');
    $('#form_result_store').empty();
    $('#sample_form')[0].reset();
    $('#store_logo').html('');
});


$('#sample_form').on('submit', function(event){
    event.preventDefault();
    set_empty_result_store();
    let actionVal = $('#action').val();

    if(actionVal === 'Add') {
        let url = `employees`;
        let data = $('#sample_form').serializeArray();
        ajaxAction(url, data);
    }

    if(actionVal === "Edit") {
        let method = 'PUT';
        let id = $('#hidden_id').val();
        let url = `employees/${id}`;
        let data = $('#sample_form').serializeArray();
        ajaxAction(url, data, method);
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
    let url = `employees/${user_id}?_token=${crsf}`;
    ajaxDelete(url);
});



let ajaxAction = (url, data, method = 'POST') => {
    $.ajax({
        url: url,
        data: data,
        method: method,
        dataType: 'json',
        success:function(data) {
            success_data(data);
        },
        error: function (data) {
            error_data(data);
        }
    });
};

let success_data = (data) => {
    let html = '';

    if (data && data.success) {
        html = '<div class="alert alert-success">' + data.success + '</div>';
        $('#sample_form')[0].reset();
        $('#store_logo').html('');
        $('.select-company').select2().val(null).trigger('change');
        $('#employees').DataTable().ajax.reload();
    }

    set_html_result_storage(html);
};

