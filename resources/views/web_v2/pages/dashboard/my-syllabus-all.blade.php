@props(['title'])

@extends('web_v2.layouts.index')
@section('title', 'My Syllabus')

@section('content')
    <x-layouts.dashboard-layout title="Home">
        <div>
            <x-pages.my-syllabus.list title={{ $title }} :webinars="$viewedWebinars" />
        </div>
    </x-layouts.dashboard-layout>
@endsection
