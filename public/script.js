const todosContainer = document.getElementById('todos');
const newTodoInput = document.getElementById('newTodo');

function addTodo() {
    const newTodoText = document.getElementById('newTodo').value.trim();
    const newDescription = document.getElementById('newDescription').value.trim();
    const userId = document.getElementById('userId').value.trim();

    if (userId == null) {
        window.location.href = '/login';
        return;
    }

    fetch('/api/tasks', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: newTodoText,
            description: newDescription || null,
            'user_id': userId,
            status: 'pending'
        })
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(todo => {
            addTodoToDOM(todo);
            document.getElementById('newTodo').value = '';
            document.getElementById('newDescription').value = '';
        })
        .catch(error => {
            if (error.errors) {
                displayValidationErrors(error.errors);
            } else {
                console.error("Beklenmeyen hata:", error);
            }
        });
}

function displayValidationErrors(errors) {
    Object.keys(errors).forEach(key => {
        alert(errors[key][0])
    });
}


function addTodoToDOM(todo) {
    const li = document.createElement('li');
    li.className = 'todo';
    if (todo.active) li.classList.add('active');

    li.innerHTML = `
        <span>${todo.name}</span>
        <div class="tooltip">
            <strong>Açıklama:</strong> ${todo.description || 'Açıklama yok'}
            <br /><br />
            <strong>Kullanıcı:</strong> ${todo.user.name || 'Açıklama yok'}
        </div>
        <a class="remove-btn" onclick="removeTodo(${todo.id}, this)">Sil</a>
    `;

    li.addEventListener('click', () => toggleTodo(todo.id, li));
    document.getElementById('todos').appendChild(li);
}

function removeTodo(id, element, event) {
    event.stopPropagation();

    fetch(`/api/tasks/${id}`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        method: 'DELETE'
    })
        .then(response => {
            if (response.ok) {
                element.closest('.todo').remove();
            }
        })
        .catch(error => console.error('Hata:', error));
}

function toggleTodo(id, element) {
    const newStatus = element.classList.contains('active') ? 'pending' : 'completed';

    fetch(`/api/tasks/${id}`, {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        method: 'PATCH',
        body: JSON.stringify({ status: newStatus })
    })
        .then(response => response.json())
        .then(updatedTodo => {
            element.classList.toggle('active', updatedTodo.status === 'completed');
        })
        .catch(error => console.error('Hata:', error));
}

