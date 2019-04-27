<?php

namespace autoengine\crudpack\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{	
	public function getParent_form(Request $request) {

		return \DB::table('form_modules')->latest()->wherenull('deleted_at')->wherenull('parent_form')->pluck('main_module','main_module');

	}

	public function getTable(Request $request) {
		return collect(\DB::select('show tables'))->map(function ($val) {
            foreach ($val as $key => $tbl) {
                return $tbl;
            }
        });
		// return \DB::table('form_modules')->latest()->where('table_name','like',"%$request->q%")->wherenull('deleted_at')->wherenull('parent_form')->pluck('table_name');
	}

	public function getTable_data(Request $request) {

		return \DB::getSchemaBuilder()->getColumnListing($request->q);
	}

	public function getParent_module(Request $request) {

		return \DB::table('permission_modules')->latest()->wherenull('deleted_at')->pluck('name','name');

	}

	public function getParent_api_form(Request $request) {

		return \DB::table('api_modules')->latest()->select('main_module as label','main_module as value')->where('main_module','like',"%$request->q%")->wherenull('deleted_at')->get();

	}
	public function getParent_api_table(Request $request) {

		return \DB::table('api_modules')->latest()->select('table_name as label','table_name as value')->where('table_name','like',"%$request->q%")->wherenull('deleted_at')->get();

	}
}