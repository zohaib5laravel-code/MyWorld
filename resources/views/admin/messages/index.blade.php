@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Contact Messages</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Messages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Total Messages</h6>
                                    <h2 class="mb-0">{{ $totalMessages }}</h2>
                                </div>
                                <i class="bi bi-envelope display-6 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Unread Messages</h6>
                                    <h2 class="mb-0">{{ $unreadMessages }}</h2>
                                </div>
                                <i class="bi bi-envelope-exclamation display-6 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Read Messages</h6>
                                    <h2 class="mb-0">{{ $totalMessages - $unreadMessages }}</h2>
                                </div>
                                <i class="bi bi-envelope-open display-6 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Contact Messages</h5>
                    <div class="d-flex gap-2 ms-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-gear me-1"></i> Bulk Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="bulkAction('mark_read')"><i class="bi bi-check-circle me-2"></i> Mark as Read</a></li>
                                <li><a class="dropdown-item" href="#" onclick="bulkAction('mark_unread')"><i class="bi bi-circle me-2"></i> Mark as Unread</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')"><i class="bi bi-trash me-2"></i> Delete Selected</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshTable()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="messagesTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th width="20">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th>Read On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Messages Card -->
            @if($recentMessages->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Messages</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($recentMessages as $message)
                        <div class="list-group-item list-group-item-action {{ $message->status == 0 ? 'list-group-item-warning' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    {{ $message->name }}
                                    <small class="text-muted">({{ $message->email }})</small>
                                </h6>
                                <small>{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                <strong>{{ $message->subject }}</strong>
                            </p>
                            <p class="mb-1 text-muted">
                                {{ Str::limit(strip_tags($message->message), 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small>
                                    @if($message->status == 0)
                                    <span class="badge bg-warning">Unread</span>
                                    @else
                                    <span class="badge bg-success">Read</span>
                                    @endif
                                </small>
                                <a href="#" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewMessageModal" onclick="viewFullMessage({{ $message->id }})">
                                    View Message
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

<!-- View Message Modal -->
<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="messageLoading" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="messageContent" style="display: none;">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Name:</strong>
                                <p class="mb-0" id="modalName"></p>
                            </div>
                            <div class="mb-3">
                                <strong>Email:</strong>
                                <p class="mb-0" id="modalEmail"></p>
                            </div>
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <p class="mb-0" id="modalStatus"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Received:</strong>
                                <p class="mb-0" id="modalReceived"></p>
                            </div>
                            <div class="mb-3">
                                <strong>Last Read:</strong>
                                <p class="mb-0" id="modalRead"></p>
                            </div>
                            <div class="mb-3">
                                <strong>Device:</strong>
                                <p class="mb-0" id="modalDevice"></p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Subject:</strong>
                        <h6 class="mt-1" id="modalSubject"></h6>
                    </div>

                    <div class="mb-3">
                        <strong>Message:</strong>
                        <div class="p-3 bg-light rounded mt-2" id="modalMessage"></div>
                    </div>

                    <div class="mt-4">
                        <strong>Technical Info:</strong>
                        <div class="small text-muted mt-1">
                            <div>IP Address: <span id="modalIp"></span></div>
                            <div>User Agent: <span id="modalUserAgent"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="replyButton" onclick="replyToMessage()">
                    <i class="bi bi-reply me-1"></i> Reply via Email
                </button>
                <button type="button" class="btn btn-warning" id="toggleReadButton" onclick="toggleMessageStatus()">
                    <i class="bi bi-envelope me-1"></i> Mark as Unread
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with AJAX
        var table = $('#messagesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('messages.index') }}",
                "type": "GET"
            },
            "columns": [{
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row) {
                        return '<input type="checkbox" class="form-check-input select-checkbox" value="' + row.id + '">';
                    }
                },
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
                    "searchable": true,
                    "render": function(data, type, row) {
                        return '<a href="mailto:' + data + '" class="text-decoration-none">' + data + '</a>';
                    }
                },
                {
                    "data": "subject_formatted",
                    "name": "subject_formatted",
                    "orderable": true,
                    "searchable": true
                },
                {
                    "data": "message_preview",
                    "name": "message_preview",
                    "orderable": false,
                    "searchable": true
                },
                {
                    "data": "status_badge",
                    "name": "status_badge",
                    "orderable": true,
                    "searchable": true,
                    "className": "text-center"
                },
                {
                    "data": "created_at_formatted",
                    "name": "created_at_formatted",
                    "orderable": true
                },
                {
                    "data": "updated_at_formatted",
                    "name": "updated_at_formatted",
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
                [6, 'desc']
            ], 
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
          "language": {
                "processing": "Processing...",
                "lengthMenu": "Show _MENU_ entries",
                "zeroRecords": "No messages found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "search": "Search:",
                "searchPlaceholder": "Search messages...",
                "paginate": {
                    "first": '<i class="bi bi-chevron-double-left"></i>',
                    "last": '<i class="bi bi-chevron-double-right"></i>',
                    "next": '<i class="bi bi-chevron-right"></i>',
                    "previous": '<i class="bi bi-chevron-left"></i>'
                }
            },

            "drawCallback": function(settings) {
                // Update select all checkbox state
                var allChecked = $('.select-checkbox').length === $('.select-checkbox:checked').length;
                $('#selectAll').prop('checked', allChecked);
            }
        });

    });

    // Global variable for current message
    var currentMessageId = null;

    // View full message in modal
    function viewFullMessage(id) {
        currentMessageId = id;

        // Show loading, hide content
        $('#messageLoading').show();
        $('#messageContent').hide();

        // Fetch message details
        $.ajax({
            url: "{{ url('admin/messages') }}/" + id,
            type: "GET",
            success: function(response) {
                if (response.success) {
                    var message = response.message;

                    // Populate modal
                    $('#modalName').text(message.name);
                    $('#modalEmail').text(message.email);
                    $('#modalSubject').text(message.subject);
                    $('#modalMessage').text(message.message);
                    $('#modalReceived').text(message.created_at);
                    $('#modalRead').text(message.status == 'read' ? message.updated_at : 'Not read yet');
                    $('#modalIp').text(message.ip_address || 'N/A');
                    $('#modalUserAgent').text(message.user_agent || 'N/A');
                    $('#modalDevice').text(response.user_agent_parsed || 'N/A');

                    // Set status badge
                    if (message.status == 'read') {
                        $('#modalStatus').html('<span class="badge bg-success">Read</span>');
                        $('#toggleReadButton').html('<i class="bi bi-envelope me-1"></i> Mark as Unread');
                        $('#toggleReadButton').removeClass('btn-success').addClass('btn-warning');
                    } else {
                        $('#modalStatus').html('<span class="badge bg-warning">Unread</span>');
                        $('#toggleReadButton').html('<i class="bi bi-envelope-open me-1"></i> Mark as Read');
                        $('#toggleReadButton').removeClass('btn-warning').addClass('btn-success');
                    }

                    // Setup reply button
                    $('#replyButton').attr('href', 'mailto:' + message.email + '?subject=Re: ' + encodeURIComponent(message.subject));

                    // Hide loading, show content
                    $('#messageLoading').hide();
                    $('#messageContent').show();
                }
            },
            error: function() {
                alert('Failed to load message details. Please try again.');
            }
        });
    }

    // Toggle message read/unread status
    function toggleMessageStatus() {
        if (!currentMessageId) return;

        $.ajax({
            url: "{{ url('admin/messages/mark-read') }}/" + currentMessageId,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update button in modal
                    if (response.status == 'read') {
                        $('#toggleReadButton').html('<i class="bi bi-envelope me-1"></i> Mark as Unread');
                        $('#toggleReadButton').removeClass('btn-success').addClass('btn-warning');
                        $('#modalStatus').html('<span class="badge bg-success">Read</span>');
                    } else {
                        $('#toggleReadButton').html('<i class="bi bi-envelope-open me-1"></i> Mark as Read');
                        $('#toggleReadButton').removeClass('btn-warning').addClass('btn-success');
                        $('#modalStatus').html('<span class="badge bg-warning">Unread</span>');
                    }

                    location.reload();
                }
            }
        });
    }

    // Mark single message as read/unread
    function markAsRead(id) {
        $.ajax({
            url: "{{ url('admin/messages/mark-read') }}/" + id,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#messagesTable').DataTable().ajax.reload();
                    showToast(response.message, 'success');
                }
                location.reload();
            }
        });
    }

    // Delete message
    function deleteMessage(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This message will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/messages/delete') }}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#messagesTable').DataTable().ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                'Message has been deleted.',
                                'success'
                            ).then((res) => {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Failed to delete message.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    // Bulk actions
    function bulkAction(action) {
        var selectedIds = [];
        $('.select-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one message.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        var confirmText = '';
        switch (action) {
            case 'mark_read':
                confirmText = 'Mark ' + selectedIds.length + ' message(s) as read?';
                break;
            case 'mark_unread':
                confirmText = 'Mark ' + selectedIds.length + ' message(s) as unread?';
                break;
            case 'delete':
                confirmText = 'Delete ' + selectedIds.length + ' message(s)? This action cannot be undone!';
                break;
        }

        Swal.fire({
            title: 'Confirm Action',
            text: confirmText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('messages.bulk-action') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        action: action,
                        ids: selectedIds
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#messagesTable').DataTable().ajax.reload();
                            showToast('Action completed successfully!', 'success');
                        }

                          location.reload();
                    }
                });
            }
        });
    }

    // Reply to message
    function replyToMessage() {
        var email = $('#modalEmail').text();
        var subject = $('#modalSubject').text();
        window.location.href = 'mailto:' + email + '?subject=Re: ' + encodeURIComponent(subject);
    }

    // Refresh table
    function refreshTable() {
        $('#messagesTable').DataTable().ajax.reload();
        showToast('Table refreshed!', 'info');
    }

    // Show toast notification
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-bg-${type} border-0 position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
        document.body.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>


@endsection