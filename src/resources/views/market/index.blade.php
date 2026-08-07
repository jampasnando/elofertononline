@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')
@php
// dd($sections);
@endphp
@foreach($sections as $section)
    @includeIf('sections.' . $section->tipo, ['data' => $section])
@endforeach

@if(collect($sections)->contains('tipo','busqueda'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('seccionbusqueda');
        if (!el) return;

        var header = document.querySelector('header, .navbar, .topbar');
        var headerOffset = header ? header.offsetHeight : 0;
        var elementPosition = el.getBoundingClientRect().top + window.pageYOffset;
        var offsetPosition = elementPosition - headerOffset - 8;

        el.setAttribute('tabindex', '-1');
        el.focus({ preventScroll: true });

        window.scrollTo({
            top: Math.max(offsetPosition, 0),
            behavior: 'smooth'
        });
    });
    </script>
@endif

@endsection
