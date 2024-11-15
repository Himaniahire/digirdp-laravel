@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                <h3 class="fw-bold mb-3">VPS</h3>
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
                        <a href="{{ route('vps.index')}}">VPS</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="title" style="font-weight: bold;"> {{$createvar['title']}}

                        <a href="{{ route($route['index']) }}" class="btn btn-primary pull-right" ><i class="fas fa-angle-left"></i> Cancel</a>
                   </h4>

                </div>
                <div class="card-body">
                    <h4>
                        {!! Form::open([
                            'route' => $route['store'],
                            'class' => 'form-horizontal',
                            'data-parsley-validate' => '',
                            'autocomplete' => 'off',
                            'files' => true,
                        ]) !!}
                         <div class="row">
                        @foreach ($fields as $field => $fv)
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has($fv['name']) ? ' has-error' : '' }}">
                                <label class=" control-label" for="NEW_subject">{{ $fv['label'] }}
                                <sup class="required fs-5 text-danger" >*</sup>
                                </label>
                                <div class="">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            {{-- <div class="input-group-text"><i class="{{ $fv['field_icon'] }}"></i></div> --}}
                                        </div>
                                        @if (!strcmp($fv['type'], 'text'))
                                            {!! Form::text($fv['name'], $fv['default'], $fv['extras']) !!}
                                        @elseif(!strcmp($fv['type'], 'select'))
                                            {!! Form::select($fv['name'], $fv['choices'], $fv['default'], $fv['extras']) !!}
                                        @elseif(!strcmp($fv['type'], 'textarea'))
                                            {!! Form::textarea($fv['name'], $fv['default'], $fv['extras'], ['id' => 'editor']) !!}
                                        @elseif(!strcmp($fv['type'], 'checkbox'))
                                            {!! Form::checkbox($fv['name'], $fv['default'], $fv['checked']) !!}
                                        @elseif(!strcmp($fv['type'], 'radio'))
                                            {!! Form::radio($fv['name'], $fv['default'], $fv['checked'], $fv['extras']) !!}
                                        @elseif(!strcmp($fv['type'], 'date'))
                                            {!! Form::radio($fv['name'], $fv['default'], $fv['default'], $fv['extras']) !!}
                                        @elseif(!strcmp($fv['type'], 'file'))
                                            {!! Form::file($fv['name'], $fv['extras']) !!}
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

                                <div class="form-group">
                                        {!! Form::submit($createvar['title'], [
                                            'class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center',
                                            'id' => 'submit',
                                        ]) !!}
                                </div>

                        {!! Form::close() !!}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    </div>


    </div>
@endsection

