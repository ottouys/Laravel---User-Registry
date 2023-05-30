<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>User Listing</title>

        

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <!-- Bootstrap styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Styles -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
    </head>
    <body class="antialiased">
        <div id="intro-header" class="bg-dark text-secondary px-4 py-5 text-center" style="background-image: url({{asset('assets/img/home-slice-background-1.png')}})">
            <div class="py-5">
            <h1 class="display-5 fw-bold text-white">User Listing</h1>
            
            </div>
        </div>

        <div class="container py-3">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#AddNewUserModal">Add new user</button>
                </div>
            </div>
            <div id="userLoader" class="row">
                <img src="{{asset('assets/img/loading-gif.gif')}}" alt="" srcset="">
            </div>
            {{-- Dynamiclly populated --}}
            <div id="user-listing" class="row py-3"></div>
        </div>

        <footer id="footer" class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">            

            <div class="max-w-7xl mx-auto p-6 lg:p-8">   
                <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">   
                    <div class="ml-4 text-center text-sm text-gray-500 text-white sm:text-right sm:ml-0">
                        Copyright User Listing App
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <div class="modal fade" id="AddNewUserModal" tabindex="-1" role="dialog" aria-labelledby="AddNewUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddNewUserModalLabel">Add new user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="post" action="/add-user">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @else is-valid @enderror" placeholder="Enter your name" required>
                            @error('name')
                                <div class="alert alert-danger">Please enter your name</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @else is-valid @enderror" placeholder="Enter your surname" required>
                            @error('surname')
                                <div class="alert alert-danger">Please enter your surname</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @else is-valid @enderror" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input id="position" type="text" class="form-control @error('position') is-invalid @else is-valid @enderror" placeholder="Enter your position" required>
                            @error('position')
                                <div class="alert alert-danger">Please enter your position</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p id="addUsermessage"></p>
                        </div>
                        <button type="submit" class="btn btn-dark">Add user</button>
                    </form>
                    
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark">Save changes</button>
                </div> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="DeleteUserModal" tabindex="-1" role="dialog" aria-labelledby="DeleteUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteUserModalLabel">Please confirm that you would like to delete this user.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteUserForm" method="post" action="/delete-user">
                        @csrf
                        <input id="userId" type="hidden" value="">                        
                        <div class="form-group">
                            <p id="deleteUsermessage"></p>
                        </div>
                        <button type="submit" class="btn btn-dark">Delete User</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark">Save changes</button>
                </div> --}}
                </div>
            </div>
        </div>

        {{-- Boostrap scripts --}}
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
        
        {{-- Iconic Icons --}}
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
