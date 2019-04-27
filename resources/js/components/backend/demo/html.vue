<template>
<div>
    <div class="col-md-12">
        <form class="form" method="POST" :action='this.module.store_route' @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

            <input type="hidden" name="id" :value="this.module.id" v-if="this.module.id != 0">
            <div class="row">
                
                <div class='col-sm-6'>
                    <div :class='form.errors.has("name")?"form-group has-error":"form-group"'>
                        <label for='name'> {{this.module.lang.name}} </label>

                        <input type='text' name='name' class='form-control' v-model='form.name'>
                        <span class='help-block' 
                        v-if='form.errors.has("name")'
                        v-text='form.errors.get("name")'></span>
                    </div>
                </div>
                
                <div class='col-sm-6'>
                    <div :class='form.errors.has("date")?"form-group has-error":"form-group"'>
                        <label> {{this.module.lang.date}} </label>
                        <datepicker v-model='form.date' :input-class='"form-control"' :calendar-button-icon='"fa fa-calendar"' :format='"dd/MM/yyyy"' id='date' name='date'></datepicker>
                        <span class='help-block' 
                        v-if='form.errors.has("date")'
                        v-text='form.errors.get("date")'></span>
                    </div>
                </div>
                
                <div class='col-sm-6'>
                    <div :class='form.errors.has("warehouse_id")?"form-group has-error":"form-group"'>
                        <label for='warehouse_id'> {{this.module.lang.warehouse_id}} </label>
                        
                        <select class='form-control select2 select2-form' ref='warehouse_id' name='warehouse_id' v-model='form.warehouse_id'>
                            <option value=''>Select warehouse_id</option>
                            <option v-for='(value, key) in warehouse_id' :value='key'>{{value}}</option>
                        </select>

                        <span class='help-block' 
                        v-if='form.errors.has("warehouse_id")'
                        v-text='form.errors.get("warehouse_id")'></span>
                    </div>
                </div>
                
                <div class='col-sm-6'>
                    <div :class='form.errors.has("gender")?"form-group has-error":"form-group"'>
                        <label for='gender'>{{this.module.lang.gender}}</label>

                        <select class='form-control select2 select2-form' ref='gender' name='gender' v-model='form.gender'>
                            <option value=''>Select gender</option>
                            <option v-for='(value, key) in gender' :value='value'>{{value}}</option>
                        </select>
                        <span class='help-block' 
                        v-if='form.errors.has("gender")'
                        v-text='form.errors.get("gender")'></span>
                    </div>
                </div>
                
                <div class='col-sm-6'>
                    <div class='form-group'>
                        <label for='description'> {{this.module.lang.description}} </label>
                        
                        <textarea id='description' name='description' class='form-control autosize' rows='3' v-model='form.description'></textarea>
                    </div>
                </div>
                
            </div>
            <div class="row">
            
			<div class="col-sm-12">
				
                <h4>Demo Details</h4>
			
            </div>
			<grid :module="this.module" :elementdata="this.module.demo_details" :elementrow="this.module.demo_details_row" :rowcount="this.module.demo_detailsrow_count" ref="demo_details"></grid>
		<!-- [GridVueElement-1] -->
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <file_upload ref="file_upload" :module='this.module'></file_upload>
                </div>
            </div>
            
            <div class="card-actionbar">
                <div class="card-actionbar-row">
                    <button type="submit" class="btn btn-flat btn-primary ink-reaction pull-right" :disabled="form.errors.any()">{{this.module.common.save}}</button>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import moment from 'moment';

export default {
    
    props:['formObj','module'],

    data(){
        return {
            form:this.formObj,
             warehouse_id : [],
			gender : Object.values(this.module.gender),
			// [OptionsData]
        }
    },
    methods: {
        onSubmit() {            
            this.form.post(this.module.store_route).then(response => {
                this.$refs.file_upload.submitFiles(this.module.dir, response.data.id);
                
                 
            if(this.module.id == 0) {

                var grid = this.module.demo_details;
                
                for(var key in grid) {                        
                   this.$refs.demo_details.form[grid[key].name] = [""];
                }


                this.$refs.demo_details.rows = [];
                this.$refs.demo_details.rows = [0];
                this.$refs.demo_details.index = 0;

                
                this.$parent._data.form = new Form(this.module.fillable);
                this.form = this.$parent._data.form;
                this.$refs.demo_details.form  = this.module.fillable;

            }

            // [GRID_RESET]
        

                $(document).ready( () => { 
                    $(".select2").select2({width:'100%'});
                });

                if(this.module.id == 0) {
                    this.$refs.file_upload.files = [];
                    this.$refs.file_upload.name = [];
                } else {
                     this.$refs.file_upload.init();
                }
                this.$root.$emit('demosCreated', response);
                this.$parent.activity_init();

            }).catch(function(){});
        }
    },
    mounted() {
            
         
		this.form.warehouse_id = this.form.warehouse_id ? this.form.warehouse_id : '';
		
        $(document).ready( () => { 
            
            $('.select2').select2({width:'100%'});

            $(document).on('change', '.select2-form', event => {
                var input_db_name = $(event.target).attr('name');
                this.form[input_db_name] = event.target.value
            });

        });
        
        if(this.module.warehouse_id_search) {
            axios.get(this.module.warehouse_id_search).then(data => {
                this.warehouse_id = data.data;
            });
        }
        
		this.form.gender = this.form.gender ? this.form.gender : '';
		// [DropdownSearch]
    }
}
</script>