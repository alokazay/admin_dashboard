<?php

class DashboardController extends BaseController {

    // Dashboard index action
    public function indexAction()
    {
        $user = User::find(Auth::user()->id);

        if ($user->role == 'admin') {
            return View::make('adminDashboard', [
                'userData' => $user
            ]);
        } else if ($user->role == 'manager') {
            return View::make('managerDashboard', [
                'userData' => $user
            ]);
        } else {
            Auth::logout();
            return Redirect::to('/');
        }

    }

    public function usersAction()
    {
        $user = User::find(Auth::user()->id);
        if ($user->role == 'admin') {
            $users = User::all();
            foreach ($users as $item) {
                $item->tasks = Task::where('user_id', $item->id)->count();

            }
            return View::make('usersDashboard', [
                'userData' => $user,
                'usersData' => $users
            ]);

        } else {
            return Redirect::to('/dashboard');
        }
    }

    public function tasksAction()
    {
        $user = User::find(Auth::user()->id);
        if ($user->role == 'manager') {
            $tasks = Task::where('user_id', $user->id)->get();
            return View::make('tasksDashboard', [
                'userData' => $user,
                'tasksData' => $tasks
            ]);

        } else {
            return Redirect::to('/dashboard');
        }
    }

    // Ajax request action    
    public function ajaxAction()
    {
        $action = Input::get('action');
        switch ($action) {

            // Add new user action
            case 'addNewUser':
                $login = Input::get('login');
                $password = Input::get('password');
                $role = Input::get('role');
                $_token = Input::get('_token');
        
                if (!$_token) {
                    return [
                        'code' => 0,
                        'message' => 'Ошибка сохранения данных'
                    ];
                }
        
                if ($login == '' || $password == '' || $role == '') {
                    return [
                        'code' => 0,
                        'message' => 'Заполните все необходимые поля'
                    ];
                }
        
                if (User::where('user_login', $login)->count() > 0) {
                    return [
                        'code' => 0,
                        'message' => 'Пользователь с таким логином уже существует'
                    ];
                }
        
                $user = new User;
                $user->user_login = $login;
                $user->role = $role;
                $user->password = Hash::make($password);
                $user->save();
        
                return [
                    'code' => 1,
                    'message' => 'Success save data'
                ];
                exit;
                // No break;
            
            // Delete user data
            case 'deleteUserData':
                $userId = Input::get('id');
                $tasks = Task::where('user_id', $userId)->get();
                foreach ($tasks as $task) {
                    File::delete('uploads/tasks/'.$task->file_name);
                    Task::where('id', $task->id)->delete();
                }
                User::where('id', $userId)->delete();
                return [
                    'code' => 1,
                    'message' => 'Success deleting data'
                ];
                exit;
                // No break
            
            default:
                break;
        }
        return [
            'code' => 0,
            'message' => 'Ошибка сохранения данных'
        ];
    }

    // Add task action
    public function addTaskAction()
    {
        $file = Input::file('taskFile');
        $userId = Input::get('newTaskUserId');
        $title = Input::get('newTaskTitle');

        $task = new Task;
        $task->title = $title;
        $task->user_id = $userId;
        $task->save();
        
        $task->file_name = 'task_'.$task->id.'.txt';
        $task->save();

        if ($title == '') {
            $task->title = 'task_'.$task->id;
            $task->save();
        }

        $fileSaveSuccess = $file->move('uploads/tasks', 'task_'.$task->id.'.txt');

        if ($fileSaveSuccess) {
            return [
                'code' => 1,
                'message' => 'Success save data'
            ];
        } else {
            return [
                'code' => 0,
                'message' => 'Error save data'
            ];
        }
    }
}

