<style scoped>
    .imageSize {
        width: 30px;
        height: 30px;
    }
</style>
<template>
    <div>
        <div class="box box-primary" v-if="list">
            <div class="box-header with-border">
                <h3 class="box-title"> User List</h3>
                <a v-if="permissions.indexOf('user.store') != -1" class="btn btn-success pull-right" id="addButton">Add User</a>
            </div>
            <div class="box-body">
                <div id="main">
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Show</span>
                            <select name="per_page" class="per_page" @change="changePerPage" v-model="perPage">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                            </select>
                            <span>Entries</span>
                        </div>
                        <div class="col-sm-6">
                            <div id="example1_filter" class="dataTables_filter pull-right"><label>Search:<input
                                    type="search" class="form-control input-sm" id="inputSearch"></label></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>User Photo</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                                </thead>
                                <tbody v-if="resultData.data !=''" id="dataTable">
                                <tr v-for="(value,index) in resultData.data" v-bind:key="index">
                                    <td>{{ ++index }}</td>
                                    <td><img :src="makeImge(value.user_photo)" class="imageSize"></td>
                                    <td>{{ value.user_name }}</td>
                                    <td>{{ value.email }}</td>
                                    <td>{{ value.role ? value.role.role_name : ''     }}</td>
                                    <td>
                                        <span v-if="value.status == 1" class="badge badge-success">Active</span>
                                        <span v-if="value.status == 0" class="badge badge-danger">Inactive</span>
                                    </td>
                                    <td>
                                        <a v-if="permissions.indexOf('user.edit') != -1" @click="editData(value.id)" class="btn btn-success btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                        <a v-if="permissions.indexOf('user.destroy') != -1 && value.deleted_at == null" @click="deleteData(value.id)" class="btn btn-danger btn-xs deleteBtn" title="Disable"><i class="fa fa-times"></i></a>
                                        <span v-if="value.deleted_at != null" class="badge badge-primary">Disabled</span>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td colspan="4" class="text-center">No Data Available.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center col-md-12">
                            <pagination :resultData="resultData" @clicked="index" :mid-size="9"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <addUser v-else-if="add_form" :user_role_list="user_role_list"></addUser>
        <editUser v-else-if="edit_form" :edit-id="edit_id" :user_role_list="user_role_list"></editUser>
    </div>
</template>

<script>

    import {EventBus} from '../../vue-assets';
    import Pagination from '../../components/Pagination.vue';
    import addUser from './addUser.vue';
    import editUser from './editUser.vue';

    export default {
        components: {
            addUser,
            editUser,
            Pagination
        },

        props: ['user_role_list','permissions'],

        data: function () {
            return {
                list: true,
                add_form: false,
                edit_form: false,
                edit_id: false,
                resultData: {},
                perPage: 10
            };
        },

        methods: {
            index(pageNo, perPage) {
                if (pageNo) {
                    pageNo = pageNo;
                } else {
                    pageNo = this.resultData.current_page;
                }
                if (perPage) {
                    perPage = perPage;
                } else {
                    perPage = this.perPage;
                }

                axios.get(base_url + "user/?page=" + pageNo + "&perPage=" + perPage).then((response) => {
                    // console.log(response.data);
                    this.resultData = response.data;

                });
            },

            makeImge(path) {
                if (path) {
                    return path;
                } else {
                    return base_url + "uploads/userPhoto/demo.png";
                }
            },

            editData(id) {

                var _this = this;
                _this.add_form = false;
                _this.list = false;
                _this.edit_form = true;
                _this.edit_id = id;
                $('#addButton').hide();
                $('#listButton').show();
            },


            deleteData(id) {
                var _this = this;
                swal({
                        title: "Are you sure?",
                        text: "To Disable The User!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Disable it!",
                        closeOnConfirm: false
                    },
                    function () {
                        swal("Disabled!", "This User Disabled.", "success");
                        axios.delete(base_url + 'user/' + id).then((response) => {
                            _this.index(1);
                            _this.showMassage(response.data);
                        }).catch((error) => {
                            swal('Error:', 'Something Error Found !, Please try again', 'error');
                        });
                    });
            },

            showMassage(data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                } else {
                    toastr.error(data.message, 'Error Alert', {timeOut: 5000});
                }
            },

            openUpdateModal(id) {
                EventBus.$emit('update-button-clicked', id);
            },

            changePerPage() {
                var vm = this;
                vm.index(1, vm.perPage);
            },
            datatables() {
                $(document).ready(function () {
                    $("#inputSearch").on("keyup", function () {
                        var value = $(this).val().toLowerCase();
                        $("#dataTable tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            },
        },

        created() {

            var _this = this;
            $('body').on('click', '#addButton', function () {
                _this.add_form = true;
                _this.list = false;
                _this.edit_form = false;
                $('#addButton').hide();
                $('#listButton').show();
            });

            $('body').on('click', '#listButton', function () {
                _this.add_form = false;
                _this.list = true;
                _this.edit_form = false;
                $('#addButton').show();
                $('#listButton').hide();

            });

            EventBus.$on('data-changed', (id) => {
                _this.add_form = false;
                _this.list = true;
                _this.edit_form = false;
                $('#addButton').show();
                $('#listButton').hide();
                _this.index(1);
            });

            _this.index(1);
            _this.datatables();
        },
    }
</script>

