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
            <a href="{{ route('user.index')}}">User</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Edit</a>
          </li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">User Edit</div>
                    </div>
                    <div class="card-body">
                        {!! Form::model(${$singlepostvar}, ['route' => [$route['update'], ${$singlepostvar}->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files'=> true]) !!}
                        <div class="row">
                            @foreach($fields as $field => $fv)
                            <div class="col-lg-6">
                                <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                    <label class="control-label"
                                            for="NEW_subject">{{$fv['label']}} : <sup class="required" style="color:red; font-size:16px;">*</sup>
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
                            </div>
                            @endforeach
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Profile <sup class="required" style="color:red; font-size:16px;">*</sup>
                                    </label>
                                    <div class="" >
                                        <div class="input-group">
                                            <input type="file"  name="feature_image">
                                            @if(isset($feature_image) && $feature_image)
                                                <a href="{{ asset($feature_image) }}" target="_blank">
                                                    <img src="{{ asset($feature_image) }}" style="width:10%">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Password <sup class="required" style="color:red; font-size:16px;">*</sup>
                                    </label>
                                    <div class="" >
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="password" value="{{  ${$singlepostvar}->_password }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="NEW_subject">Select Sidebar  <sup class="required" style="color:red; font-size:16px;">*</sup>
                                    </label>
                                    <div class="" >
                                        <div class="input-group">
                                            <select class="form-control border-input" name="role" >
                                                <option value="1" {{ (${$singlepostvar}->role==1) ? 'selected' :'' }}>Admin</option>
                                                <option value="2" {{ (${$singlepostvar}->role==2) ? 'selected' :'' }}>Editor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="NEW_subject">Select Sidebar <sup class="required" style="color:red; font-size:16px;">*</sup>
                                </label>
                                <div class="" >
                                    <div class="input-group">
                                        @php $sidebarItem = Config::get('app.sidebar');
                                            $permission_array = [];
                                            $permission = ${$singlepostvar}->permission;
                                            $feature_image = ${$singlepostvar}->feature_image;
                                            $permission_array = ($permission && $permission != 'null' )? json_decode($permission) : [];
                                            @endphp
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <th>Label</th>
                                                    <th>Route</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sidebarItem as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="permission[]" value="{{ $item['route'] }}"
                                                            {{ in_array($item['route'], $permission_array) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>{{ $item['label'] }}</td>
                                                        <td>{{ $item['route'] }}</td>
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
                                    <div class="" >
                                        <div class="input-group">
                                            <label class=" control-label" for="deleteoption"><input class=" border-input" id="deleteoption"  {{ (${$singlepostvar}->deletep==1) ? 'checked' :'' }} name="delete"  value="1" type="checkbox"> Enable Delete Option </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">
                                {!! Form::submit('Update', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  ))  !!}
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
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
