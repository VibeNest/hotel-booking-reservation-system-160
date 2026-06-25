@extends("admin.admin_dashboard")

@section("admin")

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        .permission-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.75rem rgba(0, 0, 0, .08);
        }

        .permission-card .card-header {
            background: linear-gradient(45deg, #0d6efd, #3d8bfd);
            color: #fff;
            border: none;
            padding: 1rem 1.5rem;
        }

        .group-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            transition: all .3s ease;
        }

        .group-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .08);
        }

        .group-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .permission-item {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            height: 100%;
            transition: all .3s ease;
            background: #fff;
        }

        .permission-item:hover {
            border-color: #0d6efd;
            background: #f8fbff;
            transform: translateY(-2px);
        }

        .permission-item .form-check {
            margin-bottom: 0;
        }

        .form-check-input {
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
            user-select: none;
            text-transform: capitalize;
        }

        .role-select {
            max-width: 500px;
        }

        .all-permission-box {
            background: #f8fbff;
            border: 1px solid #cfe2ff;
            border-radius: 10px;
            padding: 15px 20px;
        }

        .group-badge {
            font-size: 13px;
            padding: 6px 12px;
        }

        .action-buttons {
            border-top: 1px solid #e9ecef;
            padding-top: 20px;
        }
    </style>

    <div class="page-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-4">
            <div class="breadcrumb-title pe-3 fw-semibold">
                Add Role In Permission
            </div>

            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;">
                                <i class="bx bx-shield-quarter"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Role In Permission
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card permission-card">

            <div class="card-header">
                <h5 class="mb-0 text-white">
                    <i class="bx bx-user-plus me-2"></i>
                    Assign Permissions To Role
                </h5>
            </div>

            <div class="card-body p-4">

                <form method="POST" action="{{ route('role.permission.store') }}">
                    @csrf

                    <!-- Role Select -->
                    <div class="row mb-4">
                        <div class="col-md-6 role-select">

                            <label for="role_id" class="form-label fw-bold">
                                <i class="bx bx-user-circle me-1"></i>
                                Select Role
                            </label>

                            <select name="role_id" id="role_id" class="form-select">

                                <option selected disabled>
                                    Choose a Role
                                </option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>
                    </div>

                    <!-- Select All -->
                    <div class="all-permission-box mb-4">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="CheckDefaultMain">

                            <label class="form-check-label fw-bold text-primary" for="CheckDefaultMain">

                                <i class="bx bx-check-double me-1"></i>
                                Select All Permissions

                            </label>
                        </div>

                    </div>

                    <!-- Permission Groups -->
                    @foreach ($permission_groups as $group)

                        <div class="group-card mb-4">

                            <!-- Group Header -->
                            <div class="group-header">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" id="group_{{ $loop->index }}">

                                    <label class="form-check-label fw-bold" for="group_{{ $loop->index }}">
                                        <span class="badge bg-primary group-badge me-2">
                                            {{ $loop->iteration }}
                                        </span>
                                        {{ ucfirst($group->group_name) }}
                                    </label>
                                </div>
                            </div>

                            <!-- Group Body -->
                            <div class="p-3">
                                @php
                                    $permissions = App\Models\User::getPermissonByGroupName($group->group_name);
                                @endphp

                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                            <div class="permission-item">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $permission->id }}"
                                                        id="{{ $permission->id }}" name="permission[]">
                                                    <label class="form-check-label" for="{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Buttons -->
                    <div class="action-buttons text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bx bx-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('#CheckDefaultMain').click(function () {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        })
    </script>
@endsection