{{-- Extends Filament's default layout and overrides the font/heading styles --}}
@extends('filament::components.layout.layout')

@section('head')
    @parent
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .fi-body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        .fi-body h1, .fi-heading,
        .fi-card .fi-section-header-content h1,
        .fi-page-header h1 {
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 1.25rem !important;
        }
        .fi-body h2 { font-size: 1.125rem !important; }
        .fi-body h3 { font-size: 1rem !important; }
        .fi-body h4 { font-size: 0.9375rem !important; }
        .fi-body h5 { font-size: 0.875rem !important; }
        .fi-body h6 { font-size: 0.8125rem !important; }
        .fi-typography h1 { font-size: 1.25rem !important; }
        .fi-typography h2 { font-size: 1.125rem !important; }
        .fi-typography h3 { font-size: 1rem !important; }
        .fi-typography h4 { font-size: 0.9375rem !important; }
        .fi-typography h5 { font-size: 0.875rem !important; }
        .fi-typography h6 { font-size: 0.8125rem !important; }
        .fi-page-header h1 { font-size: 1.5rem !important; }
        .fi-card .fi-section-header-content h1 { font-size: 1.25rem !important; }
        .fi-badge {
            font-family: 'Inter', system-ui, sans-serif;
        }
    </style>
@endsection
