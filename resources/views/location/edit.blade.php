@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Location</h3>
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
                            <a href="{{ route('location.index')}}">Location</a>
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
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit</h4>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        {!! Form::open(array('url'=>route('location.update',['location'=>$category->id]),'method'=>'PATCH','class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true)) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Location Name <sup class="required" style="color:red; font-size:16px;">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control" value="{{ $category->name ?? ''  }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Location Iframe <sup class="required" style="color:red; font-size:16px;">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <div class="input-group">
                                            <input type="text" name="iframe" class="form-control" value="{{ $category->iframe ?? ''  }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="width: 40%;">
                                    {!! Form::submit('update Location', array('class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit'  )) !!}
                                </div>
                            </div>
                        </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
