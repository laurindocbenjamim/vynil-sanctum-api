
@extends('errors.main')
@section('content')
<h1 class="error-title text-danger">404</h1>
                <h3 class="text-uppercase error-subtitle">PAGE NOT FOUND !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                @if (isset($message) && $message)
                    <p class="text-muted m-t-30 m-b-30">{{  $message }}</p>
                @endif
                <a href="/" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40 text-white">Back to home</a>
@endsection
