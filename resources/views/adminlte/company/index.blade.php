{{--@extends('adminlte.master')--}}
{{--@section('adminlte_css_pre')--}}
{{--    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">--}}
{{--@stop--}}

{{--@section('adminlte_css')--}}
{{--    @stack('css')--}}
{{--    @yield('css')--}}
{{--@stop--}}
{{--@section('body')--}}
@extends('adminlte::page')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper custom-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">DataTable with default features</h3>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pr-3">
                            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="companies" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.0.1
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="form_result_store"></div>
                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4" >Name : </label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" />
{{--                                <div class="invalid-feedback"></div>--}}
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Email : </label>
                            <div class="col-md-8">
                                <input type="text" name="email" id="email" class="form-control" />
{{--                                <div class="invalid-feedback"></div>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Select Company Logo : </label>
                            <div class="col-md-8">
                                <input type="file" name="logo" id="logo" />
                                <span id="store_logo"></span>
{{--                                <div class="invalid-feedback"></div>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Website : </label>
                            <div class="col-md-8">
                                <input type="text" name="website" id="website" />
{{--                                <div class="invalid-feedback"></div>--}}
                            </div>
                        </div>
                        <br />
                        <div class="form-group align-content-center" >
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Add" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

{{--    <div id="formModal" class="modal fade" role="dialog">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--                    <h4 class="modal-title">Add New Record</h4>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <span id="form_result"></span>--}}
{{--                    <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="control-label col-md-4" >First Name : </label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="first_name" id="first_name" class="form-control" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="control-label col-md-4">Last Name : </label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="text" name="last_name" id="last_name" class="form-control" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="control-label col-md-4">Select Profile Image : </label>--}}
{{--                            <div class="col-md-8">--}}
{{--                                <input type="file" name="image" id="image" />--}}
{{--                                <span id="store_image"></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <br />--}}
{{--                        <div class="form-group align-content-center" >--}}
{{--                            <input type="hidden" name="action" id="action" />--}}
{{--                            <input type="hidden" name="hidden_id" id="hidden_id" />--}}
{{--                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div id="confirmModal" class="modal fade" role="dialog">--}}
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                    <h2 class="modal-title">Confirmation</h2>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>--}}
{{--                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom-width: 0px">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close CloseWindow" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer" style="border-top-width: 0px">
                    <button type="button" class="btn btn-primary bts" data-dismiss="modal">Cancel</button>
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
{{--                    <form action="{{ url('admin/place/'.$place->id) }}" method="POST" class="formDeletePlace">--}}
{{--                        {{ csrf_field() }}--}}
{{--                        {{ method_field('DELETE') }}--}}

{{--                        <input type="hidden" name="_method" value="delete" />--}}
{{--                        <button class="btn btn-danger col-md-4 bts" type="submit">--}}
{{--                            Delete--}}
{{--                        </button>--}}
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')  }}">
@endsection

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    @stack('js')
    @yield('js')

<!-- page script -->
<script>
    $(function () {
        $('#companies').DataTable({
            "processing": true,
            "serverSide": true,
            ajax: {
                "url": '/admin/companies/get-all' + '?_token=' + '{{ csrf_token() }}',
                "type": "POST",
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
                        return "<img src={{ asset('storage') }}/images/" + data + " width='70' class='img-thumbnail' />";
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

    $('#create_record').click(function(){
        $('.modal-title').text("Add New Record");
        $('#action_button').val("Add");
        $('#action').val("Add");
        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function(event){
        event.preventDefault();
        $('#form_result_store').html('');
        if($('#action').val() == 'Add') {
            $.ajax({
                url:"companies",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data) {
                    let html = '';
                    if(data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#sample_form')[0].reset();
                        $('#companies').DataTable().ajax.reload();
                    }
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
            })
        }

        if($('#action').val() == "Edit") {
            let id = $('#hidden_id').val();
            $.ajax({
                url:"companies/" + id + '?_token=' + '{{ csrf_token() }}',
                method:"PATCH",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType:"json",
                success:function(data) {
                    let html = '';
                    if(data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#sample_form')[0].reset();
                        $('#store_logo').html('');
                        $('#companies').DataTable().ajax.reload();
                    }
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
        var id = $(this).attr('id');
        $('#form_result_store').html('');
        $.ajax({
            url:"/admin/companies/"+id+"/edit",
            dataType:"json",
            success:function(html){
                $('#name').val(html.data.name);
                $('#email').val(html.data.email);
                $('#store_logo').html("<img src={{ asset('storage') }}/images/" + html.data.logo + " width='70' class='img-thumbnail' />");
                $('#store_logo').append("<input type='hidden' name='hidden_image' value='"+html.data.logo+"' />");
                $('#website').val(html.data.website);
                $('#hidden_id').val(html.data.id);
                $('.modal-title').text("Edit New Record");
                $('#action_button').val("Edit");
                $('#action').val("Edit");
                $('#formModal').modal('show');
            }
        })
    });

    let user_id;

    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"companies/" + user_id  + '?_token=' + '{{ csrf_token() }}',
            method:"DELETE",
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#companies').DataTable().ajax.reload();
                }, 2000);
            }
        })
    });

</script>
@stop

