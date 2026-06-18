@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Comments</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Comments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
                    <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Comments Table</h3>
                    <div class="d-flex align-items-center  justify-content-between">
                        @if(request()->has('postId') && request()->get('postId'))
                            <span class="badge bg-info me-3">Filtered by Post</span>
                        @endif
                    </div>
                    <a href="{{ route('comments.index') }}" class="btn btn-outline-secondary ms-auto btn-sm me-2">View All</a>
                </div>

                <div class="card-body">
                    <table id="commentsTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Post</th>
                                <th>Comment</th>
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

<div class="modal fade" id="viewCommentModal" tabindex="-1" aria-labelledby="viewCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCommentModalLabel">Comment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Name:</strong>
                        <span id="commenterName" class="d-block mt-1"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong>
                        <span id="commenterEmail" class="d-block mt-1"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Post:</strong>
                        <span id="commenterPost" class="d-block mt-1"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Date:</strong>
                        <span id="commentDate" class="d-block mt-1"></span>
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Comment:</strong>
                        <div id="fullComment" class="mt-2 p-3 bg-light rounded"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <div id="modalStatusButtons" class="d-inline-block">
                    <!-- Status update buttons will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

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
        // Initialize DataTable with AJAX
        var table = $('#commentsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('comments.index') }}",
                "type": "GET",
                "data": function(d) {
                    @if(request()->has('postId') && request()->get('postId'))
                        d.postId = "{{ request()->get('postId') }}";
                    @endif
                }
            },
            "columns": [
                {
                    "data": "name_formatted",
                    "name": "name_formatted",
                    "orderable": true,
                    "searchable": true
                },
                {
                    "data": "email_formatted",
                    "name": "email_formatted",
                    "orderable": true,
                    "searchable": true
                },
                {
                    "data": "post_title",
                    "name": "post_title",
                    "orderable": true,
                    "searchable": true,
                     "render": function(data, type, row) {
                        if (!data) return '';
                        const truncated = data.length > 40 ? data.substring(0, 40) + '...' : data;
                        const formattedTitle = truncated.charAt(0).toUpperCase() + truncated.slice(1);
            
                        return '<a href="/admin/posts/' + row.post_id +
                        '"class="text-primary text-decoration-none" ' +
                        'title="View ' + data + '" ' +
                        'data-bs-toggle="tooltip" data-bs-placement="top">' +
                        
                        formattedTitle +
                        '</a>';
                    }
                },
                {
                    "data": "comment_preview",
                    "name": "full_comment",
                    "orderable": false,
                    "searchable": true,
                    "render": function(data, type, row) {
                        return data || '';
                    }
                },
                {
                    "data": null,
                    "name": "status_badge",
                    "orderable": true,
                    "searchable": true,
                       "className": "text-center",
                    "render": function(data, type, row) {
                        return row.status_badge + row.status_dropdown;
                    }
                },
                {
                    "data": "created_at_formatted",
                    "name": "created_at_formatted",
                    "orderable": true
                },
                {
                    "data": "action",
                    "name": "action",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
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
                "zeroRecords": "No comments found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "search": "Search:",
                "searchPlaceholder": "Search comments...",
                "paginate": {
                    "first": '<i class="bi bi-chevron-double-left"></i>',
                    "last": '<i class="bi bi-chevron-double-right"></i>',
                    "next": '<i class="bi bi-chevron-right"></i>',
                    "previous": '<i class="bi bi-chevron-left"></i>'
                }
            },
            
        });       
    });

    var currentCommentId = null;
    var currentCommentStatus = null;

    function viewFullComment(id, name, comment) {
        currentCommentId = id;
        
        // Get additional comment details via AJAX
        $.ajax({
            url: "{{ url('admin/comments') }}/" + id,
            type: "GET",
            success: function(response) {
                document.getElementById('commenterName').textContent = response.name || name;
                document.getElementById('commenterEmail').textContent = response.email || '';
                document.getElementById('commenterPost').textContent = response.post_title || 'Unknown Post';
                document.getElementById('commentDate').textContent = response.created_at_formatted || '';
                document.getElementById('fullComment').textContent = response.full_comment || comment;
                
                // Store current status
                currentCommentStatus = response.status || 0;
                
                // Add status update buttons to modal footer
                var statusButtons = `
                    <button type="button" class="btn btn-warning btn-sm" onclick="updateStatusFromModal(${id}, 0)" ${currentCommentStatus == 0 ? 'disabled' : ''}>
                        <i class="bi bi-clock"></i> Set Pending
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="updateStatusFromModal(${id}, 1)" ${currentCommentStatus == 1 ? 'disabled' : ''}>
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="updateStatusFromModal(${id}, 2)" ${currentCommentStatus == 2 ? 'disabled' : ''}>
                        <i class="bi bi-x-circle"></i> Reject
                    </button>
                `;
                
                document.getElementById('modalStatusButtons').innerHTML = statusButtons;
            },
            error: function() {
                // Fallback to basic data if AJAX fails
                document.getElementById('commenterName').textContent = name;
                document.getElementById('fullComment').textContent = comment;
            }
        });
    }
    
    function updateStatusFromModal(commentId, status) {
        updateStatus(commentId, status, true);
    }

    function updateStatus(commentId, status, closeModal = false) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to change the comment status?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/comments/update-status') }}/" + commentId,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reload DataTable to reflect changes
                            $('#commentsTable').DataTable().ajax.reload();
                            
                            // Close modal if update was initiated from modal
                            if (closeModal) {
                                $('#viewCommentModal').modal('hide');
                            }
                            
                            // Show success message
                            let statusText = '';
                            switch (status) {
                                case 0: statusText = 'Pending'; break;
                                case 1: statusText = 'Approved'; break;
                                case 2: statusText = 'Rejected'; break;
                            }
                            
                            Swal.fire(
                                'Updated!',
                                'Comment status changed to ' + statusText,
                                'success'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function deleteComment(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: "{{ url('admin/comments/delete') }}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(function(response) {
                    if (!response.success) {
                        throw new Error(response.message || 'Failed to delete comment');
                    }
                    return response;
                }).catch(function(error) {
                    Swal.showValidationMessage(
                        'Request failed: ' + error.message
                    );
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // Reload DataTable
                $('#commentsTable').DataTable().ajax.reload();
                
                Swal.fire(
                    'Deleted!',
                    'Comment deleted successfully.',
                    'success'
                );
            }
        });
    }
</script>


@endsection