@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"><a href="/home">Home</a> / <a href="/home/clients">Clients</a></div>
                <div class="card-body">
                    <h1>Clients</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        @foreach ($clients as $client)
                            <ul>
                                <li>{{ $client->user_id }}</li>
                                <li>{{ $client->name }}</li>
                                <li>{{ $client->secret }}</li>
                                <li>{{ $client->redirect }}</li>
                                <li>{{ $client->id }}</li>
                            </ul>
                        @endforeach
                    </div>
                    <br>
                    <br>
                    <br>

                    <div>
                        <form action="/oauth/clients" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="">Redirect</label>
                                <input type="text" class="form-control" name="redirect">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
