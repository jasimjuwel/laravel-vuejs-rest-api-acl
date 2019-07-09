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
    <h2>Edit Profile</h2>
        <form action="{{ url('api/api-user-update/'.$data->id) }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="user_name">Email:</label>
                <input type="text" value="{{ $data->user_name }}" class="form-control" id="user_name" placeholder="Enter User Name" name="user_name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" value="{{ $data->email }}" class="form-control" id="email" placeholder="Enter Email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Re-Type Password:</label>
                <input type="password" class="form-control" id="password_confirmation" placeholder="Enter Re-Type Passwo" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-default">Update Profile</button>
        </form>
</div>
​
</body>
</html>
​

