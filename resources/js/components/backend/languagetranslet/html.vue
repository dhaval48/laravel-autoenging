<template>
<div>
    <div class="col-md-12">
        <form class="form" method="POST" :action='this.module.store_route' @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">

            <input type="hidden" name="id" :value="this.module.id" v-if="this.module.id != 0">
            
			<div class="row">
                <div class='col-sm-12'>
                    <div :class='form.errors.has("locale")?"form-group has-error":"form-group"'>
                        <label for='locale'>{{this.module.lang.locale}}</label>

                        <select class="form-control select2 select2-form" ref='locale' name="locale" v-model="form.locale">
                            <option value="">Select Language</option>
                            <option v-for="(value, key) in locale" :value='key'>{{key}}-{{value}}</option>
                        </select>
                    </div>
                </div>                
			</div>

            <div class="row">
            
    			<div class="col-sm-12">
    				
                    <h4>Language Translet Details</h4>
    			
                </div>

                                    
                <div class="col-sm-12">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="50%">Translation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(n, k) in lang_value_pagination">

                                <td> {{ n }} </td>

                                <td>
                                    <input type='text' name='translation' class='form-control' v-model="form.translation[n]">
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>

                    <ul class="pagination">
                        <li class="page-item" v-if='page > 1'>
                            <a href="javascript:void(0);" aria-label="Previous"
                            v-on:click="getPageData(this.module.page - 1)" class="page-link">
                                <span aria-hidden="true">Previous</span>
                            </a>
                        </li>

                        <li class="page-item" v-for='p in total_pages'
                          v-bind:class="[ p == page ? 'active' : '']">
                            <a href="javascript:void(0);" class="page-link" v-on:click="getPageData(p)">{{ p }}</a>
                        </li>

                        <li class="page-item" v-if='page < total_pages'>
                            <a href="javascript:void(0);" class="page-link"
                                v-on:click="getPageData(page + 1)">
                                <span aria-hidden="true">Next</span>
                            </a>
                        </li>
                    </ul>
                    <!-- <span v-html="this.module.pagerContainer"></span> -->
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
            locale : this.module.locale,
            lang_value_pagination : "",
            page : "",
            total_pages : "",
			// [OptionsData]
        }
    },

    methods: {

        getPageData:function(page){

            axios.get(this.module.get_lang_array_pagination+'?page='+page+'&id='+this.module.id).then(response => {
                this.page = response.data.page;
                this.lang_value_pagination = response.data.lang_value_pagination;
                this.total_pages = response.data.total_pages;
            });
        },

        // [DropdownFunction]
        onSubmit() {            
            this.form.post(this.module.store_route).then(response => {

                // [GRID_RESET]
                $(document).ready( () => {
                    $(".select2").select2({width:'100%'});
                });

                this.$root.$emit('language_transletsCreated', response);
                this.$parent.activity_init();

            }).catch(function(){});
        }
    },
    mounted() {
        this.form.value = this.module.lang_value;
        this.getPageData(1);

        $(document).ready( () => { 
            
            $(".select2").select2({width:'100%'});

            $(document).on('change', '.select2-form', event => {
                var input_db_name = $(event.target).attr('name');
                this.form[input_db_name] = event.target.value
            });
        });
        // [DropdownSearch]
    }
}
</script>