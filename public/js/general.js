
export const error_data = (data) => {
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

export const set_html_result_storage = (html) => {
    $('#form_result_store').html(html);
};

export const set_empty_result_store = () => {
    $('#form_result_store').empty();
};

export const ajaxDelete = (url) => {
    action_button(true);
    $('.custom-modal-header').remove();

    $.ajax({
        url: url,
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
};

let action_button = (bool) => {
    $('#ok_button').prop('disabled', bool);
};

