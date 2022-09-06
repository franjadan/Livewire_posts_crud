@extends('layouts.app')

@section('content')
    <div class="container">
        @livewire('show-posts', ['title' => 'Este es un título de prueba']) <!-- El nombre del componente estar separado por - y en minúsculas -->
    </div>
@endsection
