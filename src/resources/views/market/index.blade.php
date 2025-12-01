@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')

@foreach($sections as $section)
        @includeIf('sections.' . $section->tipo, ['data' => $section])
    @endforeach

@endsection
