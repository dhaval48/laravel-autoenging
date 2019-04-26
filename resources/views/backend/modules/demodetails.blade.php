@extends('backend.layouts.app')

@section('after-styles')
	
@endsection
@section('content')
<div id="content">
    <section>
        @if(!isset($data['lists'])) 
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <a href="{{ $data['list_route'] }}"> 
                                <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                            &nbsp;&nbsp;
                            <h3 class="box-title">{{ $data['id'] != 0 ? $data['lang']['edit_title'] : $data['lang']['create_title'] }}</h3>
                            </a>
                        </div>

                        <div class="box-body">
    				        <demo_details-view :module="{{json_encode($data)}}"></demo_details-view>
    				    </div>
                    </div>
                </div>
            </div>            
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{$data['lang']['list']}}</h3>
                        </div>
                        
                        <demo_details-view :module="{{json_encode($data)}}"></demo_details-view>
                        
                    </div>
                </div>
            </div>           
        @endif  
    </section>
</div><!--end #content-->


{{-- [Modal_path] --}}
@endsection
@section('after-scripts')
	
@endsection
