<?php

namespace App\Http\Controllers\Backend;

use App\General\Activity;
use App\General\ModuleConfig;
use App\General\HandlePermission;
use App\Http\Controllers\Controller;
use App\Models\Demo as Module;
use Auth;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

use App\Http\Requests\Demo\StoreDemoRequest;
use App\Http\Requests\Demo\UpdateDemoRequest;
use App\Http\Requests\Demo\DeleteDemoRequest;
use App\Http\Requests\Demo\ListDemoRequest;
use App\Http\Requests\Demo\OnlyDemoRequest;
use Lang;

class DemoController extends Controller {

    public $data = [];        
    
    public $form_view = 'backend.modules.demo';
    public $form_export = 'backend.modules.demo-table';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function default() {
        
        $this->data = ModuleConfig::demos();
         $this->data['warehouses_module'] = ModuleConfig::warehouses();
		$this->data['warehouses_module'] = ModuleConfig::warehouses();
		// [Module_Data]
    }

    public function index(ListDemoRequest $request) { 
        $this->default();
        $model = new Module;
        $this->data['permissions'] = HandlePermission::getPermissionsVue($this->data['dir']);

        $this->data['lists'] = Module::latest()->with("warehouses")->paginate(25);
        $only = new OnlyDemoRequest();
        if($only->authorize()){
            $this->data['lists'] = Module::latest()->with("warehouses")->where('created_by', user()->id)->paginate(25);
        }
        
        $this->data['list_data'] = $model->list_data();
        $this->data['fillable'] = formatDeleteFillable();
        return view($this->form_view, ['data'=>$this->data]);
    }

    public function Paginate($from_delete = false ,Request $request) {
        $this->default();
        $this->data['permissions'] = HandlePermission::getPermissionsVue($this->data['dir']);
        
        $model = new Module;
        $searchelements = $model->searchelements;


        if(isset($request->q) && !empty($request->q)) {

            $lists = Module::latest()->with("warehouses")->where(function($query) use ($searchelements, $request) {
                                    foreach ($searchelements as $key => $value) {

                                        $query = $query->orwhere($value,'like','%'.$request->q.'%');
                                    }
                                })->orwhereHas("warehouses",function($query) use ($request){
                                    $query->where("name","like","%$request->q%");
                                });
        } else {
            $lists = Module::latest()->with("warehouses");
        }

        $only = new OnlyDemoRequest();
        if($only->authorize()){
            $lists = $lists->where('created_by', user()->id);
        }

        $this->data['list_data'] = $model->list_data();

        if($request->pdf) {
            $this->data['lists'] = $lists->get();

            $data = $this->data;
            
            $pdf = PDF::loadView($this->form_export, compact('data'));        
            return $pdf->download('Demo.pdf');
        }

        if($request->csv) {
            $this->data['lists'] = $lists->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            $i = 0;
            
            foreach ($this->data['list_data'] as $field => $value) {
                $sheet->setCellValue(range('A', 'Z')[$i]."1", $field);
                $sheet->getStyle(range('A', 'Z')[$i])->getFont()->setSize(10); 
                $sheet->getStyle(range('A', 'Z')[$i]."1")->getFont()->setBold( true );
                $i++;
            }

            $rows = 2;
            $j = 0;
            foreach($this->data['lists'] as $value){

                foreach ($this->data['list_data'] as $list_data) {
                    $list = getRelation($value, $list_data);
                    $sheet->setCellValue(range('A', 'Z')[$j].$rows, $list);
                    $sheet->getColumnDimension(range('A', 'Z')[$j])
                        ->setAutoSize(true);
                    $sheet->getStyle(range('A', 'Z')[$j])->getFont()->setSize(10); 
                    $j++;
                }
                $j = 0;
                $rows++;
            }
            $writer = new Csv($spreadsheet);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment; filename="Demo.csv"');
            return $writer->save("php:output");
        }

        if($from_delete) {
            return $this->data;
        }

        $this->data['lists'] = $lists->paginate(25);
        return successResponse(Lang::get('label.notification.success_message'),$this->data);
    }

    public function create(StoreDemoRequest $request) {
        $this->default();
        return view($this->form_view, ['data'=>$this->data]);
    }

    public function store(StoreDemoRequest $request) {
        $this->default();
        $this->validate($request, [
                "name" => "required",
			
            ]
        );   
         $array = [];
		$rows = count($request->full_name);
		for ($i = 0; $i < $rows; $i++) {
			$array["full name"] = $request->full_name[$i];
			$array["start date"] = parseDBdate($request->start_date[$i]);
			$array["location"] = $request->location_id[$i];
			$array["is active"] = $request->is_active[$i];
			if(count(array_filter($array)) != 0) {
                foreach ($array as $key => $value) {
                    if($value == ""){
                        return errorResponse(ucfirst($key)." Field is required");
                    }
                }
            } else {
                if($rows == 1) {
                    return errorResponse("Add demo details. Atleast one row is required");
                }
            }
        }
		// [GridValidation]
        $input = $request->all();
         $input['date'] = parseDBdate($input['date']);
		//[DropdownValue]

        \DB::beginTransaction();   
        try {
            if(isset($request->id)) {
                $model = Module::find($request->id);
                $msg = activity($input, $this->data['lang'], $model->toArray());
                 $input_grid = [];
				for($i=0; $i < count(array_filter($request->full_name)); $i++) {
					$input_grid["demo_id"][] = $model->id;
					$input_grid["full_name"][] = $request->full_name[$i];
					$input_grid["start_date"][] = parseDBdate($request->start_date[$i]);
					$input_grid["location_id"][] = $request->location_id[$i];
					$input_grid["is_active"][] = $request->is_active[$i];
					
				}
				$msg_row = activityRow($input_grid, count(array_filter($request->full_name)), $model->demo_details->toArray());
                foreach ($msg_row as $key => $value) {
                    Activity::add($value, $this->data["dir"], $model->id);
                }
				// [GridActivity]
                 $model->demo_details()->where("demo_id", $request->id)->delete();
				// [GridDelete]
                $model->update($input);
            } else {
                $input["created_by"] = user()->id;
                $model = Module::Create($input);
                $msg = "<b>".Auth::user()->name."</b> created ".$this->data['dir'].".";
            }
             
            for($i=0; $i < count(array_filter($request->full_name)); $i++) {
					$model->demo_details()->create([
								"demo_id" => $model->id,
								'full_name' => $request->full_name[$i],
								'start_date' => parseDBdate($request->start_date[$i]),
								'location_id' => $request->location_id[$i],
								'is_active' => $request->is_active[$i],
								
					]);
				}
				// [GridSave]
            if(!empty($msg)) {
                Activity::add($msg, $this->data['dir'], $model->id);
            }
            
        } catch (\Exception $e) {
            \DB::rollback();
            return errorResponse();
        }
        \DB::commit();

        $message = isset($request->id) ? Lang::get('demos.edit_message') : Lang::get('demos.create_message');
        return successResponse($message,$model);
    }

    public function edit($id, UpdateDemoRequest $request) {
        $this->default();
        $this->data['id'] = $id;
        $model = Module::findorfail($id);
        $formelement = $model->getAttributes();
        $formelement['_token'] = csrf_token();
         $formelement['date'] = parseDate($model->date);
		// [DropdownSelectedValue]
        
         if(count($model->demo_details) > 0 ) {
            $this->data["demo_details_row"] = [];
			$this->data["demo_detailsrow_count"] = count($model->demo_details) - 1;
			foreach ($model->demo_details as $key => $value) {
				$this->data["demo_details_row"][] = $key;
				$formelement['full_name'][] = $value->full_name;
				$formelement['start_date'][] = parseDate($value->start_date);
				$formelement['location_id'][] = $value->location_id;
				$formelement['is_active'][] = $value->is_active;
				
			}
		} else {
			$formelement['full_name'][] = "";
			$formelement['start_date'][] = "";
			$formelement['location_id'][] = "";
			$formelement['is_active'][] = "";
			
		}
		// [GridEdit]
        $this->data['fillable'] = $formelement;

        $this->data['permissions'] = HandlePermission::getPermissionsVue($this->data['dir']);

        $only = new OnlyDemoRequest();
        if(!$only->authorize() || $model->created_by == user()->id) {
            return view($this->form_view, ['data'=>$this->data]);
        } else {
            return "Unauthorized!";
        }
    }

    public function destroy(DeleteDemoRequest $request){
        $this->default();
        $this->data['permissions'] = HandlePermission::getPermissionsVue($this->data['dir']);
        
        \DB::beginTransaction();
        try {
            $model = Module::findorfail($request->id);
            $msg = "<b>".Auth::user()->name."</b> deleted data of id : ". $model->id;
            Activity::add($msg, $this->data['dir'], $model->id);
             $model->demo_details()->where("demo_id", $request->id)->delete();
				// [GridDelete]
            $model->delete();
        } catch (\Exception $e) {
            \DB::rollback();                        
            return errorResponse('Error while deleting demo. Try again latter');
        }
        \DB::commit();

        $model = new Module;
        $this->data['lists'] = Module::latest()->with("warehouses")->paginate(25);
        $only = new OnlyDemoRequest();
        if($only->authorize()){
            $this->data['lists'] = Module::latest()->with("warehouses")->where('created_by', user()->id)->paginate(25);
        }
        $this->data['list_data'] = $model->list_data();
        return successResponse(Lang::get('demos.delete_message'),$this->data);
    }
}
