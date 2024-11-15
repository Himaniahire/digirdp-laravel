@extends('layouts.app')

@section('content-page')

<div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Testimonial</h3>
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
                    <h4 class="card-title">Testimonial</h4>
                    <a href="{{ route($route['create']) }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus"></i> New Testimonial </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Testimonial</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Testimonial</th>
                          <th>Image</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                      <tbody>
                        @foreach (${$multipostvar} as $notice)
                                    <tr>
                                        @foreach($fields as $field => $fv)
                                            {{-- STRCMP RETURNS 0 WHEN EQUAL --}}

                                            @if(strpos($field,"file"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(strpos($field,"logo"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(strpos($field,"banner"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(!strcmp($field,"created_at"))

                                                <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>

                                            @elseif(!strcmp($field,"updated_at"))

                                                <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>

                                            @elseif(!strcmp($field,"is_published"))


                                            @else
                                                <td>{{ substr($notice->$field,0,20) }}{{ strlen($notice->$field) > 20 ? "..." : ""}}</td>

                                            @endif
                                        @endforeach
                                        <td class="actions">
                                            <a href="{{ route($route['show'], $notice->id)}}">
                                                <button type="button" data-bs-toggle="tooltip" title=""
                                                class="btn btn-link btn-info btn-lg" data-original-title="Show">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
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



                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    @foreach($fields as $field => $fv)
                                        <th>{{ucwords($fv['label'])}}</th>
                                    @endforeach
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach (${$multipostvar} as $notice)
                                    <tr>
                                        @foreach($fields as $field => $fv)
                                            {{-- STRCMP RETURNS 0 WHEN EQUAL --}}

                                            @if(strpos($field,"file"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(strpos($field,"logo"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(strpos($field,"banner"))

                                                <td><img src="{{url($notice->$field)}}" width="50" height="50"></td>

                                            @elseif(!strcmp($field,"created_at"))

                                                <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>

                                            @elseif(!strcmp($field,"updated_at"))

                                                <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>

                                            @elseif(!strcmp($field,"is_published"))


                                            @else
                                                <td>{{ substr($notice->$field,0,20) }}{{ strlen($notice->$field) > 20 ? "..." : ""}}</td>

                                            @endif
                                        @endforeach
                                        <td class="actions">
                                            <a href="{{ route($route['show'], $notice->id)}}">
                                                <button class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <a href="{{ route($route['edit'], $notice->id) }}">
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
                            {!! ${$multipostvar}->render() !!}
                        </div>
                    </h5>
                </div>
            </div>
        </div>
    </div>

@endsection
