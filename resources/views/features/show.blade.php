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
                          <a href="#">Detail</a>
                        </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="card" >
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Features</h4>
                            
                        </div>
                    </div>
                    <!-- Content goes here -->
                    <div class="card-body" >
                        <h5>
                            <div class="table-responsive">

                                <table id="basic-datatables" class="table">
                                        <tbody>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Table Attributes</th>
                                                <th colspan="2">Table Values</th>
                                            </tr>
                                                {{-- STRCMP RETURNS 0 WHEN EQUAL --}}
                                                <tr>
                                                    <td>1</td>
                                                    <td>Feature ID</td>
                                                    <td>{{ $features_card->card_id }}</td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Feature Title</td>
                                                    <td>{{ $features_card->card_title }}</td>
                                                </tr>

                                                <tr>
                                                    <td>3</td>
                                                    <td>Feature Content</td>
                                                    <td>{{ $features_card->card_content }}</td>
                                                </tr>

                                                <tr>
                                                    <td>4</td>
                                                    <td>Feature Image</td>
                                                    <td><img src="/{{ $features_card->card_image }}" style="height: 5em;"></td>
                                                </tr>

                                                <tr>
                                                    <td>5</td>
                                                    <td>Category</td>
                                                    <td>{{ $features_card->category_name }}</td>
                                                </tr>

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
