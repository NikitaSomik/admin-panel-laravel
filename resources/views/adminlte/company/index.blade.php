@extends('adminlte::page')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper custom-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @component('adminlte.general.header')
            @endcomponent
        </section>

        <!-- Main content -->
        <section class="content">
        @component('adminlte.company.custom_content')
        @endcomponent
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @component('adminlte.general.footer')
        @endcomponent
    </footer>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        @component('adminlte.company.modal_form')
        @endcomponent
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        @component('adminlte.company.confirm_modal')
        @endcomponent
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
    let user_id;
    let storage = {!! json_encode(asset('storage')) !!};
    let default_logo = {!! json_encode(asset('images/default-logo.png')) !!};
    let crsf = '{{ csrf_token() }}';
</script>
    <script type="module" src="{{ asset('js/company.js') }}"></script>
@stop

