@extends('backend.layouts.app')

@section('title', __('Animali'))

@push('after-styles')
<style>
    .table td {
        vertical-align: middle;
    }
</style>
@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Lista animali')
        </x-slot>

        <x-slot name="body">

            <livewire:backend.animals-table />
        </x-slot>
    </x-backend.card>
@endsection