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
                        <h5>
                            <div class="table-responsive">
                                <a  href="{{ route($route['create']) }}" class="btn btn-primary float-end" > <i class=""></i>New Policies</a>
                                <table class="table">
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
                                                    <a href="{{ route($route['show'], $notice->id)}}">
                                                        <button class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route($route['edit'], $notice->id) }}">
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
                                {!! ${$multipostvar}->render() !!}
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
