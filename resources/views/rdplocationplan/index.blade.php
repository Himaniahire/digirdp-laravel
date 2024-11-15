@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">RPD Location Plan</h3>
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
                            <a href="{{ route('rdplocationplan.index')}}">RPD Location Plan</a>
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
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">RPD Location Plan</h4>
                            <a href="{{ route($route['create']) }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus me-1"></i>New RPD Location Plan</a>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            <div class="table-responsive">

                                <table id="basic-datatables" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                @foreach($fields as $field => $fv)
                                                    <th>{{ucwords($fv['label'])}}</th>
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                @foreach($fields as $field => $fv)
                                                    <th>{{ucwords($fv['label'])}}</th>
                                                @endforeach
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    <tbody>
                                        @foreach (${$multipostvar} as $notice)
                                            <tr>
                                                @foreach($fields as $field => $fv)
                                                    {{-- STRCMP RETURNS 0 WHEN EQUAL --}}
                                                    @if(strpos($field,"image"))
                                                        <td><img src="{{url($notice->$field)}}" width="100" height="50"></td>
                                                    @elseif(strpos($field,"file"))
                                                        <td><a href="{{url($notice->$field)}}">DOWNLOAD FILE</a></td>
                                                    @elseif(!strcmp($field,"created_at"))
                                                        <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>
                                                    @elseif(!strcmp($field,"updated_at"))
                                                        <td>{{ date('d M Y, H:i:s', strtotime($notice->$field) )}}</td>
                                                    @elseif(!strcmp($field,"slug"))
                                                        <td><a target="_blank" href="{{url($indexvar['urltomain'].$notice->$field)}}">GO TO ALBUM</a></td>
                                                    @else
                                                        <td>{{ substr($notice->$field,0,20) }}{{ strlen($notice->$field) > 20 ? "..." : ""}}</td>
                                                    @endif
                                                @endforeach
                                                <td class="actions">
                                                    @if(!$notice->is_published)
				                                <a href="{{ route($route['publish'], $notice->id)}}">
				                                    <button class="btn btn-sm btn-primary">
				                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
				                                    </button>
				                                </a>
				                                @else
				                                <a href="{{ route($route['unpublish'], $notice->id)}}">
				                                    <button class="btn btn-sm btn-danger">
				                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
				                                    </button>
				                                </a>
				                                @endif
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

                                                    <a href="{{ route($route['duplicate'], $notice->id) }}">
                                                        <button class="btn btn-sm btn-secondary">
                                                            <i class="fa fa-copy"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            {{-- <div class="text-center">
                                {!! ${$multipostvar}->render() !!}
                            </div> --}}
                        </h5>
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
