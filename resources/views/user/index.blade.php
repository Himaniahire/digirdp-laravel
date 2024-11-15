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
            <a href="{{ route('user.index')}}">User</a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="{{ route('user.index')}}">List</a>
          </li>
        </ul>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Basic</h4>
                    <a href="{{ route($route['create']) }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus me-1"></i>New User </a>
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
                                <a href="{{ route($route['show'], $notice->id)}}">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                    </button>
                                </a>
                                <a href="{{ route($route['edit'], $notice->id) }}">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>

                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $notice->id }}').submit();" class="btn btn-danger btn-sm mt-0" style="margin-top: -15px;">
                                    <i class="fas fa-trash"></i>
                                </a>

                                <form id="delete-form-{{ $notice->id }}" action="{{ route($route['destroy'], $notice->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

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
