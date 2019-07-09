<template>
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add User</h3>
                <a class="btn btn-success pull-right" id="listButton">User List</a>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="store" id="addComponent">
                <div class="box-body">
                    <div class="form-group">
                        <label for="user_name" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-8">
                            <input type="text" v-model="form.user_name" class="form-control" id="user_name" placeholder="User Name" autocomplete="off">
                            <div class="text-danger" v-if="(errors.hasOwnProperty('user_name'))">{{ (errors.hasOwnProperty('user_name')) ? errors.user_name[0] :'' }}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" v-model="form.email" class="form-control" id="email" placeholder="Email" autocomplete="off">
                            <div class="text-danger" v-if="(errors.hasOwnProperty('email'))">{{(errors.hasOwnProperty('email')) ? errors.email[0] :'' }}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Password" autocomplete="off">
                            <div class="text-danger" v-if="(errors.hasOwnProperty('password'))">{{ (errors.hasOwnProperty('password')) ? errors.password[0] :'' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-8">
                            <input type="password" v-model="form.password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="col-sm-2 control-label">User Role</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="role_id" v-model="form.role_id">
                                <option value="">Select Role</option>
                                <option v-for="(value,index) in user_role_list" :value="value.id" v-bind:key="index"> {{value.role_name}}
                                </option>
                            </select>
                            <div class="text-danger" v-if="(errors.hasOwnProperty('role_id'))">{{ (errors.hasOwnProperty('role_id')) ? errors.role_id[0] :'' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="status" v-model="form.status">
                                <option value="1"> Enable </option>
                                <option value="0"> Disable </option>
                            </select>
                            <div class="text-danger" v-if="(errors.hasOwnProperty('status'))">{{ (errors.hasOwnProperty('status')) ? errors.status[0] :'' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">User Photo</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" @change="onFileChange">
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
    import {EventBus} from '../../vue-assets';

    export default {

        props: ['user_role_list'],

        data: function () {
            return {

                list: false,
                add_form: true,
                edit_form: false,

                form: {
                    user_name: '',
                    email: '',
                    password: '',
                    role_id: '',
                    user_photo: '',
                    status: 1,
                },
                errors: {},
            };
        },

        methods: {
            store: function () {
                var _this = this;
                axios.post(base_url + 'user', _this.form).then((response) => {
                    _this.showMassage(response.data);
                    EventBus.$emit('data-changed');
                })
                    .catch(error => {
                        if (error.response.status == 422) {
                            _this.errors = error.response.data.errors;
                        } else {
                            _this.showMassage(error);
                        }
                    });
            },

            showMassage(data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success Alert');
                } else if (data.status == 'error') {
                    toastr.error(data.message, 'Error Alert');
                } else {
                    toastr.error(data.message, 'Error Alert');
                }
            },

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.user_photo = e.target.result;
                };
                reader.readAsDataURL(file);
            }

        },

        mounted() {
            var _this = this;
        },

        created() {

        }

    }
</script>