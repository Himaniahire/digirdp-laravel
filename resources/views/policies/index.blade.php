@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Policies</h3>
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
                            <a href="{{ route('policies.index')}}">Policies</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('policies.index')}}">List</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Policies</h4>
                            <a href="{{ route($route['create']) }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus me-1"></i>New Policies </a>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            <div class="table-responsive">

                                <table id="basic-datatables" class="display table table-striped table-hover">
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
                                                    <a href="{{ route($route['show'], $notice->id)}}">
                                                        <button title="Detail" class="btn btn-lg btn-link btn-info">
                                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route($route['edit'], $notice->id) }}">
                                                        <button title="Edit" class="btn btn-lg btn-link btn-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="#" title="Delete" onclick="event.preventDefault(); confirmDelete('{{ $notice->id }}');" class="btn btn-danger btn-lg btn-link mt-0" style="margin-top: -15px;">
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


                        </h5>
                    </div>
                </div>
            </div>
            </div>
        </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(id) {
            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirmed, submit the delete form
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
