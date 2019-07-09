<template>
    <div>
        <!--begin:: Add Modal-->
        <div class="modal fade" id="addModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Department</h4>
                    </div>
                    <form v-on:submit.prevent="store" method="post">
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="department_names">Department Name</label>
                                <input type="text" v-model="form.department_name"  class="form-control" id="department_names" placeholder="Department Name" autocomplete="off">
                                <div class="text-danger" v-if="(errors.hasOwnProperty('department_name'))">{{ (errors.hasOwnProperty('department_name')) ? errors.department_name[0] :'' }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-left">Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->

        <!--begin:: Add Modal-->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Test Modal</h4>
                    </div>
                    <form v-on:submit.prevent="update(form.id)" method="post">
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label for="department_name">Department Name</label>
                                <input type="text" v-model="form.department_name"  class="form-control" id="department_name" placeholder="Department Name" autocomplete="off">
                                <div class="text-danger" v-if="(errors.hasOwnProperty('department_name'))">{{ (errors.hasOwnProperty('department_name')) ? errors.department_name[0] :'' }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary pull-left">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->
    </div>
</template>

<script>
    import {EventBus} from '../../vue-assets';

    export default {

        data:function(){
            return{
                form:{
                    department_name: '',
                    status:'1'
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                axios.post(base_url+'department', this.form).then( (response) => {
                    $('#addModal').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                    .catch(error => {
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors;
                        }else{
                            this.showMassage(error);
                        }
                    });
            },

            update:function (id) {
                axios.put(base_url+'department/'+id, this.form).then( (response) => {
                    $('#editModal').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                    .catch(error => {
                        if(error.response.status == 422){
                            this.errors = error.response.data.errors;
                        }else{
                            this.showMassage(error);
                        }
                    });
            },

            showMassage(data){
                if(data.status == 'success'){
                    toastr.success(data.message, 'Success');
                }else if(data.status == 'error'){
                    toastr.error(data.message, 'Error');
                }else{
                    toastr.error(data.message, 'Error');
                }
            },
        },

        mounted(){
            var _this = this;
            $('#addModal,#editModal').on('hidden.bs.modal', function(){
                _this.errors = {};
                _this.form = {'department_name':'','status':'1'};
            });

            EventBus.$on('update-button-clicked', (id) => {
                _this.errors = {};
                axios.get(base_url+'department/'+id+'/edit').then((response) => {
                    _this.form = response.data;
                    $('#editModal').modal("show");
                });
            });

        },

        created(){

        }

    }
</script>