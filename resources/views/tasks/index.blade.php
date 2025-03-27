<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('todo list') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
<div class="main">
    <div class="container">
        <h1>{{ __('todo list') }}</h1>

        <div class="input-container">
            <input type="text" id="newTodo" placeholder="{{ __('enter a new task') }}" />
            <input type="hidden" id="userId" value="{{ auth()->id() }}" />
        </div>
        <div class="input-container">
            <input type="text" id="newDescription" placeholder="{{ __('enter a description') }}" />
        </div>

        <button onclick="addTodo()">{{ __('add') }}</button>

        <ul class="todos" id="todos">
            @forelse($tasks as $task)
                <li class="todo {{ $task->status == 'completed' ? 'active' : '' }}" onclick="toggleTodo('{{ $task->id }}', this)">
                    <span>{{ $task->name }}</span>

                    <div class="tooltip">
                        <strong>Açıklama:</strong> {{ $task->description ?? 'Açıklama yok' }}<br><br>
                        <strong>Kullanıcı:</strong> {{ $task->user->name ?? 'Bilinmiyor' }}
                    </div>

                    <a class="remove-btn" onclick="removeTodo('{{ $task->id }}', this, event)">{{ __('remove') }}</a>
                </li>
            @empty
            @endforelse


        </ul>

        <div class="pagination-container">
            {{ $tasks->links() }}
        </div>

    </div>

</div>

<script src="{{ asset("script.js") }}"></script>
</body>

</html>
