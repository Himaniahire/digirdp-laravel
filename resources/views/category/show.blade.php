@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Category</h3>
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
                            <a href="{{ route('category.index')}}">Category</a>
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
				        <h4 class="title">Category
				            <a href="{{ route('category.create') }}" class="btn btn-success pull-right">
				            	<i class="fa fa-plus"></i> Add Category
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
                                                @if(strpos($field,"image"))

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


                                                @else
                                                    <td>{{ ${$singlepostvar}->$field }}</td>

                                                @endif

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
