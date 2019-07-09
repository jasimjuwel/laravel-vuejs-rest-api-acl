<template>
    <div>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title pull-left">Edit Role</h3>
            </div>
            <div class="">
                <a type="button" class="btn btn-block btn-success btn-md pull-right" style="width:150px"
                   id="listButton">User List</a>
            </div>
            <form class="form-horizontal" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)"
                  id="editComponent">
                <div class="box-body">
                    <div class="form-group">
                        <label for="role_name" class="col-sm-2 control-label">Role Name</label>
                        <div class="col-sm-8">
                            <input type="text" v-model="form.role_name" class="form-control" id="role_name" placeholder="Role Name" autocomplete="off">
                            <div class="text-danger" v-if="(errors.hasOwnProperty('role_name'))">{{ (errors.hasOwnProperty('role_name')) ? errors.role_name[0] :'' }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="status" v-model="form.status">
                                <option value="1"> Active </option>
                                <option value="2"> Inactive </option>
                            </select>
                            <div class="text-danger" v-if="(errors.hasOwnProperty('status'))">{{ (errors.hasOwnProperty('status')) ? errors.status[0] :'' }}</div>
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

        props: ['editId'],

        data: function () {
            return {
                list: false,
                add_form: true,
                edit_form: true,

                form: {
                    role_name: '',
                    status: ''
                },
                errors: {},
            };
        },

        methods: {
            edit(id) {
                var _this = this;
                axios.get(base_url + 'role/' + id + '/edit')
                    .then((response) => {
                        _this.form = response.data;
                    });
            },

            update(id) {
                axios.put(base_url + 'role/' + id, this.form).then((response) => {
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
        },

        mounted() {

        },

        created() {
            var _this = this;
            _this.edit(_this.editId);
        }

    }
</script>