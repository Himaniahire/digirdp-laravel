@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Features</h3>
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
                          <a href="#">Table</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit</h4>
                            <a href="{{ route('features.index') }}" class="btn btn-primary btn-round ms-auto"><i class="fas fa-angle-left"></i> Cancel </a>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <fieldset>
                            <form class="form-horizontal" method="post" action="{{ route('features.update', $features->card_id) }}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Feature Title</label>
                                                <input name="card_title" required type="text" class="form-control" placeholder="Enter Feature title here" value="{{ $features->card_title }}">
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <img src="/{{ $features->card_image }}" style="height: 5em;">
                                                <br>
                                                <label>UPLOAD</label>
                                                <input class="form-control" accept="image/png, image/gif, image/jpeg" name="card_image" type="file" class="form-control-file">
                                              </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Feature Content</label>
                                                <textarea name="card_content" required class="form-control" rows="3"
                                                placeholder="Enter Feature Content here"
                                                >{{ $features->card_content }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Category</label>
                                              <select name="category_id" class="custom-select form-control" required>
                                                <option value="" >Select Category</option>
                                                <option selected value="{{ $features->category_id }}">
                                                    {{ $features->category_name }}
                                                </option>
                                                @foreach ($feature_category as $category)
                                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <a href="{{ route('features.index') }}" class="btn btn-primary btn-block">Cancel</a>

                                                <button class="btn btn-success btn-block" type="submit">Update</button>
                                            </div>
                                        </div>

                            </form>
                        </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
