@extends('admin/app')
@section('content')

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Categories</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Categories Table</h3>
                    <a href="{{route('categories.create')}}" class="btn btn-primary ms-auto">Add New</a>
                </div>


                <div class="card-body">
                    <table id="categoriesTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $category)
                            <tr class="align-middle">
                                <td>{{ $index + 1 }}</td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <img src="{{asset('assets/categories/'.$category->image)}}" width="80" height="80" style="object-fit: cover;" alt="{{$category->name}}">
                                </td>
                                <td>
                                    @if($category->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    {{date('M j, Y', strtotime($category->created_at))}}
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{route('categories.edit', $category->id)}}" class="btn btn-sm btn-info me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" onclick="deleteCategory('{{$category->id}}')" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="align-middle">
                                <td colspan="6" class="text-center">No data found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</main>

@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#categoriesTable').DataTable({
            "responsive": true,
            "ordering": true,
            "searching": true,
            "paging": true,
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "order": [
                [4, 'desc']
            ],
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "zeroRecords": "No categories found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "search": "Search:",
               "paginate": {
                    "first": '<i class="bi bi-chevron-double-left"></i>',
                    "last": '<i class="bi bi-chevron-double-right"></i>',
                    "next": '<i class="bi bi-chevron-right"></i>',
                    "previous": '<i class="bi bi-chevron-left"></i>'
                }
            },
            "columnDefs": [{
                    "targets": [0], // Serial number column
                    "orderable": true,
                    "searchable": false
                },
                {
                    "targets": [2], // Image column
                    "orderable": false,
                    "searchable": false
                },
                {
                    "targets": [5], // Actions column
                    "orderable": false,
                    "searchable": false
                }
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "drawCallback": function(settings) {
                // Add any callback functions here if needed
            }
        });
        $('#categoriesTable_filter input').attr('placeholder', 'Search categories...');
    });

    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{url('admin/categories/delete')}}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message || "Category deleted successfully",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message || "Failed to delete category",
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred while deleting the category",
                            icon: "error"
                        });
                    }
                });
            }
        });
    }
</script>


@endsection