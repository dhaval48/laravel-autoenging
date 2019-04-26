
        <?php

        $formelements = ["name" => "",
		
		// [WarehouseArray]
		];
		
        $formelements["_token"] = csrf_token();
		$data =  [
                'lang' => Lang::get('warehouses'),
                'common' => Lang::get('label.common'),
                
                'dir'  => 'warehouse',
                'id' => 0,
                'is_visible' => false,
                
                'list_route'  =>  route('warehouse.index'),
                'store_route'  => route('warehouse.store'),
                'paginate_route'  => route('warehouse.paginate'),
                'edit_route'  => route('warehouse.edit',''),
                'create_route'  => route('warehouse.create'),
                'destory_route' => route('warehouse.destroy'),
                'get_activity' => route('get.activity'),
                'get_file' => route('get.file'),
                
				// [WarehouseModule]
            ];
		$data["fillable"] = $formelements;
		
		// [WarehouseGrid]
		return $data;

        