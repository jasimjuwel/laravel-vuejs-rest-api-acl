<!DOCTYPE html>
<html lang="en">
<head>
    <title>Demo | User List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{!! asset('assets/bower_components/font-awesome/css/font-awesome.min.css') !!}">
</head>
<body>
​
<div class="container">
    <h2>User List</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>SL</th>
            <th>Photo</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($userList) && count($userList) > 0)
            @foreach($userList as $key=>$row)
                <tr class="{{ $row['id'] }}">
                    <td>{{ ($key+1) }}</td>
                    <td><img src="{!! $row['user_photo'] !!}" style="width:40px; height:40px; border-radius: 100px; margin-top: -6px"></td>
                    <td>{{ $row['user_name'] }}</td>
                    <td>{{ $row['email'] }}</td>
                    <td>@if(isset($row['role']['role_name'])) {{ $row['role']['role_name'] }} @endif</td>
                    <td>
                        @if($row['status'] == 1)
                            <span  class="badge badge-pill badge-success">Active</span>
                        @else
                            <span  class="badge badge-pill badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ URL::to('api/api-user-edit/'.$row['id']) }}" class="btn btn-success btn-xs" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">No Data Available.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
</body>
</html>
​

