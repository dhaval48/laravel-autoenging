<template>
<div>
    <div class="col-md-12">
        <form class="form" method="POST" :action='this.module.store_route' @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

            <input type="hidden" name="id" :value="this.module.id" v-if="this.module.id != 0">
            
            <div class="row">
                <div class="panel panel-primary">
                    <div class="panel-heading">General</div>

                    <div class="panel-body">
                        <div class="col-sm-2">{{this.module.lang.parent_form}}</div>
                        <div class='col-sm-10'>
                            <div :class='form.errors.has("parent_form")?"form-group has-error":"form-group"'>
                                <select class="form-control select2 select2-form" ref='parent_form' name="parent_form" v-model="form.parent_form">
                                    <option value="">Select Parent Form</option>
                                    <option v-for="(value, key) in parent_form" :value='key'>{{value}}</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-2">{{this.module.lang.parent_module}}</div>
                        <div class='col-sm-10'>
                            <div :class='form.errors.has("parent_module")?"form-group has-error":"form-group"'>
                                <select class="form-control select2 select2-form" ref='parent_module' name="parent_module" v-model="form.parent_module">
                                    <option value="">Select Permission Module</option>
                                    <option v-for="(value, key) in parent_module" :value='key'>{{value}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">{{this.module.lang.main_module}}</div>
                        <div class='col-sm-10'>
                            <div :class='form.errors.has("main_module")?"form-group has-error":"form-group"'>

                                <input type='text' name='main_module' class='form-control' v-model='form.main_module'>
                                <span class='help-block' 
                                v-if='form.errors.has("main_module")'
                                v-text='form.errors.get("main_module")'></span>
                            </div>
                        </div>

                        <!-- <div class="col-sm-2">{{this.module.lang.module_label}}</div>
                        <div class='col-sm-10'>
                            <div :class='form.errors.has("module_label")?"form-group has-error":"form-group"'>

                                <input type='text' name='module_label' class='form-control' v-model='form.module_label'>
                                <span class='help-block' 
                                v-if='form.errors.has("module_label")'
                                v-text='form.errors.get("module_label")'></span>
                            </div>
                        </div> -->


                    </div>
                </div>
            </div>

            <div class="row">

                <div class="panel panel-primary">
                    <div class="panel-heading">Database table settings</div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-sm-2">{{this.module.lang.table_name}}</div>
                            <div class='col-sm-10'>
                                <div :class='form.errors.has("table_name")?"form-group has-error":"form-group"'>

                                    <input type='text' name='table_name' class='form-control' v-model='form.table_name'>
                                    <span class='help-block' 
                                    v-if='form.errors.has("table_name")'
                                    v-text='form.errors.get("table_name")'></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <fieldset>
                                <div class="col-sm-12">
                                    <legend>
                                        Table Fields
                                    </legend>                                       
                                </div>

                                <auto_grid :module="this.module" :elementdata="this.module.module_tables" :elementrow="this.module.module_tables_row" :rowcount="this.module.module_tablesrow_count" ref="module_tables"></auto_grid>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="panel panel-primary">
                    <div class="panel-heading">Input field settings</div>
                    <div class="panel-body">

                        <div class="row">

                            <fieldset>
                                <div class="col-sm-12">

                                    <legend>
                                        Input Fields
                                    </legend>
                                </div>
                                
                                <div class="col-md-12">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Visibale</th>
                                                <th>Input Name</th>
                                                <th>Input Type</th>
                                                <th>Table</th>
                                                <th>Value</th>
                                                <th>Label</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(n, k) in rows.length">
                                                <td>
                                                    <p-check class='p-icon p-rotate p-bigger' color='primary'
                                                        v-model='form.visible[k]'>
                                                        <i slot='extra' class='icon mdi mdi-check'></i>
                                                    </p-check>
                                                </td>

                                                <td>
                                                    <input type='text' name='input_name' class='form-control' v-model="form.input_name[k]">
                                                </td>

                                                <td width="150px">
                                                    <select class="form-control select2 select2-auto-grid" ref='input_type' name="input_type" :position="k" v-model="form.input_type[k]">
                                                        <option value="">Select Input Type</option>
                                                        <option v-for="(value, key) in input_type_array" :value='value'>{{value}}</option>
                                                    </select>
                                                </td>

                                                <td width="150px">
                                                    <select class="form-control select2 select2-auto-grid db-table" ref='table' name="table" :position="k" disabled="disabled" v-model="form.table[k]">
                                                        <option value="">Select Table</option>
                                                        <option v-for="(value, key) in table" :value='value'>{{value}}</option>
                                                    </select>
                                                </td>

                                                <td width="150px">
                                                    <select class="form-control select2 select2-auto db-value" ref='value' name="value" :position="k" disabled="disabled" v-model="form.value[k]">
                                                        <option value="">Select Value</option>
                                                        <option v-for="v in value" :value='v'>{{v}}</option>
                                                    </select>
                                                </td>

                                                <td width="150px">
                                                    <select class="form-control select2 select2-auto db-key" ref='key' name="key" :position="k" disabled="disabled" v-model="form.key[k]">
                                                        <option value="">Select Label</option>
                                                        <option v-for="v in key" :value='v'>{{v}}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                
                            </fieldset>
                        </div>
                    </div>
                </div>
        <!-- [GridVueElement-1] -->
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
            mod:this.module.module_inputs,
            rows:this.module.module_inputs_row,
            index:this.module.module_inputsrow_count,
            form:this.formObj,
            parent_form : [],
            parent_module : [],
            input_type_array : this.module.input_type,
            table:[],
            value:[],
            key:[],
            // [OptionsData]
        }
    },

    watch:{
       
    },

    methods: {
        
        autoFill(k){
            this.form.db_name[k] = this.form.name[k];
            $.each(this.rows, (key,value) => {
                if(key === k) {
                    this.form.input_name[k] = this.form.name[k];
                }
            });
            this.rows.push(++this.index);
            this.rows.splice(k, 1);
            this.index--;
        },

        enableDropdown(k){
            if(this.form.table[k] != null && this.form.table[k]) {
                this.value = [];
                this.key = [];
                axios.get(this.module.table_data_search+'?q='+this.form.table[k]).then(data => {
                    this.value = data.data;
                    this.key = data.data;
                    // this.table.push({label:'Create new Form',value:'link'});
                });
            }
        },

        onSearch(search, value) {
            if(value == 'table') {
                this.table =[];
                if(this.module.table_search) {
                    axios.get(this.module.table_search+'?q='+search).then(data => {
                        this.table = data.data;
                        // this.table.push({label:'Create new Form',value:'link'});
                    });
                }
            }
        },
        
        addRow: function () {
            this.rows.push(++this.index);

            $.each(this.module.module_inputs, (i, list) => {
                $.each(this.rows, (k,value) => {
                    if(k === this.index) {
                        this.form[list.name][this.index] = "";
                        this.form.visible[this.index] = true;
                    }
                })
            });
        },

        deleteRow: function (k) {
            if(this.rows.length != 1){
                this.rows.splice(k, 1);
                $.each(this.module.module_inputs, (index, list) => {
                    this.form[list.name].splice(k, 1);
                });
                if(this.module.id != 0) {
                    if(this.form.module_input_id[k]) {
                        this.form.module_input_id.splice(k,1);
                    }
                }
                this.form.visible.splice(k,1);
                this.form.db_name.splice(k,1);
                this.index--;
            }
        },

        onSearchparent_form(search, loading) {
            loading(true)
            this.parent_form =[];
            if(this.module.parent_form_search) {
                axios.get(this.module.parent_form_search+'?q='+search).then(data => {
                    this.parent_form = Object.values(data.data);
                    // this.parent_form.push({label:'Create new Parent Form',value:'link'});
                    loading(false);
                });
            }
        },
        // [DropdownFunction]
        onSubmit() {            
            this.form.post(this.module.store_route).then(response => {
                 
                if(this.module.id == 0) {

                    var grid = this.module.module_tables;
                    
                    for(var key in grid) {                        
                       this.$refs.module_tables.form[grid[key].name] = [""];
                    }


                    this.$refs.module_tables.rows = [];
                    this.$refs.module_tables.rows = [0];
                    this.$refs.module_tables.index = 0;

                    
                    this.$parent._data.form = new Form(this.module.fillable);
                    this.form = this.$parent._data.form;
                    this.$refs.module_tables.form  = this.module.fillable;

                }

                
                if(this.module.id == 0) {

                    $.each(this.rows, (index, list) => {
                        this.form.visible.splice(index, 1);
                        this.form.input_name.splice(index, 1);
                        this.form.db_name.splice(index, 1);
                        this.form.input_type.splice(index, 1);
                        this.form.table.splice(index, 1);
                        this.form.value.splice(index, 1);
                        this.form.key.splice(index, 1);
                    });

                    this.rows = [];
                    this.rows = [0];
                    this.index = 0;

                    $.each(this.module.module_inputs, (i, list) => {
                        this.form[list.name][this.index] = "";
                    });
                }

                // [GRID_RESET]

                $(document).ready( () => { 
                    $(".select2").select2({width:'100%'});
                });

                this.$root.$emit('grid_modulesCreated', response);
                this.$parent.activity_init();

            }).catch(function(){});
        }
    },
    mounted() {

        if(this.module.id == 0){
            $.each(this.module.module_inputs, (i, list) => {
                this.form[list.name][this.index] = "";
            });
        }

        $(document).ready( () => { 
            
            $(".select2").select2({width:'100%'});

            $(document).on('change', '.select2-form', event => {
                var input_db_name = $(event.target).attr('name');
                this.form[input_db_name] = event.target.value
            });

            $(document).on('change', '.select2-auto-grid', event => {
                var input_db_name = $(event.target).attr('name');
                var position = $(event.target).attr('position');

                this.form[input_db_name][position] = event.target.value;

                if(this.form.input_type[position] == "dropdown") {
                    $('.db-table[position="'+position+'"]').prop("disabled", false);
                    $('.db-value[position="'+position+'"]').prop("disabled", false);
                    $('.db-key[position="'+position+'"]').prop("disabled", false);

                    if(this.form.table[position] != null && this.form.table[position]) {
                        this.value = [];
                        this.key = [];
                        axios.get(this.module.table_data_search+'?q='+this.form.table[position]).then(data => {
                            this.value = data.data;
                            this.key = data.data;
                        });
                    }
                } else {
                    $('.db-table[position="'+position+'"]').prop("disabled", true);
                    $('.db-value[position="'+position+'"]').prop("disabled", true);
                    $('.db-key[position="'+position+'"]').prop("disabled", true);
                }
            });

            if(this.module.id != 0){
                $('.select2-auto-grid').trigger('change');
            }

            $(document).on('change', '.select2-auto', event => {
                var input_db_name = $(event.target).attr('name');
                var position = $(event.target).attr('position');

                this.form[input_db_name][position] = event.target.value;
            });
        });

        if(this.module.parent_module_search) {
            axios.get(this.module.parent_module_search).then(data => {
                this.parent_module = data.data;
            });
        }

        if(this.module.parent_form_search) {
            axios.get(this.module.parent_form_search).then(data => {
                this.parent_form = data.data;
            });
        }

        if(this.module.table_search) {
            axios.get(this.module.table_search).then(data => {
                this.table = data.data;
            });
        }
        // [DropdownSearch]
    }
}
</script>