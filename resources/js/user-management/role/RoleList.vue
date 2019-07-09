<template>
    <div>
        <div class="box box-primary" v-if="list">
            <div class="box-header with-border">
                <h3 class="box-title"> Role List</h3>
                <a v-if="permissions.indexOf('role.store') != -1" class="btn btn-success pull-right" id="addButton">Add Role</a>
            </div>
            <div class="box-body">
                <div id="main">
                    <div class="row">
                        <div class="col-sm-4">
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
                        <div class="col-sm-2">
                            <label></label>
                            <div class="form-inline">Role :

                                <select class="form-control" v-model="role_id">
                                    <option value="">Select Role</option>
                                    <option v-for="(value,index) in user_role_list" :value="value.id" v-bind:key="index"> {{value.role_name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label></label>
                            <div class="form-inline">Status :
                                <select class="form-control" v-model="status">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label></label>
                            <div><button @click.prevent="filterData()"   type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button></div>
                        </div>
                        <div class="col-sm-2">
                            <div id="example1_filter" class="dataTables_filter pull-right"><label>Search:<input type="search" class="form-control input-sm" id="inputSearch"></label></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12 table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-bar">
                                    <tr>
                                        <th>SL</th>
                                        <th v-for="(coloumn,index) in theadData" v-bind:key="index">{{ coloumn }}</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="resultData.data !=''" id="dataTable">
                                <tr v-for="(value,index) in resultData.data" v-bind:key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ value.role_name }}</td>
                                    <td>
                                        <span v-if="value.status == 1" class="badge badge-success">Active</span>
                                        <span v-if="value.status == 2" class="badge badge-danger">Inactive</span>
                                    </td>
                                    <td>
                                        <a v-if="permissions.indexOf('role.edit') != -1" @click="editData(value.id)" class="btn btn-success btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                        <a v-if="permissions.indexOf('role.destroy') != -1" @click="deleteData(value.id)" class="btn btn-danger btn-xs deleteBtn" title="Delete"><i class="fa fa-trash-o"></i></a>
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
                            <pagination :resultData="resultData" @clicked="index"></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <AddRole v-else-if="add_form"></AddRole>
        <EditRole v-else-if="edit_form" :edit-id="edit_id"></EditRole>
    </div>
</template>

<script>
    import {EventBus} from '../../vue-assets';
    import Pagination from '../../components/Pagination.vue';
    import AddRole from './AddRole.vue';
    import EditRole from './EditRole.vue';

    export default {
        components: {
            AddRole,
            EditRole,
            Pagination
        },

        props: ['permissions','user_role_list'],

        data: function () {
            return {
                list: true,
                add_form: false,
                edit_form: false,
                edit_id: false,
                resultData: {},
                theadData: {},
                perPage: 10,
                role_id: '',
                status: '',
            };
        },

        methods: {

            index(pageNo, perPage,role_id,status) {


                if (pageNo) {
                    var role_id = this.role_id;
                    var status = this.status;
                    pageNo = pageNo;
                } else {
                    pageNo = this.resultData.current_page;
                }

                if (perPage) {
                    perPage = perPage;
                } else {
                    perPage = this.perPage;
                }

                if (role_id) {
                    role_id = role_id;
                }else {
                    role_id = '';
                }

                if (status) {
                    status = status;
                }else {
                    status = '';
                }

                axios.get(base_url + "role/?page=" + pageNo + "&perPage=" + perPage + "&role_id=" + role_id + "&status=" + status).then((response) => {
                    console.log(response);
                    this.resultData = response.data.data;
                    this.theadData = response.data.theadColoumn;

                });
            },

            filterData(){
                var vm = this;
                vm.index(1, vm.perPage,vm.role_id,vm.status);
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
                        text: "You will not be able to recover this information!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function () {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        axios.delete(base_url + 'role/' + id).then((response) => {
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

            changePerPage() {
                var vm = this;
                vm.index(1, vm.perPage);
            },
            /*changePerPage() {
                 var vm = this;
                 vm.index(1, vm.perPage,vm.role_id,vm.status);
             },*/

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

