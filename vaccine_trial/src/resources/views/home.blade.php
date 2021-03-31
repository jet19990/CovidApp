@extends('layouts.user.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$name->name}}</div>

                <div class="card-body">
                   <table class="table table-striped table-bordered">
                   <thead>
                   <th>Attribute</th>
                   <th>Value</th>
                   </thead>
                   <tbody>
                    <tr>
                    <td>Name</td>
                    <td>{{$name->name}}</td>
                    </tr>
                    <tr>
                    <td>email</td>
                    <td>{{$name->email}}</td>
                    </tr>
                    <tr>
                    <td>created_at</td>
                    <td>{{$name->created_at}}</td>
                    </tr>
                   </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
