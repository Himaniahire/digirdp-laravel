@extends('layouts.app')

@section('content-page')

<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">User</h3>
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
            <a href="/">Dashboard</a>
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
          <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">User</h4>
                    <a href="{{ route($route['create']) }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus"></i> New User </a>
                </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    @foreach (${$multipostvar} as $index =>$notice)
                        <tr>
                            @foreach($fields as $field => $fv)
                                <td>
                                    @if ($field == 'id')
                                        {{ $index + 1 }}  <!-- Display incremental ID starting from 1 -->
                                    @else
                                        {{ substr($notice->$field, 0, 20) }}{{ strlen($notice->$field) > 20 ? "..." : "" }}
                                    @endif
                                </td>
                            @endforeach
                            <td class="">
                                @if($notice->status == 1)
                                    <a class="badge badge-primary" href="{{ route('user.status', ['id' => $notice->id, 'status' => 0]) }}">Active</a>
                                @else
                                    <a class="badge badge-danger" href="{{ route('user.status', ['id' => $notice->id, 'status' => 1]) }}">Inactive</a>
                                @endif
                            </td>
                            <td class="actions">
                                <a href="{{ route($route['show'], $notice->id) }}">
                                    <button type="button" data-bs-toggle="tooltip" title=""
                                        class="btn btn-link btn-info btn-lg" data-original-title="Edit Task">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                                <a href="{{ route($route['edit'], $notice->id) }}">
                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary"
                                        data-original-title="Edit">
                                       <i class="fa fa-edit"></i>
                                    </button>
                                </a>
                                {!! Form::open(['route' => [$route['destroy'], $notice->id], 'method' =>'DELETE', 'style' => 'margin-top: -15px;']) !!}
                                    <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger"
                                        data-original-title="Remove">
                                       <i class="fa fa-times"></i>
                                    </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


@endsection
