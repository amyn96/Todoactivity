
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT Todo List</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
</head>
<style>
.blue-color {
color:blue;
}
.green-color {
color:green;
}
.teal-color {
color:teal;
}
.yellow-color {
color:yellow;
}
.red-color {
color:red;
}
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('To-Do-List') }}
        </h2>
    </x-slot>

    <!--Add Task -->
    <div class="container w-30 mt-5">
        <div class="card shadow-sm">
            <div class="card-body shadow-md">
                <h3>EDIT To-do-List</h3>
                <form action="{{ url('/edittask') }}/{{ $todolists[0]->id  }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="Add your new todo" value="{{ $todolists[0]->content }}">
                        <button type="submit" class="btn btn-dark btn-sm px-4"><i class="fas fa-edit"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <!--end list-->


</x-app-layout>
</html>
