@extends('layouts.master')
{{-- Customize layout sections --}}
@section('subtitle', 'Dashboard')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Bem-vindo')
{{-- Content body: main page content --}}
@section('content_body')
    <p>    Este sistema tem como objetivo criar e gerenciar dados da planilha de sistemas,
        além de registrar as alterações feitas.</p>
@stop
{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush
{{-- Push extra scripts --}}
@push('js')
    <script>
        console.log("Hi, We are using the Laravel-AdminLTE package!");
    </script>
@endpush
