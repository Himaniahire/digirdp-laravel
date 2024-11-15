@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex">
                    <h3 class="fw-bold mb-3">Features</h3>
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
                            <a href="{{ route('features.index')}}">Features</a>

                        </li>
                        <li class="separator">
                          <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                          <a href="#">Table</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Features</h4>
                            <a href="{{ route('features.create') }}" class="btn btn-primary btn-round ms-auto"><i class="fa fa-plus me-1"></i>New Features </a>
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            <div class="table-responsive">

                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
				                        <tr>
					                        <th>#</th>
											<th>Feature</th>
											<th>Category</th>
											<th>Details</th>
				                            <th>Actions</th>
				                        </tr>
				                    </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Feature</th>
                                                <th>Category</th>
                                                <th>Details</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    <tbody>
                                        @foreach ($features_card as $fc)
				                        <tr>
				                        	<td>{{ $fc->card_id }}</td>
				                        	<td>{{ $fc->card_title }}</td>
				                        	<td>{{ $fc->category_name }}</td>
											<td>{{ substr($fc->card_content,0,20) }}{{ strlen($fc->card_content) > 20 ? "..." : ""}}</td>
				                            <td class="actions">
				                                <a href="{{ route('features.show', $fc->card_id)}}">
				                                    <button class="btn btn-sm btn-primary">
				                                        <i class="fas fa-eye" aria-hidden="true"></i>
				                                    </button>
				                                </a>
				                                <a href="{{ route('features.edit', $fc->card_id) }}">
				                                    <button class="btn btn-sm btn-warning">
				                                        <i class="fas fa-edit"></i>
				                                    </button>
				                                </a>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $fc->card_id }}').submit();" class="btn btn-danger btn-sm mt-0" style="margin-top: -15px;">
                                                    <i class="fas fa-trash"></i>
                                                </a>

                                                <form id="delete-form-{{ $fc->card_id }}" action="{{ route('features.destroy', $fc->card_id) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
				                            </td>
				                        </tr>
				                    @endforeach
                                    </tbody>

                                </table>
                            </div>

                            {{-- <div class="text-center">
                                {{ $features_card->links() }}
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
