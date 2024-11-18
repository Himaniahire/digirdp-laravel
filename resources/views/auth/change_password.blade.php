@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Change Password</h3>
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
                            <a href="/">Profile</a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Change Password</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title"> Change Password</h4>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            {!! Form::open(array('route'=>'password.change','class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true)) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label" for="NEW_subject">Current Password<sup class="required" style="color:red; font-size:16px;">*</sup>
                                        </label>
                                        <div class="col-lg-8" >
                                            <div class="input-group">
                                                <input type="text" name="current_password" class="form-control" required>
                                            </div>
                                            @if ($errors->has('current_password'))
                                                    <small class="text-danger">{{ $errors->first('current_password') }}</small>
                                                @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label" for="NEW_subject">New Password <sup class="required" style="color:red; font-size:16px;">*</sup>
                                        </label>
                                        <div class="col-lg-8" >
                                            <div class="input-group">
                                                <input type="text" name="new_password" class="form-control" required>
                                            </div>
                                            @if ($errors->has('new_password'))
                                                    <small class="text-danger">{{ $errors->first('new_password') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label" for="NEW_subject">Confirm Password <sup class="required" style="color:red; font-size:16px;">*</sup>
                                        </label>
                                        <div class="col-lg-8" >
                                            <div class="input-group">
                                                <input type="text" name="new_password_confirmation" class="form-control" required>
                                            </div>
                                            @if ($errors->has('new_password_confirmation'))
                                                    <small class="text-danger">{{ $errors->first('new_password_confirmation') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-group" style="width: 40%;">
                                    {!! Form::submit('Change Password', array('class' => 'btn pull-down mt-4 btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit'  )) !!}
                                </div>
                                </div>
                            {!! Form::close() !!}
                            </div>

				        </h5>
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
