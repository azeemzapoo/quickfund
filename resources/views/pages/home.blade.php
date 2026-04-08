
@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



    <h1>Welcome to QuickFund 🚀</h1>
    <p>Validate your ideas and build with others.</p>
@endsection

