<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            margin-top: 10px;
            display: block;
            font-weight: bold;
        }
        input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px; /* Add margin for the done button */
        }
        button:hover {
            background: #0056b3;
        }
        #response {
            margin-top: 20px;
            color: green;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #e9ecef;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
        }
        li:hover {
            background: #d4d4d4; 
        }
        .task-details {
            font-size: 14px;
            color: #333; 
            margin-top: 5px; 
        }
        .task-name {
            font-weight: bold; 
            font-size: 16px;
            margin-bottom: 5px; 
        }
        .task-info {
            margin-top: 5px; 
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Task Manager</h2>
    
    <label for="taskName">Task Name</label>
    <input type="text" id="taskName" placeholder="Enter task name" required>
    
    <label for="startDate">Start Date</label>
    <input type="date" id="startDate" required>
    
    <label for="endDate">End Date</label>
    <input type="date" id="endDate" required>
    
    <button id="addTask">Add Task</button>
    
    <div id="response"></div>
    
    <ul id="taskList"></ul>
</div>

<script>
    document.getElementById('addTask').addEventListener('click', function() {
        var taskName = document.getElementById('taskName').value.trim();
        var startDate = document.getElementById('startDate').value.trim();
        var endDate = document.getElementById('endDate').value.trim();

        if (taskName === '' || startDate === '' || endDate === '') {
            alert("Please fill in all fields!");
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_task.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('response').innerText = response.message;
                if (response.success) {
                    addTaskToList(taskName, startDate, endDate);
                    document.getElementById('taskName').value = ''; 
                    document.getElementById('startDate').value = ''; 
                    document.getElementById('endDate').value = ''; 
                }
            }
        };

        xhr.send('taskName=' + encodeURIComponent(taskName) + 
                 '&startDate=' + encodeURIComponent(startDate) + 
                 '&endDate=' + encodeURIComponent(endDate));
    });

    function addTaskToList(taskName, startDate, endDate) {
        var taskList = document.getElementById('taskList');
        var li = document.createElement('li');

        var doneButton = document.createElement('button');
        doneButton.innerText = 'Done';
        doneButton.style.background = '#28a745'; 
        doneButton.style.marginLeft = '10px'; 
        doneButton.onclick = function() {
            taskList.removeChild(li);
        };

        li.innerHTML = `<span class="task-name">${taskName}</span>
                        <div class="task-info">
                            <span class="task-details">Start: ${startDate}</span><br>
                            <span class="task-details">End: ${endDate}</span>
                        </div>`;
        li.appendChild(doneButton); 
        taskList.appendChild(li);
    }
</script>

</body>
</html>
