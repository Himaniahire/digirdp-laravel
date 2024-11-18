@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                <h3 class="fw-bold mb-3">Blogs</h3>
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
                        <a href="{{ route('blogs.index')}}">Blogs</a>
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
                </div>
                <div class="card-body">
                    <h4>
                        @if(Session::has('post_msg'))
                        <div class="alert alert-success">
                            {{ Session::get('post_msg') }}
                        </div>
                    @endif
                    <h5>
                        {!! Form::open(['route' => 'blogs.store', 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true]) !!}
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Title <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Post Type <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <select class="form-control border-input" name="type">
                                        <option value="1">Draft</option>
                                        <option value="2">Publish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Category <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    @php
                                    $categories = App\Models\Category::where('status', 1)->get();
                                    @endphp
                                    <select class="my-select form-control border-input" name="category_id">
                                        @foreach($categories as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Description <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <textarea id="description" class="editor" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Feature Image <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <input type="file" name="feature_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Meta Title <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <textarea class="form-control editor" name="meta_title"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Meta Keywords <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <textarea class="form-control editor" name="meta_keywords" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Meta Descriptions <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <textarea class="form-control editor" name="meta_descriptions" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Tags <sup class="required" style="color:red; font-size:16px;">*</sup></label>
                            <div class="col-lg-8">
                                <textarea class="form-control editor" name="tags"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Add Blog', ['class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit']) !!}
                        </div>
                        {!! Form::close() !!}
                    </h5>


                    </h4>
                </div>
            </div>
        </div>
    </div>

    </div>


    </div>
@endsection

