@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Blogs</h3>
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
                          <a href="#">List</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
				        <h4 class="title">Blog
				            <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-round float-end">
				            	<i class="fa fa-plus"></i> Add Blog
				            </a>

			            </h4>
			        </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        @if(Session::has('post_msg'))
                            <div class="alert alert-success">
                                {{ Session::get('post_msg') }}
                            </div>
	                    @endif
                        <h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Post By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
			                    	@php
			                    		$count = 0;
			                    	@endphp
			                    	@foreach($blogs as $bl)
			                    		<tr>
				                            <td>{{ ++$count }}</td>
				                            <td>{{ $bl->title ?? '' }}</td>
				                            <td>
				                            	@if($bl->status==1)
				                            		<a class="badge badge-success" href="{{ route('blog.status.change') }}?id={{ $bl->id }}&status=2">Active</a>
				                            	@else
				                            		<a class="badge badge-danger" href="{{ route('blog.status.change') }}?id={{ $bl->id }}&status=1">Inactive</a>
				                            	@endif

				                            </td>
				                            <td>{{ $bl->user->name ?? '' }}</td>
				                            <td class="actions">
				                                <!-- <a href="{{ route('blogs.edit',['blog'=>$bl->id]) }}">
				                                    <button class="btn btn-sm btn-primary">
				                                        <i class="fa fa-eye" aria-hidden="true"></i>
				                                    </button>
				                                </a> -->
				                                <a href="{{ route('blogs.edit',['blog'=>$bl->id]) }}">
				                                    <button class="btn btn-sm btn-warning">
				                                        <i class="fas fa-edit"></i>
				                                    </button>
				                                </a>
				                            </td>
				                        </tr>
			                    	@endforeach
			                    </tbody>
                                </table>
                            </div>

                            <div class="text-center">

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
