@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Pictures</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pictures</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Pictures Table</h3>
                    <a href="{{route('pictures.create')}}" class="btn btn-primary ms-auto">Add New</a>
                </div>

                <div class="card-body">
                    <table id="picturesTable" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Image</th>
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
        var table = $('#picturesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": {
                "url": "{{ route('pictures.index') }}",
                "type": "GET"
            },
            "columns": [
                {
                    "data": "type_formatted",
                    "name": "type_formatted",
                    "orderable": true,
                    "searchable": true,
                    "render": function(data, type, row) {
                        return data ? data.charAt(0).toUpperCase() + data.slice(1) : 'N/A';
                    }
                },
                {
                    "data": "image_html",
                    "name": "image",
                    "orderable": false,
                    "searchable": false,
                    "className": "text-center"
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
                    "name": "created_at",
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
                [3, 'desc'] 
            ],
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "language": {
                "processing": "Processing...",
                "lengthMenu": "Show _MENU_ entries",
                "zeroRecords": "No pictures found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "search": "Search:",
                "searchPlaceholder": "Search pictures...",
                "paginate": {
                    "first": '<i class="bi bi-chevron-double-left"></i>',
                    "last": '<i class="bi bi-chevron-double-right"></i>',
                    "next": '<i class="bi bi-chevron-right"></i>',
                    "previous": '<i class="bi bi-chevron-left"></i>'
                }
            }
        });
    });

    function deletePicture(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: "{{url('admin/pictures/delete')}}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).then(function(response) {
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
                Swal.fire(
                    "Deleted!",
                    "Picture deleted successfully",
                    "success"
                ).then(() => {
                    // Reload the DataTable
                    $('#picturesTable').DataTable().ajax.reload();
                });
            }
        });
    }
</script>

<style>
    /* Custom styles for DataTable */
    #picturesTable_wrapper .dataTables_filter {
        float: right;
        margin-bottom: 10px;
    }
    
    #picturesTable_wrapper .dataTables_length {
        float: left;
        margin-bottom: 10px;
    }
    
    #picturesTable_wrapper .dataTables_length select {
        width: auto;
        display: inline-block;
    }
    
    #picturesTable_wrapper .dataTables_info {
        padding-top: 15px;
        font-size: 14px;
    }
    
    #picturesTable_wrapper .dataTables_paginate {
        padding-top: 10px;
    }
    
    #picturesTable_wrapper .dataTables_paginate .paginate_button {
        margin: 0 3px;
        border-radius: 4px !important;
    }
    
    #picturesTable_wrapper .dataTables_paginate .paginate_button.current {
        background: #0d6efd !important;
        color: white !important;
        border: 1px solid #0d6efd !important;
    }
    
    /* Button group styling */
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    /* Image styling */
    #picturesTable img {
        border-radius: 4px;
        border: 1px solid #dee2e6;
        object-fit: cover;
        max-width: 100%;
        height: auto;
    }
    
    /* Badge styling */
    #picturesTable .badge {
        font-size: 0.85em;
        padding: 0.4em 0.8em;
        font-weight: 500;
    }
    
    /* Table header styling */
    #picturesTable thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        vertical-align: middle;
    }
    
    /* Hover effect */
    #picturesTable tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    /* Custom select for filters */
    thead select.form-select-sm {
        margin-top: 5px;
        width: 100%;
        max-width: 150px;
        display: inline-block;
    }
    
    /* Action buttons */
    #picturesTable .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        #picturesTable_filter input {
            width: 200px !important;
        }
        
        thead select.form-select-sm {
            max-width: 120px;
        }
    }
    
    @media (max-width: 576px) {
        #picturesTable_filter input {
            width: 150px !important;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .card-header .btn {
            margin-top: 10px;
            align-self: flex-end;
        }
    }
</style>
@endsection