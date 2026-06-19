@extends("admin.admin_dashboard")

@section("admin")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="page-breadcrumb permission-import-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Import Permission</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:;" class="permission-key-link" aria-label="Permission">
                                <i class="bx bx-key"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('export.permission') }}"
                                class="btn permission-download-btn"><i class="bx bx-export"></i>
                                Export Excel</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('import') }}" class="row g-3" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="import_file" class="form-label">Import File</label>
                        <input type="file" id="import_file" name="import_file" class="form-control">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">Upload</button>
                        <a href="{{ route('all.permission') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .permission-import-breadcrumb .breadcrumb {
            align-items: center;
        }

        .permission-import-breadcrumb .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .permission-key-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.1);
            border: 1px solid rgba(13, 110, 253, 0.18);
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .permission-key-link:hover {
            color: #fff;
            background: #0d6efd;
            border-color: #0d6efd;
        }

        .permission-key-link i {
            font-size: 18px;
            line-height: 1;
        }

        .permission-download-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 38px;
            padding: 8px 18px;
            color: #1f2937;
            font-weight: 500;
            line-height: 1;
            background: #ffc107;
            border: 1px solid #f2b600;
            border-radius: 7px;
            box-shadow: 0 6px 14px rgba(255, 193, 7, 0.22);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .permission-download-btn:hover {
            color: #111827;
            background: #ffca2c;
            border-color: #ffc720;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(255, 193, 7, 0.28);
        }

        .permission-download-btn i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            line-height: 1;
        }
    </style>
@endsection