@extends('backend.layouts.blank')
<div id="app">
    {{-- {{ dd($items) }} --}}
    <page-setting :items="{{ $items }}"></page-setting>
</div>

@section('content')

