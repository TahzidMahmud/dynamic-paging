@extends('backend.layouts.blank')
<div id="app">
    {{-- {{ dd($items) }} --}}
    <page-setting-component :items="{{ $items }}"></page-setting-component>
</div>

@section('content')

