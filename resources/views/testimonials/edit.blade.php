@extends('layouts.app')

@section('content-page')

<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Testimonial</h3>
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
            <a href="{{ route('testimonials.index')}}">Testimonial</a>
            
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
                        <div class="card-title">Testimonial Edit</div>
                    </div>

                    <div class="card-body">
                        {!! Form::model(${$singlepostvar}, ['route' => [$route['update'], ${$singlepostvar}->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files'=> true]) !!}
                        <div class="row">
                            @foreach($fields as $field => $fv)
                            <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                <label class="{{$fv['label_length']}} control-label"
                                       for="NEW_subject">{{$fv['label']}} : <sup class="required" style="color:red; font-size:16px;">*</sup>
                                </label>
                                <div class="{{$fv['field_length']}}">

                                    <div class="input-group border-input">
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
                                            <img width="100" height="100" src="{{url(${$singlepostvar}->$field)}}"><br>
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
</div>
<<<<<<< HEAD
<<<<<<< HEAD
                 
=======

>>>>>>> 5b9ca5030e85407618f3a7b09dfd54fe436abd9a
=======

>>>>>>> Nikesh
@endsection
