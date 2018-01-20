<?php

class DashboardController extends BaseController {

    // Dashboard index action
    public function indexAction()
    {
        // Такой код создаст дополнительный лишний запрос в бд.
     //   $user = User::find(Auth::user()->id);

        if (Auth::user()->role == 'admin') {
            return View::make('adminDashboard', [
                'userData' => $user
            ]);
        } else if (Auth::user()->role  == 'manager') {
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
     
            
        // Если будет много задач, данный код будет плохо работать, нужно использовать отношения
        // belongs to в модели User а также with 
        // Пример Users::where('id','<>', 0)->with('tasks')->get(); даст 2 запроса в БД
        // Ваш код даст 1 * N юзеров...   
            
            foreach ($users as $item) {
                $item->tasks = Task::where('user_id', $item->id)->count();

            }
            return View::make('usersDashboard', [
                'userData' => $user, // Тоже лишнее как и писал выше, есть для этого Auth::user он доступен в блайде
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
    // Когда роутов будет много все это дело обрабывать одним котроллером не правльно.
    // для этого и сущевует get и post
    // Например роуты ниже нужно писать вот так postAdduser postDeleteuser ... 
    // тогда конструкци свитч вообще не нужна
    
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
        
                // Здесь не есть оишбка, но Laravel есть хороший валидатор  https://laravel.com/docs/4.2/validation
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
        
                // Для ajax опять же правльнее возвращать вот так
                // return Response::json(array('code' => "1", 'message'=> 'Success save data'), 200);
                // в наших проектах мы используем всегда стандарт 
                //  return Response::json(array('success' => "true"), 200); Для успешного
                //  return Response::json(array('success' => "false" ,'error'=>'Ошибка'), 200); Для ошибки
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
                    // Цикл здесь лишний, удалять всех юзеров можно 1 строкой просто выборкой,
                    // Файлы удалять с севрера, можно было наверно лучше создав папку с ид юзера и просто удалять ее
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
        
        // В некторых случаях важна првоерка на xss и других атак 
        // Но загрузку файло всегда желательно проверять хотябы валидатором.
        $file = Input::file('taskFile');
        $userId = Input::get('newTaskUserId');
        $title = Input::get('newTaskTitle');

        $task = new Task;
        $task->title = $title;
        $task->user_id = $userId;
        $task->save();
        
        // Здесь уже обсуждали насчет расширения ранее
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

