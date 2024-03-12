@extends('layouts.app')

@section('content')
    <h1>Курсы валют</h1>

    <ul>
        @foreach ($currencies as $currency)
            <li>{{ $currency->code }}: {{ $currency->rate }}</li>
        @endforeach
    </ul>
@endsection
