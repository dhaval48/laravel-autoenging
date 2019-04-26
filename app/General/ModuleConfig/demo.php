
        <?php

        $formelements = ["name" => "",
		"date" => "",
		"warehouse_id" => "",
		"gender" => "",
		"description" => "",
		
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
				
				// [DemoModule]
            ];
		$data["fillable"] = $formelements;
		$data["gender"] = [];
			
		// [DemoGrid]
		return $data;

        