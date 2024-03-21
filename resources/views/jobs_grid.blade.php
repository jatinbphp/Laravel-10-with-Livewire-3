@extends('layouts.app')

@section('content')
@php
  
@endphp
  <livewire:find-job />

    
@endsection
@section('js')
  <script src="{{ asset('assets/js/noUISlider.js') }}"  data-navigate-once></script>
  <script src="{{ asset('assets/js/slider.js') }}?v=4.1"  data-navigate-once></script>
  <script src="{{ asset('assets/js/jobs.js') }}?v=4.1" data-navigate-once></script>
@endsection