@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Configuration</h3>
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
                          <a href="{{route('configuration.index')}}">Configuration</a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="{{ route('configuration.index')}}">Edit</a>
                        </li>
                    </ul>
            </div>
            <div class="col-lg-12">
                <div class="content" >
                    <!-- Content goes here -->
                    <fieldset>
                        {!! Form::model(${$singlepostvar}, ['route' => [$route['update'], ${$singlepostvar}->id], 'class' => 'form-horizontal', 'method' => 'PUT', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files'=> true]) !!}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="panel-title"><h3><b>EDIT</b></h3></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($fields as $field => $fv)
                                            <div class="col-md-6">
                                            <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                                <label class="{{$fv['label_length']}} control-label"
                                                       for="NEW_subject">{{$fv['label']}}<sup class="required fs-5 text-danger">*</sup>
                                                </label>
                                                <div class="{{$fv['field_length']}}">

                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        </div >
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
                                        </div>
                                        <div class="ms-2">
                                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-block">Cancel</a>

                                            {!! Form::submit('Update', array('class' => 'btn btn-success btn-block', 'id' => 'submit'  ))  !!}
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </fieldset>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header text-center">
                            <div class="card-title">Login</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form action="" method="post">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email2">Email Address</label>
                                        <input type="email" class="form-control" id="email2"
                                            placeholder="Enter Email" />
                                        <small id="emailHelp2" class="form-text text-muted">We'll never share
                                            your email with anyone
                                            else.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Password" />
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div> --}}
        </div>


    </div>

@endsection
