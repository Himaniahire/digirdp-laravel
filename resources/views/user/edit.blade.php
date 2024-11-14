@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                <h3 class="fw-bold mb-3">User</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">DashBoard</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit</a>
                    </li>
                </ul>
            </div>

            <fieldset>
                {!! Form::model(${$singlepostvar}, ['route' => [$route['update'], ${$singlepostvar}->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files'=> true]) !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="panel-title"><h3><b>EDIT</b></h3></div>
                            </div>
                            <div class="card-body">
                                @foreach($fields as $field => $fv)
                                    <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                        <label class="{{$fv['label_length']}} control-label"
                                               for="NEW_subject">{{$fv['label']}} : <sup class="required fs-5 text-danger">*</sup>
                                        </label>
                                        <div class="{{$fv['field_length']}}">

                                            <div class="input-group">
                                                <div class="input-group-prepend">

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
                                                    <img src="{{url(${$singlepostvar}->$field)}}" width="250" height="150"><br>
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
                    @php $sidebarItem = Config::get('app.sidebar');

                                $permission_array = [];
                                $permission = ${$singlepostvar}->permission;
                                $feature_image = ${$singlepostvar}->feature_image;
                                $permission_array = ($permission && $permission != 'null' )? json_decode($permission) : [];
                                @endphp
                            <select class="form-control border-input" name="permission[]" multiple>

                                @foreach($sidebarItem as $item)
                                    <option value="{{ $item['route'] }}" {{ in_array($item['route'],$permission_array) ? "selected" : '' }}>{{ $item['label'] }}</option>
                                @endforeach;
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
                                   <input type="file"  name="feature_image">
                                   @if($feature_image)
                                       <a href="{{ asset($feature_image) }}" target="_blank"><img src="{{ asset($feature_image) }}" style="width:10%"></a>
                                   @endif
                             </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="NEW_subject">Password <sup class="required">*</sup>
                        </label>
                        <div class="col-lg-8" >
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="glyphicon glyphicon-pencil"></i></div>
                                </div>
                               <input type="text" name="password" value="{{  ${$singlepostvar}->_password }}">

                             </div>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="col-lg-4 control-label" for="NEW_subject">Select Sidebar  <sup class="required">*</sup>
                    </label>
                    <div class="col-lg-8" >
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="glyphicon glyphicon-pencil"></i></div>
                            </div>
                            <select class="form-control border-input" name="role" >
                                <option value="1" {{ (${$singlepostvar}->role==1) ? 'selected' :'' }}>Admin</option>
                                <option value="2" {{ (${$singlepostvar}->role==2) ? 'selected' :'' }}>Editor</option>
                            </select>
                        </div>
                    </div>
                </div>
                 <div class="form-group">

                    <div class="col-lg-8" >
                        <div class="input-group">
                            <label class="col-lg-8 control-label" for="deleteoption"><input class=" border-input" id="deleteoption"  {{ (${$singlepostvar}->deletep==1) ? 'checked' :'' }} name="delete"  value="1" type="checkbox"> Enable Delete Option </label>
                        </div>
                    </div>

                    <div>
                        <a href="{{ url()->previous() }}" class="btn btn-primary btn-block">Cancel</a>

                        {!! Form::submit('Update', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  ))  !!}
                    </div>
                </div>

                            </div>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}
            </fieldset>
        </div>
    </div>

    </div>


    </div>
@endsection
