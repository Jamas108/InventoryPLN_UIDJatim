@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container mt-4">
                <div class="card shadow">
                    <div class="card-header text-white" style="background-color: rgb(1, 1, 95);">
                        <h4>Edit User Role</h4>
                    </div>
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        <div class="form-group m-4">
                            <label for="role">Role</label>
                            <select name="role_id" id="role" class="form-control">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $user->Id_Role ? 'selected' : '' }}>
                                        {{ $role->Nama_Role_Users }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                Back
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
