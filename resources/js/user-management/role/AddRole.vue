<template>
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Role</h3>
                <a class="btn btn-success pull-right" id="listButton">Role List</a>
            </div>
            <form class="form-horizontal" v-on:submit.prevent="store" id="addComponent">
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
                    <button type="submit" class="btn btn-primary col-md-offset-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {EventBus} from '../../vue-assets';

    export default {

        props: [],
        data: function () {
            return {

                list: false,
                add_form: true,
                edit_form: false,
                form: {
                    role_name: '',
                    status: 1,
                },
                errors: {},
            };
        },

        methods: {
            store: function () {
                var _this = this;
                axios.post(base_url + 'role', _this.form).then((response) => {
                    console.log(response);
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

        },

        mounted() {
            var _this = this;
        },

        created() {

        }

    }
</script>