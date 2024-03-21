@extends('layouts.app')

@section('content')
  
  <livewire:job-detail :jobId="$jobId" />
  
@endsection