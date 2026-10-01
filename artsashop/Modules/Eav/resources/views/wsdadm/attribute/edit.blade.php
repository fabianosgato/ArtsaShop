@extends('adminlte::page')
@section('content_header')
    <h1>Grupo de atributos</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            @include('wsdadm.layouts.flash-messages')
            @livewire('', ['data' => $eavAttributeSet])
        </div>
    </div>
@endsection
