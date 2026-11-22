@extends('layouts.app')

@section('title', 'Planin - Không gian làm việc')

@section('sidebar')
    @include('board.sidebar')
@endsection

@section('content')
    @include('board.main')
@endsection

@section('modals')
    @include('board.modal-workspace')
    @include('board.modal-board')
@endsection

{{-- JavaScript xử lý Modal và Dropdown --}}
@push('scripts')
    @include('board.scripts')
@endpush
