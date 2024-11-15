@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">VPS Plan</h3>
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
                            <a href="{{ route('vpsplan.index')}}">VPS Plan</a>
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
                        <a href="{{ route($route['index']) }}" class="btn btn-primary pull-right" ><i class="fas fa-angle-left"></i> Cancel</a>

                        <h3 class="title"><strong>{{$showvar['title']}}</strong></h3>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h4>
                            <table id="basic-datatables" class="table">
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
                                        @if(strpos($field,"file"))

                                            <td><img src="{{url(${$singlepostvar}->$field)}}" width="200" height="200">
                                            </td>

                                        @elseif(strpos($field,"file"))
                                            <td><a href="{{url(${$singlepostvar}->$field)}}">DOWNLOAD FILE</a></td>


                                        @elseif(!strcmp($field,"id"))
                                            <td>{{ ${$singlepostvar}->$field }}</td>

                                        @elseif(!strcmp($field,"created_at"))
                                            <td>{{ date('d M Y, H:i:s', strtotime(${$singlepostvar}->$field) )}}</td>

                                        @elseif(!strcmp($field,"updated_at"))
                                            <td>{{ date('d M Y, H:i:s', strtotime(${$singlepostvar}->$field) )}}</td>

                                        @elseif(!strcmp($field,"is_published"))


                                        @else
                                            <td>{{ ${$singlepostvar}->$field }}</td>

                                        @endif

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </h4>
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>

@endsection
