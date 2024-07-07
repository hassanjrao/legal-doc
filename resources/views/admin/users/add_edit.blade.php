@extends('layouts.backend')


@php
    $addEdit = isset($user) ? 'Edit' : 'Add';
    $addUpdate = isset($user) ? 'Update' : 'Add';
@endphp

@section('page-name', $addEdit . ' User')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">

        <div class="container-fluid">

            <div class="row">
                <div class="card custom-card">
                    <div class="card-header ">
                        <div class="card-title d-flex justify-content-between w-100">
                            <span>{{ $addEdit }} User</span>

                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">All</a>
                        </div>
                    </div>
                    <div class="card-body align-items-center">

                        @if ($user)
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="row g-3 mt-0"
                                enctype="multipart/form-data">

                                @csrf
                                @method('PUT')
                            @else
                                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
                                    class="row g-3 mt-0">

                                    @csrf
                        @endif
                        <div class="col-md-6">
                            <?php
                            $value = old('role', $user ? $user->roles->pluck('name')->first() : null);
                            ?>
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @if ($role->name == $value) selected @endif>
                                        {{ ucwords($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <?php
                            $value = old('name', $user ? $user->name : null);
                            ?>

                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $value }}" required>
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <?php
                            $value = old('email', $user ? $user->email : null);
                            ?>

                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $value }}" required>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- verified switch --}}

                        <div class="col-md-6 mt-4">
                            <?php
                            $value = old('verified', $user ? $user->email_verified_at : null);
                            ?>
                            <label class="form-label">Email Verified</label>

                            <div class="form-check form-check-lg form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="emailVeri" name="verified"
                                    {{ $value ? 'checked=""' : '' }}>
                                <label class="form-check-label" for="emailVeri" name="verified">Verified</label>
                            </div>


                        </div>


                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
