@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Posts</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Posts Table</h3>
                    <a href="{{route('posts.create')}}" class="btn btn-primary ms-auto">Add New</a>
                </div>

                <div class="card-body">
                    <table id="postsTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Featured Image</th>
                                <th>Comments</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#postsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('posts.index') }}",
                "type": "GET"
            },
            "columns": [{
                    "data": "title",
                    "name": "title",
                    "render": function(data, type, row) {
                        if (!data) return '';
                        const truncated = data.length > 40 ? data.substring(0, 40) + '...' : data;
                        const formattedTitle = truncated.charAt(0).toUpperCase() + truncated.slice(1);
            
                        return '<a href="/admin/posts/' + row.id +
                        '"class="text-primary text-decoration-none" ' +
                        'title="View ' + data + '" ' +
                        'data-bs-toggle="tooltip" data-bs-placement="top">' +
                        
                        formattedTitle +
                        '</a>';
                    }
                },
                {
                    "data": "category_name",
                    "name": "category.name",
                    "orderable": true
                },
                {
                    "data": "image",
                    "name": "featured_image",
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "comments_count",
                    "name": "comments_count",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "name": "status",
                    "render": function(data, type, row) {
                        return data ? data.charAt(0).toUpperCase() + data.slice(1) : '';
                    }
                },
                {
                    "data": "created_at_formatted",
                    "name": "created_at"
                },
                {
                    "data": "action",
                    "name": "action",
                    "orderable": false,
                    "searchable": false
                }
            ],
            "order": [
                [5, 'desc']
            ],
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "language": {
                "processing": "Processing...",
                "lengthMenu": "Show _MENU_ entries",
                "zeroRecords": "No posts found",
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
            }
        });
        $('#postsTable_filter input').attr('placeholder', 'Search posts...');
    });

    function deletePost(id) {
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
                    url: "{{url('admin/posts/delete')}}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire(
                            "Deleted!",
                            "Post deleted successfully",
                            "success"
                        ).then(() => {
                            // Reload the DataTable
                            $('#postsTable').DataTable().ajax.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            "Error!",
                            "Failed to delete post",
                            "error"
                        );
                    }
                });
            }
        });
    }
</script>
@endsection