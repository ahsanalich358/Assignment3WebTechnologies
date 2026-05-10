@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Page Heading -->
    <div class="text-center mb-4">
        <h2 class="fw-bold" style="color:#3b5bdb;">My To-Do List</h2>
        <p class="text-muted mb-0">Stay organised and get things done.</p>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-box">
                <div class="num text-primary">{{ $totalCount }}</div>
                <div class="lbl">Total Tasks</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-box">
                <div class="num" style="color:#f59f00;">{{ $pendingCount }}</div>
                <div class="lbl">Pending</div>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-box">
                <div class="num" style="color:#2f9e44;">{{ $completedCount }}</div>
                <div class="lbl">Completed</div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- ── Left: Add Task Form ── -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-plus-circle me-2"></i>Add New Task
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Task Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Enter task title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Task Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="3" placeholder="Enter task description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                                <option value="Low"    {{ old('priority') == 'Low'    ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority','Medium') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High"   {{ old('priority') == 'High'   ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-add">
                            <i class="fas fa-plus me-1"></i> Add Task
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ── Right: Task Table ── -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list-check me-2"></i>All Tasks</span>
                    <!-- Filter controls -->
                    <div class="d-flex gap-2">
                        <form method="GET" action="{{ route('tasks.index') }}" class="d-flex gap-2 mb-0">
                            <select name="filter" class="form-select form-select-sm"
                                    style="width:120px;background:#fff;color:#333;border-radius:6px;"
                                    onchange="this.form.submit()">
                                <option value="All"       {{ $filter == 'All'       ? 'selected' : '' }}>All Status</option>
                                <option value="Pending"   {{ $filter == 'Pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="Completed" {{ $filter == 'Completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            <select name="priority" class="form-select form-select-sm"
                                    style="width:130px;background:#fff;color:#333;border-radius:6px;"
                                    onchange="this.form.submit()">
                                <option value="All"    {{ $priority == 'All'    ? 'selected' : '' }}>All Priority</option>
                                <option value="High"   {{ $priority == 'High'   ? 'selected' : '' }}>High</option>
                                <option value="Medium" {{ $priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="Low"    {{ $priority == 'Low'    ? 'selected' : '' }}>Low</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($tasks->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p class="mb-0">No tasks found. Add your first task!</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Due Date</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $i => $task)
                                    <tr class="{{ $task->status === 'Completed' ? 'completed-row' : '' }}">
                                        <td class="text-muted fw-semibold">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ $task->title }}</div>
                                            @if($task->description)
                                                <small class="text-muted">{{ Str::limit($task->description, 45) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-muted">
                                            {{ $task->due_date ? $task->due_date->format('d M Y') : '—' }}
                                        </td>
                                        <td>
                                            @php $p = $task->priority; @endphp
                                            <span class="badge badge-{{ strtolower($p) }}">{{ $p }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ strtolower($task->status) }}">
                                                {{ $task->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <!-- Toggle Status -->
                                                <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="btn-action btn-toggle"
                                                            title="{{ $task->status === 'Pending' ? 'Mark Completed' : 'Mark Pending' }}">
                                                        <i class="fas {{ $task->status === 'Pending' ? 'fa-check' : 'fa-undo' }}"></i>
                                                    </button>
                                                </form>
                                                <!-- Edit -->
                                                <a href="{{ route('tasks.edit', $task) }}"
                                                   class="btn-action btn-edit" title="Edit Task">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <!-- Delete -->
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                      onsubmit="return confirm('Delete this task?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" title="Delete Task">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div><!-- /row -->
</div>
@endsection