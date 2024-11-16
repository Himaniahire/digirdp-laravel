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


                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
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
