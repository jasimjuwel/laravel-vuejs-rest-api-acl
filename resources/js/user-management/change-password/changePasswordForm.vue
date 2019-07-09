<template>
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password</h3>
            </div>
            <form class="form-horizontal" v-on:submit.prevent="store" id="addComponent">
            <div class="box-body">
                <div class="form-group">
                    <label for="current_password" class="col-sm-2 control-label">Old Password</label>
                    <div class="col-sm-8">
                        <input type="password" v-model="form.current_password" class="form-control" id="current_password" placeholder="Current Password" autocomplete="off">
                        <div class="text-danger" v-if="(errors.hasOwnProperty('current_password'))">{{ (errors.hasOwnProperty('current_password')) ? errors.current_password[0] :'' }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" v-model="form.password" class="form-control" id="password" placeholder="New Password" autocomplete="off">
                        <div class="text-danger" v-if="(errors.hasOwnProperty('password'))">{{ (errors.hasOwnProperty('password')) ? errors.password[0] :'' }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-2 control-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" v-model="form.password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" autocomplete="off">
                        <div class="text-danger" v-if="(errors.hasOwnProperty('password_confirmation'))">{{ (errors.hasOwnProperty('password_confirmation')) ? errors.password_confirmation[0] :'' }}</div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary col-md-offset-2">Save</button>
            </div>
        </form>
        </div>
    </div>
</template>

<script>
    import { EventBus } from '../../vue-assets';
    export default {

        props:[],
        data:function(){
            return{

                list:false,
                add_form:true,
                edit_form:false,
                form:{
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                var _this = this;
                axios.post(base_url+'change-password', _this.form).then( (response) => {
                     console.log(response);
                    _this.showMassage(response.data);
                    EventBus.$emit('data-changed');
                })
                .catch(error => {
                    if(error.response.status == 422){
                        _this.errors = error.response.data.errors;
                    }else{
                        _this.showMassage(error);
                    }
                });
            },

            showMassage(data){
                if(data.status == 'success'){
                    toastr.success(data.message, 'Success Alert');
                }else if(data.status == 'error'){
                    toastr.error(data.message, 'Error Alert');
                }else{
                    toastr.error(data.message, 'Error Alert');
                }
            },

        },

        mounted(){
            var _this = this;
        },

        created(){

        }

    }
</script>