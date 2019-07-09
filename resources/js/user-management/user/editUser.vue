<template>
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User</h3>
                <a class="btn btn-success pull-right" id="listButton">User List</a>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" id="editComponent">
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
                            <div class="text-danger" v-if="(errors.hasOwnProperty('email'))">{{ (errors.hasOwnProperty('email')) ? errors.email[0] :'' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role_id" class="col-sm-2 control-label">User Role</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="role_id" v-model="form.role_id">
                                <option v-for="(value,index) in user_role_list" :value="value.id" v-bind:key="index">{{value.role_name}}</option>
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
                        <label for="photo" class="col-sm-2 control-label">User Photo</label>
                        <div class="col-sm-8">
                            <input type="file" id="photo" class="form-control" @change="onFileChange">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../../vue-assets';

    export default {

        props: ['editId', 'user_role_list'],

        data: function () {
            return {
                list: false,
                add_form: true,
                edit_form: true,

                form: {
                    user_name: '',
                    email: '',
                    password: '',
                    role_id: '',
                    user_edit_photo: '',
                    status: '',
                },
                errors: {},
            };
        },

        methods: {
            edit(id) {
                var _this = this;
                axios.get(base_url + 'user/' + id + '/edit')
                    .then((response) => {
                        _this.form = response.data;
                    });
            },

            update(id) {
                axios.put(base_url + 'user/' + id, this.form).then((response) => {
                    this.showMassage(response.data);
                    EventBus.$emit('data-changed');
                })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            this.showMassage(error);
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
                    vm.form.user_edit_photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
        },

        mounted() {

        },

        created() {
            var _this = this;
            _this.edit(_this.editId);
        }

    }
</script>