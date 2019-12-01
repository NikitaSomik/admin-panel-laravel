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
            @component('adminlte.employee.custom_content')
            @endcomponent
        </section>
        <!-- /.content -->
    </div>

    <footer class="main-footer">
        @component('adminlte.general.footer')
        @endcomponent
    </footer>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        @component('adminlte.employee.modal_form')
        @endcomponent
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        @component('adminlte.employee.confirm_modal')
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

<script>
    let user_id;
    let crsf = '{{ csrf_token() }}';
</script>
    <script type="module" src="{{ asset('js/employee.js') }}"></script>
@stop

