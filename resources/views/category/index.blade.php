@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Policies</h3>
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
                          <a href="#">Policies</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
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
                                        @foreach($category as $bl)
                                            <tr>
                                                <td>{{ ++$count }}</td>
                                                <td>{{ $bl->name ?? '' }}</td>
                                                <td>
                                                    @if($bl->status==1)
                                                        <a class="badge badge-success" href="{{ route('category.status.change') }}?id={{ $bl->id }}&status=2">Active</a>
                                                    @else
                                                        <a class="badge badge-danger" href="{{ route('category.status.change') }}?id={{ $bl->id }}&status=1">Inactive</a>
                                                    @endif

                                                </td>
                                                <td>{{ $bl->user->name ?? '' }}</td>
                                                <td class="actions">
                                                    <!-- <a href="{{ route('blogs.edit',['blog'=>$bl->id]) }}">
                                                        <button class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a> -->
                                                    <a href="{{ route('category.edit',['category'=>$bl->id]) }}">
                                                        <button class="btn btn-sm btn-warning">
                                                            <i class="fa fa-pencil"></i>
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
