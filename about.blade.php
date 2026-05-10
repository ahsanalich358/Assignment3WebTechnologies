@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>About This Application
                </div>
                <div class="card-body p-4">
                    <h4 class="fw-bold text-primary mb-3">To-Do List Management App</h4>
                    <p class="text-muted">
                        This is a full-featured To-Do List Management web application built with
                        <strong>Laravel</strong> (PHP Framework) as part of the CSC336 Web Technologies
                        course at COMSATS University Islamabad, Vehari Campus.
                    </p>

                    <hr>

                    <h6 class="fw-bold mt-3 mb-2">Features</h6>
                    <ul class="text-muted">
                        <li>Add, Edit, and Delete tasks</li>
                        <li>Mark tasks as Pending or Completed</li>
                        <li>Set priority levels: Low, Medium, High</li>
                        <li>Set due dates for tasks</li>
                        <li>Filter tasks by Status and Priority</li>
                        <li>Dashboard statistics (Total, Pending, Completed)</li>
                        <li>Fully responsive design with Bootstrap 5</li>
                    </ul>

                    <hr>

                    <h6 class="fw-bold mt-3 mb-2">Technologies Used</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(['Laravel 11', 'PHP 8.2', 'MySQL', 'Bootstrap 5', 'Blade Templating', 'Eloquent ORM'] as $tech)
                            <span class="badge" style="background:#dbe4ff;color:#3b5bdb;font-size:.85rem;padding:.4em .8em;border-radius:6px;">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>

                    <hr>
                    <p class="mb-0 text-muted" style="font-size:.88rem;">
                        <strong>Course:</strong> CSC336 Web Technologies &nbsp;|&nbsp;
                        <strong>Instructor:</strong> Yasmeen Jana &nbsp;|&nbsp;
                        <strong>Spring 2026</strong>
                    </p>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('tasks.index') }}" class="btn btn-primary fw-semibold">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection