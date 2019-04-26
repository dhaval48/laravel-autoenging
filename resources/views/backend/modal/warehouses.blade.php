<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade in" id="warehousesModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="formModalLabel">
                    {{ Lang::get('warehouses.create_title') }}
                </h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-12">
            
						<warehouses-view :module="{{json_encode($data['warehouses_module'])}}"></warehouses-view>

					</div>
		        </div>
	        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->