<template>
    <div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Department List</h3>
                <button v-if="permissions.indexOf('department.store') != -1" type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#addModal">Add Department</button>
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
                            <div id="example1_filter" class="dataTables_filter pull-right"><label>Search:<input type="search" class="form-control input-sm" id="inputSearch"></label></div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-bar">
                                    <tr>
                                        <th>SL</th>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="resultData.data !=''" id="dataTable">
                                <tr v-for="(value,index) in resultData.data" v-bind:key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ value.department_name }}</td>
                                    <td>
                                        <span v-if="value.status == 1" class="badge badge-success">Active</span>
                                        <span v-if="value.status == 2" class="badge badge-danger">Inactive</span>
                                    </td>
                                    <td>
                                        <a v-if="permissions.indexOf('department.edit') != -1" @click="openUpdateModal(value.id)"  class="btn btn-success btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                                        <a v-if="permissions.indexOf('department.destroy') != -1" @click="deleteData(value.id)" class="btn btn-danger btn-xs deleteBtn" title="Delete"><i class="fa fa-trash-o"></i></a>
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
        <AddDepartment></AddDepartment>
    </div>
</template>


<script>

    import {EventBus} from '../../vue-assets';
    import Pagination from '../../components/Pagination.vue';
    import AddDepartment from './AddDepartment.vue';

    export default {
        components: {
            AddDepartment,
            Pagination
        },

        props:['permissions'],

        data: function(){
            return {
                resultData: {},
                perPage: 10
            };
        },

        methods: {
            index(pageNo,perPage){
                if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                axios.get(base_url+"department/?page="+pageNo+"&perPage="+perPage).then((response) => {
                    this.resultData = response.data;

                });
            },

            deleteData(id){
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
                    function(){
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        axios.delete(base_url+'department/'+id).then((response) => {
                            _this.index(1);
                            _this.showMassage(response.data);
                        }).catch((error)=>{
                            swal('Error:','Something Error Found !, Please try again','error');
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

            openUpdateModal(id){
                EventBus.$emit('update-button-clicked', id);
            },

            changePerPage(){
                var vm = this;
                vm.index(1,vm.perPage);
            },

            datatables(){
                $(document).ready(function(){
                    $("#inputSearch").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#dataTable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            },


        },

        created() {
            var _this = this;
            _this.index(1);
            EventBus.$on('new-data-created', function () {
                _this.index(1);
            });
            _this.datatables();
        }

    }
</script>
