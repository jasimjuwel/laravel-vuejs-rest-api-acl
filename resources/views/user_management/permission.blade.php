@extends('master')
@section('title','Permission')
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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Permission</h3>
                </div>
                <div class="box-body">
                    <form method="post" action="{{ route('menu-permission.store') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-gorup">
                                <label>User Role</label>
                                <select name="role_id" class="form-control role_id" id="role_id" onchange="getRoleWiseMenuList(this)">
                                    <option value="">Select Role</option>
                                    @foreach($roleList as $value)
                                    <option value="{{ $value->id }}">{{ $value->role_name }}</option>
                                    @endforeach
                                </select>
                                    @if($errors->has('role_id')) <span class="text-danger">{{ $errors->first('role_id') }}</span> @endif
                            </div>
                            <br><br>

                            <div class="form-group menuLoad" id="permission">

                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" value="Submit" id="submitForm" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</section>
@endsection


@push('custom_scripts')
<script type="text/javascript">

    $(document).on('change','[data-menu]',function(event){
        if(this.checked==false){
            var getMenuId = $(this).attr('data-menu');
            $('[data-formenu="'+getMenuId+'"]').prop('checked',false);
        }else{
            var getMenuId = $(this).attr('data-menu');
            $('[data-formenu="'+getMenuId+'"]').prop('checked',true);
        }
    });

    $(document).on('change','[data-formenu]',function(event){
        if(this.checked==true){
            var getMenuId = $(this).attr('data-formenu');
            $('[data-menu="'+getMenuId+'"]').prop('checked',true);
        }
    });

    $(document).on("click", '.checkAll', function (event) {
        if (this.checked) {
            $('.inputCheckbox').each(function () {
                this.checked = true;
            });
        } else {
            $('.inputCheckbox').each(function () {
                this.checked = false;
            });
        }
    });


    function getRoleWiseMenuList(select){

        var role_id=$('.role_id').val();

        if(role_id != '' ){
            $('body').find('#submitForm').attr('disabled', false);
        }else{
            $('.inputCheckbox').each(function(){
                this.checked = false;
            });

            $('body').find('#submitForm').attr('disabled', true);
        }
        var action = "{{ URL::to('get-all-menus') }}";
        $.ajax({
            type:'POST',
            url: action,
            data: {role_id:role_id, '_token': $('input[name=_token]').val()},

            success:function(result){

                var subMenus,checkedValue;
                var dataFormat = '<h1>Pages Permission</h1>';
                dataFormat += '<div id="area_select" class="" style="margin-top: 20px">';
                dataFormat += '<div class="checkbox checkbox-info" style="">';
                dataFormat += '<div class="">';
                dataFormat += '<label class="">';
                dataFormat += '<input type="checkbox" class=" inputCheckbox checkAll" id="inlineCheckbox">Select All <span></span>';
                dataFormat += '</label>';
                dataFormat += '</div>';

                var sl=1;
                $.each(result.arrayFormat, function (key, value) {

                    dataFormat += '<span class="text-center module_name" style="font-weight:400; font-size:16px">' + key + ' </span>';
                    $.each(value, function (key1, value1) {
                        sl++;
                        checkedValue = '';
                        if (value1['hasPermission'] == 'yes') {
                            checkedValue = 'checked';
                        }
                        dataFormat += '<div class=""> ';
                        dataFormat += '<label class="menu-label"> ';
                        dataFormat += '<input class="inputCheckbox" data-menu="' + value1['id'] + '" type="checkbox" id="inlineCheckbox1'+sl+'" ' + checkedValue + ' name="menu_id[]" value="' + value1['id'] + '"> '+ value1['menu_name'];
                        dataFormat += '<span></span></label></div>';
                        dataFormat += '</label>';
                        dataFormat += '</div>';
                        if(result.subMenu[value1['id']] !== undefined){
                            subMenus = result.subMenu[value1['id']];
                            var i=1;
                            dataFormat += '<div class="">';
                            dataFormat += '<div class="">';
                            for(var subMenuIndex in subMenus){
                                checkedValue='';
                                if(subMenus[subMenuIndex].hasPermission=='yes'){
                                    checkedValue='checked';
                                }
                                if(i==1){
                                }
                                i++;
                                dataFormat += '<label class="menu-action-label" >';
                                dataFormat += '<input type="checkbox" class="inputCheckbox" id="inlineCheckbox'+subMenus[subMenuIndex].id+'" value="' + subMenus[subMenuIndex].id + '" data-formenu="' + value1['id'] + '" '+checkedValue+' name="menu_id[]" value="'+subMenus[subMenuIndex].id+'">'+' '+subMenus[subMenuIndex].menu_name;
                                dataFormat += '<span></span>';
                                dataFormat += '</label>';
                            }
                            dataFormat += '</div>';
                            dataFormat += '</div>';
                            i=1;
                        }
                    })
                });
                $('.menuLoad').html(dataFormat);
            }
        });
    }
</script>
@endpush



