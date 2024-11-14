@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Blog</h3>
                    <ul class="breadcrumbs mb-3">
                        <li class="nav-home">
                          <a href="#">
                            <i class="icon-home"></i>
                          </a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">DashBoard</a>
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
				        <h4 class="title">Blogs
				            <button type="button" class="btn btn-primary pull-right" onclick="window.location='{{ route('blogs.index') }}'">Cancel</button>
                            @if(Auth::user()->deletep == 1)
                                <a href="{{ route('blog.delete') }}?id={{ $post->id }}" class="btn btn-danger pull-right" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            @endif
			            </h4>
			        </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        @if(Session::has('post_msg'))
                            <div class="alert alert-success">
                                {{ Session::get('post_msg') }}
                            </div>
	                    @endif
                        {!! Form::open(['url' => route('blogs.update', ['blog' => $post->id]), 'method' => 'PATCH', 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'autocomplete' => 'off', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-6">



                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Title <sup class="required">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <input type="text" name="title" value="{{ $post->title ?? '' }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Post Type <sup class="required">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <select class="form-control border-input" name="type">
                                        <option value="1" {{ ($post->type == 1) ? 'selected' : '' }}>Draft</option>
                                        <option value="2" {{ ($post->type == 2) ? 'selected' : '' }}>Publish</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Category <sup class="required">*</sup></label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    @php
                                        $categories = App\Models\Category::where('status', 1)->get();
                                    @endphp
                                    <select class="form-control border-input" name="category_id">
                                        @foreach($categories as $cate)
                                            <option value="{{ $cate->id }}" {{ ($post->category_id == $cate->id) ? 'selected' : '' }}>{{ $cate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Description<sup class="required">*</sup></label>
                            <div class="col-lg-8">
                                <textarea name="description" id="description">{{ $post->description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="NEW_subject">Feature Image<sup class="required">*</sup></label>
                            <div class="col-lg-8">
                                <input type="file" name="feature_image">
                            </div>
                            @if($post->feature_image)
                                <a href="{{ asset($post->feature_image) }}" target="_blank"><img src="{{ asset($post->feature_image) }}" style="width:50px;height: 50px;"></a>
                            @endif
                        </div>
                    </div>
                        <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Meta Title<sup class="required">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <textarea class="form-control" name="meta_title">{{ $post->meta_title ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject" >Meta Keywords<sup class="required">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <textarea class="form-control" name="meta_keywords" required>{{ $post->meta_keywords ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Meta Descriptions<sup class="required">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <textarea class="form-control" name="meta_descriptions" required>{{ $post->meta_descriptions ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Tags<sup class="required">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <textarea class="form-control" name="tags">{{ $post->tags ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label" for="NEW_subject">Show Home Page<sup class="required">*</sup>
                                    </label>
                                    <div class="col-lg-8" >
                                        <label><input type="checkbox" {{ ($post->home==1) ? 'checked' : '' }} class="z-control" name="home" value="1"> Yes</label>
                                    </div>
                                </div>

                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Update Blog', array('class' => 'btn pull-down btn-success btn-lg col-lg-10 col-md-offset-2 col-xs-offset-3 text-center', 'id' => 'submit'  )) !!}
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
