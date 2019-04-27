<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Testmodule as Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\CommonController;
use App\Models\FileUploadDetail;

class TestmoduleController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('locale:en');
    }

    public function index(Request $request) { 

        $testmodule = Module::latest()->paginate(25);
        return successResponse('',$testmodule);
    }

    public function store(Request $request) {
        $this->validate($request, [
                "name" => "required",
			
            ]
        );   
         // [GridValidation]
        $input = $request->all();
        
        \DB::beginTransaction();   
        try {
            if(isset($request->id)) {
                $model = Module::find($request->id);
                 // [GridDelete]
                $model->update($input);
            } else {
                $model = Module::Create($input);
            }
             // [GridSave]
            $request->request->add(['type' => 'testmodule', 'type_id' => $model->id]);
            CommonController::fileUpload($request);
        } catch (\Exception $e) {
            \DB::rollback();
            return errorResponse();
        }
        \DB::commit();

        $message = isset($request->id) ? "Test Module Updated!" : "Test Module Created!";
        return successResponse($message,$model);
    }

    public function edit($id, Request $request) {
        $model = Module::findorfail($id);
        $formelement = $model->getAttributes();        
        
         // [GridEdit]
        $request->request->add(['type' => 'testmodule', 'type_id' => $model->id]);
        $file = CommonController::getFile($request);
        if($file) {
            $formelement['file_id'] = $file[0];
            foreach ($file[1] as $key => $value) {
                $attachment = FileUploadDetail::find($value->id);        
                $path = getFilePath($attachment->path_name);
                $formelement['file_detail'][$key] = $value;
                $formelement['file_detail'][$key]['path'] = getFileBase64($path);
            }
        }
        return successResponse('',$formelement);
    }

    public function destroy(Request $request){
        
        \DB::beginTransaction();
        try {
            $model = Module::findorfail($request->id);
             // [GridDelete]
            $model->delete();
        } catch (\Exception $e) {
            \DB::rollback();                        
            return errorResponse('Error while deleting Test Module. Try again latter');
        }
        \DB::commit();
        return successResponse("Test Module Deleted!");
    }
}
