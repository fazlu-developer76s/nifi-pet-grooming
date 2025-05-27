@extends('layouts/app')
@section('content')
    @if (isset($get_tshirt))
        @php $form_action = "tshirt.update" @endphp
    @else
        @php $form_action = "tshirt.create" @endphp
    @endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">T-Shirt</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create T-Shirt</li>
                    </ol>
                    <h1 class="page-header mb-0">T-Shirt</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add T-Shirt
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ isset($get_tshirt) ? $get_tshirt->id : '' }}"
                                name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text"
                                                name="title" placeholder="Enter Title"
                                                value="@if (empty($get_tshirt)) {{ old('title') }} @else {{ isset($get_tshirt) ? $get_tshirt->title : '' }} @endif" />
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Image</label>
                                            <input class="form-control @error('image') is-invalid @enderror" type="file"
                                                name="image" />
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (isset($get_tshirt->image))
                                            <img src="{{ Storage::url($get_tshirt->image) }}" alt=""
                                                class="img-fluid" style="max-width: 80px; height: auto;" />
                                            <input type="hidden" name="hidden_image" value="{{ $get_tshirt->image }}">
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Small Size</label>
                                            <input class="form-control @error('s') is-invalid @enderror" type="text"
                                                name="s" placeholder="Enter s"
                                                value="{{ old('s', $get_tshirt->s ?? '') }}" />
                                            @error('s')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Medium Size</label>
                                            <input class="form-control @error('m') is-invalid @enderror" type="text"
                                                name="m" placeholder="Enter m"
                                                value="{{ old('m', $get_tshirt->m ?? '') }}" />
                                            @error('m')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Large Size</label>
                                            <input class="form-control @error('l') is-invalid @enderror" type="text"
                                                name="l" placeholder="Enter l"
                                                value="{{ old('l', $get_tshirt->l ?? '') }}" />
                                            @error('l')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">XL Size</label>
                                            <input class="form-control @error('xl') is-invalid @enderror" type="text"
                                                name="xl" placeholder="Enter xl"
                                                value="{{ old('xl', $get_tshirt->xl ?? '') }}" />
                                            @error('xl')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">XXL Size</label>
                                            <input class="form-control @error('xxl') is-invalid @enderror" type="text"
                                                name="xxl" placeholder="Enter xxl"
                                                value="{{ old('xxl', $get_tshirt->xxl ?? '') }}" />
                                            @error('xxl')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select
                                                class="form-control custom-select-icon @error('status') is-invalid @enderror"
                                                name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}
                                                    {{ isset($get_tshirt) && $get_tshirt->status == 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}
                                                    {{ isset($get_tshirt) && $get_tshirt->status == 2 ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                                placeholder="Enter description">{{ old('description', $get_tshirt->description ?? '') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="col-md-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center"
                            style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            T-Shirt List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">#</th>
                                        <th class="text-nowrap">Image</th>
                                        <th class="text-nowrap">Title</th>
                                        <th class="text-nowrap">S</th>
                                        <th class="text-nowrap">M</th>
                                        <th class="text-nowrap">L</th>
                                        <th class="text-nowrap">XL</th>
                                        <th class="text-nowrap">XXL</th>
                                        <th class="text-nowrap">Description</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($alltshirt)
                                        @foreach ($alltshirt as $category)
                                            <tr class="odd gradeX">
                                                <td class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ Storage::url($category->image) }}" alt=""
                                                        class="img-fluid" style="max-width: 80px; height: auto;" />
                                                </td>
                                                <td>{{ $category->title }}</td>
                                                <td>{{ $category->s ?? '-' }}</td>
                                                <td>{{ $category->m ?? '-' }}</td>
                                                <td>{{ $category->l ?? '-' }}</td>
                                                <td>{{ $category->xl ?? '-' }}</td>
                                                <td>{{ $category->xxl ?? '-' }}</td>
                                                <td>{{ $category->description ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d F Y h:i A') }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckDefault{{ $category->id }}"
                                                            {{ $category->status == 1 ? 'checked' : '' }}
                                                            onchange="ChangeStatus('t_shirt', {{ $category->id }});">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('tshirt.edit', $category->id) }}"
                                                        class="text-primary me-2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tshirt.destroy', $category->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0"
                                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
