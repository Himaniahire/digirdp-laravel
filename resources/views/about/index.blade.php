@extends('layouts.app')

@section('content-page')

<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">About</h3>
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
            <a href="{{ route('about.index')}}">About</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="{{ route('about.index')}}">Edit</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card-title">About Edit</div>
            </div>
            <div class="card-body">
                {!! Form::model(${$singlepostvar}, ['route' => [$route['update'], ${$singlepostvar}->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files'=> true]) !!}

                <div class="row">
                    @foreach($fields as $field => $fv)
                    <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                        <label class="{{$fv['label_length']}}" for="NEW_subject">{{$fv['label']}} <sup class="required" style="color: red; font-size: 16px">*</sup>
                        </label>
                        <div class="{{$fv['field_length']}}">
                                @if(!strcmp($fv['type'], "text"))
                                    {!! Form::text($fv['name'], $fv['default'], $fv['extras']) !!}
                                @elseif(!strcmp($fv['type'], "textarea"))
                                    {!! Form::textarea($fv['name'], $fv['default'], array_merge($fv['extras'], ['id' => 'editor'])) !!}
                                @elseif(!strcmp($fv['type'], "select"))
                                    {!! Form::select($fv['name'], $fv['choices'], $fv['default'], $fv['extras']) !!}
                                @elseif(!strcmp($fv['type'], "checkbox"))
                                    {!! Form::checkbox($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
                                @elseif(!strcmp($fv['type'], "radio"))
                                    {!! Form::radio($fv['name'], $fv['default'], $fv['checked'],$fv['extras']) !!}
                                @elseif(!strcmp($fv['type'], "file"))
                                    <img src="{{url(${$singlepostvar}->$field)}}" width="250" height="150"><br>
                                    {!! Form::file($fv['name'],$fv['extras']) !!}
                                @elseif(!strcmp($fv['type'], "email"))
                                    <!-- Email Input field -->
                                    <div class="form-group">
                                        <label for="{{ $fv['name'] }}">{{ $fv['label'] }}</label>
                                        <input type="email" class="form-control" id="{{ $fv['name'] }}" name="{{ $fv['name'] }}" placeholder="{{ $fv['placeholder'] }}" value="{{ old($fv['name'], $fv['default']) }}" {{ $fv['extras'] }} />
                                        <small id="{{ $fv['name'] }}Help" class="form-text text-muted">{{ $fv['help_text'] }}</small>
                                    </div>
                                @else
                                    <!-- Default or empty case -->
                                @endif

                                @if ($errors->has($fv['name']))
                                    <span class="help-block">
                                        <strong>{{ $errors->first($fv['name']) }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>

                    @endforeach
                </div>

                {!! Form::close() !!}
            </div>
            <div class="card-action">
                {!! Form::submit('Update', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  ))  !!}
                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

@section('footer-script')

<script>

</script>

@endsection
