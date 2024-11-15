@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">RPD Location</h3>
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
                            <a href="{{ route('rdplocation.index')}}">RPD Location</a>
                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Detail</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <h3 class="title"><strong>{{$showvar['title']}}</strong></h3>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h4>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Table Attributes</th>
                                    <th colspan="2">Table Values</th>
                                </tr>
                                @foreach($fields as $field => $fv)
                                {{-- STRCMP RETURNS 0 WHEN EQUAL --}}
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{ucwords($fv['label'])}}</td>
                                    @if(!strcmp($field,"image"))
                                        <td><img src="{{url(${$singlepostvar}->$field)}}" width="200" height="150"></td>
                                    @elseif(strpos($field,"file"))
                                        <td><a href="{{url(${$singlepostvar}->$field)}}">DOWNLOAD FILE</a></td>
                                    @elseif(!strcmp($field,"id"))
                                        <td>{{ ${$singlepostvar}->$field }}</td>
                                    @elseif(!strcmp($field,"created_at"))
                                        <td>{{ date('d M Y, H:i:s', strtotime(${$singlepostvar}->$field) )}}</td>
                                    @elseif(!strcmp($field,"updated_at"))
                                        <td>{{ date('d M Y, H:i:s', strtotime(${$singlepostvar}->$field) )}}</td>
                                    @elseif(!strcmp($field,"is_published"))
                                    @elseif(!strcmp($field,"show_in_header") || !strcmp($field,"show_in_footer"))
                                        <td>{{ ${$singlepostvar}->$field == 1 ? 'Yes' : 'No' }}</td>
                                    @else
                                        <td>{{ ${$singlepostvar}->$field }}</td>
                                    @endif
                                </tr>
                            @endforeach

                                </tbody>
                            </h4>
                            <h5>
                            </table>


                                <div class="card-header">
                                    <h3 class="title"><strong>{{$plantitle}}</strong></h3>
                                </div>
                                <table class="table bootstrap-admin-table-with-actions">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Plans</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($category as $notice)
                                        <tr>
                                            <td>
                                                {{($loop->index+1)}}
                                            </td>
                                            <td>
                                                {{$notice->name}}
                                            </td>
                                            <td class="actions">
                                                @if(!$notice->is_published)
                                                    <a href="{{ route('rdpplan.publish', $notice->id)}}">
                                                        <button class="btn btn-sm btn-primary">
                                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                @else
                                                    <a href="{{ route('rdpplan.unpublish', $notice->id)}}">
                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                @endif
                                                <a href="{{route('rdpplan.show', $notice->id)}}">
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('rdpplan.edit', $notice->id)}}">
                                                    <button class="btn btn-sm btn-warning">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </h5>


                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
