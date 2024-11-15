@extends('layouts.app')

@section('content-page')

<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">User</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="/">
              <i class="icon-home"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="/">Dashboard</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Create</a>
          </li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">User Add</div>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('route' => $route['store'], 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true)) !!}

                        <div class="row">
                            @foreach($fields as $field => $fv)
                            <div class="col-lg-6">

                                <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                    <label class=" control-label"
                                            for="NEW_subject">{{$fv['label']}} : <sup class="required">*</sup>
                                    </label>
                                    <div class="">
                                        <div class="input-group">
                                            @if(!strcmp($fv['type'], "text"))
                                                {!! Form::text($fv['name'], $fv['default'], $fv['extras']) !!}
                                            @elseif(!strcmp($fv['type'], "textarea"))
                                                {!! Form::textarea($fv['name'], $fv['default'], $fv['extras']) !!}
                                            @elseif(!strcmp($fv['type'], "select"))
                                                {!! Form::select($fv['name'], $fv['choices'], $fv['default'], $fv['extras']) !!}
                                            @elseif(!strcmp($fv['type'], "checkbox"))
                                                {!! Form::checkbox($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
                                            @elseif(!strcmp($fv['type'], "radio"))
                                                {!! Form::radio($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
                                            @elseif(!strcmp($fv['type'], "file"))
                                                {!! Form::file($fv['name'],$fv['extras']) !!}
                                            @else

                                            @endif
                                            @if ($errors->has($fv['name']))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first($fv['name']) }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Select Sidebar <sup class="required">*</sup>
                                    </label>
                                    <div class="">
                                        <div class="input-group">
                                            <select class="form-control border-input" name="role" >
                                                <option value="1">Admin</option>
                                                <option value="2">Editor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Profile <sup class="required">*</sup>
                                    </label>
                                    <div class="">
                                        <div class="input-group">
                                            <input type="file" required="" name="feature_image">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Select Sidebar <sup class="required">*</sup>
                                    </label>
                                    <div class="" >
                                        <div class="input-group">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>Permission</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $sidebarItem = Config::get('app.sidebar'); @endphp
                                                    @foreach($sidebarItem as $item)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="permission[]" value="{{ $item['route'] }}">
                                                            </td>
                                                            <td>
                                                                {{ $item['label'] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="">
                                        <div class="input-group">
                                            <label class="col-lg-6 control-label" for="deleteoption"><input class=" border-input" id="deleteoption"  value="1" name="delete"   type="checkbox"> Enable Delete Option </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                {!! Form::submit('Create User', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  )) !!}
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>

                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="card-action">
                        {!! Form::submit('Create Testimonial', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  ))  !!}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="row">
        <div class="panel panel-default col-md-9">
	 		<div class="panel-heading">
	            <h4 class="title" style="font-weight: bold;"> {{$createvar['title']}}
					<button type="button" class="btn btn-primary pull-right" onclick="window.location='{{ route($route['index']) }}'">Cancel</button>
	           </h4>
	            <p class="category">Items marked <sup class="required">*</sup> are required.</p>
	        </div>
	        <div class="panel-body">
	        	<h4>
		    	{!! Form::open(array('route' => $route['store'], 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true)) !!}

		    			@foreach($fields as $field => $fv)
		                    <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
					    		<label class="{{$fv['label_length']}} control-label"
					    				for="NEW_subject">{{$fv['label']}} : <sup class="required">*</sup>
					    		</label>
					    		<div class="{{$fv['field_length']}}">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="{{$fv['field_icon']}}"></i></div>
                                        </div>
	                                    @if(!strcmp($fv['type'], "text"))
					    					{!! Form::text($fv['name'], $fv['default'], $fv['extras']) !!}
	                                    @elseif(!strcmp($fv['type'], "textarea"))
	                                    	{!! Form::textarea($fv['name'], $fv['default'], $fv['extras']) !!}
	                                    @elseif(!strcmp($fv['type'], "select"))
	                                    	{!! Form::select($fv['name'], $fv['choices'], $fv['default'], $fv['extras']) !!}
	                                    @elseif(!strcmp($fv['type'], "checkbox"))
	                                    	{!! Form::checkbox($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
	                                    @elseif(!strcmp($fv['type'], "radio"))
	                                    	{!! Form::radio($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
	                                    @elseif(!strcmp($fv['type'], "file"))
	                                    	{!! Form::file($fv['name'],$fv['extras']) !!}
	                                    @else

					    				@endif
					    				@if ($errors->has($fv['name']))
	                                        <span class="help-block">
	                                            <strong>{{ $errors->first($fv['name']) }}</strong>
	                                        </span>
	                                    @endif
					    			</div>
					    		</div>
					    	</div>
					    @endforeach
					    <div class="form-group">
				    		<label class="col-lg-4 control-label" for="NEW_subject">Select Sidebar <sup class="required">*</sup>
				    		</label>
				    		<div class="col-lg-8" >
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="glyphicon glyphicon-pencil"></i></div>
                                    </div>
                                   	<select class="form-control border-input" name="permission[]" multiple>
						    			@php $sidebarItem = Config::get('app.sidebar',[]); @endphp
							    		@foreach($sidebarItem as $item)
							    			<option value="{{ $item['label'] }}">{{ $item['label'] }}</option>
							    		@endforeach;
							    	</select>
                                </div>
				    		</div>
					    </div>
					    <div class="form-group">
				    		<label class="col-lg-4 control-label" for="NEW_subject">Select Sidebar <sup class="required">*</sup>
				    		</label>
				    		<div class="col-lg-8" >
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="glyphicon glyphicon-pencil"></i></div>
                                    </div>
                                   	<select class="form-control border-input" name="role" >
							    		<option value="1">Admin</option>
							    		<option value="2">Editor</option>
							    	</select>
                                </div>
				    		</div>
					    </div>
					    <div class="form-group">
				    		<label class="col-lg-4 control-label" for="NEW_subject">Profile <sup class="required">*</sup>
				    		</label>
				    		<div class="col-lg-8" >
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="glyphicon glyphicon-pencil"></i></div>
                                    </div>
                                   	<input type="file" required="" name="feature_image">

                                 </div>
				    		</div>
					    </div>
					     <div class="form-group">

				    		<div class="col-lg-8" >
                                <div class="input-group">
                                    <label class="col-lg-8 control-label" for="deleteoption"><input class=" border-input" id="deleteoption"  value="1" name="delete"   type="checkbox"> Enable Delete Option </label>
                                </div>
				    		</div>
					    </div>

		                    <div class="form-group">
			                    {!! Form::submit($createvar['title'], array('class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit'  )) !!}
			                </div>
				{!! Form::close() !!}
				</h4>
	    	</div>

	        </div>
	</div>
</div>

<script>
	$(document).ready(function() {
	    $('select').select2();
	});
</script>

@endsection
