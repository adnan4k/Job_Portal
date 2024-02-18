@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        @include('message')
        <div class="col-md-6">
            <h1>Looking for an employee?</h1>
            <h3>Please create an account</h3>
            <img src={{ asset('/image/click-here.webp') }} width="450"
            class="img-responsibe">
        </div>
     
        <div class="col-md-6 mt-5 mb-5">
            <div class="card" id="card" style="margin-top:50px;">
                <div class="card-header">Register</div>
                <form action="{{route('store.employer')}}" method="post" id="registrationForm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Company name</label>
                            <input type="text" name="name" class="form-control" required>
                            @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" required>
                            @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password')}}</span>
                            @endif
                        </div>
                        <br>
                        <div class="form-group mb-5 mt-3">
                            <button class="btn btn-dark" id="btnRegister">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection