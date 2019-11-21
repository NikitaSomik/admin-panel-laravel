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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Logo</th>
                                    <th>Website</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->logo }}</td>
                                    <td><img src="{{ asset('storage/images/' . $company->logo) }}" width="100" alt=""></td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Rendering engine</th>
                                    <th>Browser</th>
                                    <th>Platform(s)</th>
                                    <th>Engine version</th>
                                    <th>CSS grade</th>
                                </tr>
                                </tfoot>
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
@endsection
<!-- ./wrapper -->
@section('css')
    <link rel="stylesheet" href="/css/admin_costom.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')  }}">
@endsection
<!-- jQuery -->
{{--@section('adminlte_js')--}}
{{--    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>--}}
{{--    @stack('js')--}}
{{--    @yield('js')--}}
{{--@stop--}}
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });
</script>
</body>
</html>

