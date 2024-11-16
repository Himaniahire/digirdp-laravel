@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                <h3 class="fw-bold mb-3">Category</h3>
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
                        <a href="{{ route('category.index')}}">Category</a>
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
                    <h4 class="title" style="font-weight: bold;"> Blogs
                            
                        </h4>
                   </h4>
                </div>
                <div class="card-body">
                    <h4>
                        @if(Session::has('post_msg'))
                        <div class="alert alert-success">
                            {{ Session::get('post_msg') }}
                        </div>
                    @endif
                    {!! Form::open(array('route'=>'category.store','class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true)) !!}
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="NEW_subject">Category Name <sup class="required fs-5 text-danger">*</sup>
                        </label>
                        <div class="col-lg-8" >
                            <div class="input-group">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>


                    <div class="form-group" style="width: 40%;">
                        {!! Form::submit('Add Category', array('class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit'  )) !!}
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

