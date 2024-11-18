@extends('layouts.app')

{{-- @section('title','Show Item') --}}
@section('content-page')

@section('content-page')

<div class="container">
    <div class="page-inner">
        <div class="d-flex">
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
                      <a href="#">Detail</a>
                    </li>
                </ul>
        </div>

		    <div class="row">
		    	<div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="title"><strong>{{$showvar['title']}}</strong></h3>
                        </div>
                        <div class="card-body" >
                            <table class="table table-hover table-bordered" >
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
                                    @if($feature_image)
                                        <tr>
                                            <td>6</td>
                                            <td>Profile</td>
                                            <td><a href="{{ asset($feature_image) }}" target="_blank"><img src="{{ asset($feature_image) }}" style="width:10%"></a></td>
                                        </tr>
                                    @endif
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
