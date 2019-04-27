
        <?php

        $formelements = ["name" => "",
		"date" => "",
		"warehouse_id" => "",
		"gender" => "",
		"description" => "",
		
		"demo_id" => [],
			"full_name" => [],
			"start_date" => [],
			"location_id" => [],
			"is_active" => [],
			
			// [DemoArray]
		];
		
        $formelements["_token"] = csrf_token();
		$data =  [
                'lang' => Lang::get('demos'),
                'common' => Lang::get('label.common'),
                
                'dir'  => 'demo',
                'id' => 0,
                'is_visible' => false,
                
                'list_route'  =>  route('demo.index'),
                'store_route'  => route('demo.store'),
                'paginate_route'  => route('demo.paginate'),
                'edit_route'  => route('demo.edit',''),
                'create_route'  => route('demo.create'),
                'destory_route' => route('demo.destroy'),
                'get_activity' => route('get.activity'),
                'get_file' => route('get.file'),
                'warehouse_id_search' => route('get.warehouse_id'),
				
				'location_id_search' => route('get.location_id'),
				
				// [DemoModule]
            ];
		$data["fillable"] = $formelements;
		$data["gender"] = ['Male', 'Female'];
			
		$data["demo_details"] = [
				'Full name' => [
					'type' => 'input',
					'name' => 'full_name',
				],
				'Start date' => [
					'type' => 'date',
					'name' => 'start_date',
				],
				'Location' => [
					'type' => 'dropdown',
					'name' => 'location_id',
					'modalid' => '#warehousesModal',
				],
				'Is active' => [
					'type' => 'dropdown',
					'name' => 'is_active',
					'empty' => true,
				],
				
			];
			$data["demo_detailsrow_count"] = 0;
			$data["demo_details_row"][] = 0;
		$data["is_active"] = ['Active', 'Inactive'];
			
		// [DemoGrid]
		return $data;

        