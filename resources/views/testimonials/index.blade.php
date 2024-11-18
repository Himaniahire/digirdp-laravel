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
            <a href="{{ route('testimonials.index')}}">Testimonial</a>
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
