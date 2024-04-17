@extends('employees.layout')

@section('content')
    <style>
        .w-5 {
            display: none;
        }
    </style>

    <!-- Search Form -->
    <form action="{{ route('employees.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

   
        <tbody>
            @foreach($employees as $employee)
            <tr>
                
                <!-- Add more columns as needed -->
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Employee CRUD </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('employees.create') }}"> Create New Employee</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Position</th>
            <th>Image</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($employees as $employee)
        <tr>
            <td>{{ ++$startIndex }}</td>
            <td>{{ $employee->fname }}</td>
            <td>{{ $employee->lname }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->telephone }}</td>
            <td>{{ $employee->position }}</td>
            <td><img src="/image/{{ $employee->image }}" width="100px"></td>
            <td>
                <form action="{{ route('employees.destroy',$employee->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('employees.show',$employee->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('employees.edit',$employee->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <span> {{$employees->links()}}</span>
   
@endsection
