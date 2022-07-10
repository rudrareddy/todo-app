<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Todo App') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" />

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
        <link rel="stylesheet" href="{{ asset('css/todo.css')}}" />

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" defer></script>
    </head>
    <body>
        <div class="container">
            <div class="row">

                <div class="col-12 pt-3">
                    <h1 class="text-white m-0">Todo App</h1>
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Success!</strong> {{ Session::get('success')}}.
                    </div>
                    @elseif(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Error!</strong> {{ Session::get('error')}}.
                    </div>
                    @endif
                   <form action="{{url('todo')}}" method="POST">
                     @csrf
                    <div class="input-group mt-4">
                        <input type="text" class="form-control" required name="todo_name" placeholder="Enter a task..." aria-label="Enter a task..." aria-describedby="button-addon2" />
                        <div class="input-group-append">
                            <button class="btn rounded-right btn-info border-left" type="submit" id="button-addon2">Add Todo</button>
                        </div>
                    </div>
                  </form>
                    <div class="mt-3">
                        <div class="dropdown-todo-items-all rounded-top">
                            <div class="d-flex justify-content-center align-items-center">
                                <button
                                    class="btn text-white border-0 bg-transparent w-100 py-3 pl-3 pr-4 d-flex justify-content-between align-items-center show-hide-toggle"
                                    data-toggle="collapse"
                                    href="#collapseExample"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="collapseExample"
                                >
                                    <span class="badge badge-info px-3 py-2">All</span>
                                    <i class="fas fa-chevron-down ml-auto"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="list-group todo-items-all collapse show rounded-bottom" id="collapseExample">
                          @foreach($todo_all as $all)
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                {{$all->todo_name}}
                                <div>
                                  @if($all->status == 0)
                                    <a href="{{url('todo/'.$all->uuid.'/edit')}}" class="btn border-0 bg-transparent">
                                        <i class="far fa-check-circle"></i>
                                    </a>
                                    @else
                                    <button class="btn border-0 bg-transparent">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </button>
                                    @endif
                                    <form action="{{url('todo/'.$all->uuid)}}" class="delete" method="POST">
                                                    {{ method_field('DELETE') }}{{csrf_field()}}
                                    <button type="submit" class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                  </form>
                                </div>
                            </li>
                            @endforeach
                            <!--<li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                Todo Item 2
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-check-circle"></i>
                                    </button>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                <span class="font-italic text-muted"><del>Todo Item 3</del></span>
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </button>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                Todo Item 4
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-check-circle"></i>
                                    </button>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </li>-->
                        </ul>
                    </div>

                    <div class="mt-3">
                        <div class="dropdown-todo-items-active rounded-top">
                            <div class="d-flex justify-content-center align-items-center">
                                <button
                                    class="btn text-white border-0 bg-transparent w-100 py-3 pl-3 pr-4 d-flex justify-content-between align-items-center show-hide-toggle"
                                    data-toggle="collapse"
                                    href="#collapseExample2"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="collapseExample"
                                >
                                    <span class="badge badge-info px-3 py-2">Active</span>
                                    <i class="fas fa-chevron-down ml-auto"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="list-group todo-items-active collapse show" id="collapseExample2">
                          @foreach($todo_incompleted as $todo)
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                {{$todo->todo_name}}
                                <div>
                                  <a href="{{url('todo/'.$todo->uuid.'/edit')}}" class="btn border-0 bg-transparent">
                                      <i class="far fa-check-circle"></i>
                                  </a>
                                  <form action="{{url('todo/'.$todo->uuid)}}" class="delete" method="POST">
                                                  {{ method_field('DELETE') }}{{csrf_field()}}
                                  <button type="submit" class="btn border-0 bg-transparent">
                                      <i class="far fa-trash-alt text-danger"></i>
                                  </button>
                                </form>
                                </div>
                            </li>
                            @endforeach
                            <!--<li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                Todo Item 2
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-check-circle"></i>
                                    </button>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                Todo Item 4
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-check-circle"></i>
                                    </button>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                </div>
                            </li>-->
                        </ul>
                    </div>

                    <div class="mt-3">
                        <div class="dropdown-todo-items-completed rounded-top">
                            <div class="d-flex justify-content-center align-items-center">
                                <button
                                    class="btn text-white border-0 bg-transparent w-100 py-3 pl-3 pr-4 d-flex justify-content-between align-items-center show-hide-toggle"
                                    data-toggle="collapse"
                                    href="#collapseExample3"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="collapseExample"
                                >
                                    <span class="badge badge-info px-3 py-2">Completed</span>
                                    <i class="fas fa-chevron-down ml-auto"></i>
                                </button>
                            </div>
                        </div>
                        <ul class="list-group todo-items-completed collapse show" id="collapseExample3">
                          @foreach($todo_completed as $todo)
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded-0 py-1 pr-2">
                                <span class="font-italic text-muted"><del>{{$todo->todo_name}}</del></span>
                                <div>
                                    <button class="btn border-0 bg-transparent">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </button>
                                    <form action="{{url('todo/'.$todo->uuid)}}" class="delete" method="POST">
                                                    {{ method_field('DELETE') }}{{csrf_field()}}
                                    <button type="submit" class="btn border-0 bg-transparent">
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </button>
                                  </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
