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
                          <a href="#">Table</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Location</h4>
                            <a href="{{ route('location.create') }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus me-1"></i>New Location </a>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            <div class="table-responsive">
                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Title</th>
                                                <th>Status</th>
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
                                                {{-- <td>{{ $bl->user->name ?? '' }}</td> --}}
                                                <td class="actions">
                                                    {{-- <!-- <a href="{{ route('blogs.edit',['blog'=>$bl->id]) }}">
                                                        <button class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a> --> --}}
                                                    <a href="{{ route('location.edit',['location'=>$bl->id]) }}">
                                                        <button title="Edit" class="btn btn-lg btn-link btn-primary">
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
