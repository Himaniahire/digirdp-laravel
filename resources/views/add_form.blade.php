@extends('layouts.app')

@section('content-page')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header text-center">
                            <div class="card-title">Login</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <form action="" method="post">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email2">Email Address</label>
                                        <input type="email" class="form-control" id="email2"
                                            placeholder="Enter Email" />
                                        <small id="emailHelp2" class="form-text text-muted">We'll never share
                                            your email with anyone
                                            else.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder="Password" />
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
