@extends('master')
@section('title','User Role')
@section('main_content')

<section class="content-header">
    <h1> @yield('title')</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>User Management</li>
        <li class="active">@yield('title')</li>
    </ol>
</section>

<section class="content">
    <div class="row" id="demo-app">
        <div class="col-md-12">
            <role-list
                    :user_role_list="{{json_encode($userRoleList)}}"
                    :permissions="{{ json_encode(permissionCheck()) }}"
            ></role-list>
        </div>
    </div>
</section>

@endsection

@push('custom_scripts')
    <script type="text/javascript" src="{!! asset('js/user-management/role.js') !!}"></script>
@endpush
