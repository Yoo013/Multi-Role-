@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar Produk</div>

                <div class="card-body">
                    @can('create-product')
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Tambah Produk Baru</a>
                    @endcan
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.1.53/build/pdfmake.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfmake@0.1.53/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tbl_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
            columns: [
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        var date = new Date(data);  
                        var day = ("0" + date.getDate()).slice(-2); 
                        var month = ("0" + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear();

                        return day + '-' + month + '-' + year;
                    }
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var buttons = '';
                        
                        @can('edit-product')
                        buttons += '<a href="/products/' + row.id + '/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>';
                        @endcan
                        
                        @can('delete-product')
                        buttons += ' <button class="btn btn-danger btn-sm delete-btn" data-id="' + row.id + '" data-name="' + row.name + '"><i class="bi bi-trash"></i> Delete</button>';
                        @endcan
                        
                        return buttons;
                    }
                },
            ],
            dom: 'Bfrtip',  
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                    columns: ':not(:last-child)'  
            }
                },
                {
                    extend: 'csvHtml5',
                    text: 'Export CSV',
                    className: 'btn btn-info btn-sm',
                    columns: ':not(:last-child)'  
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    className: 'btn btn-danger btn-sm',
                    columns: ':not(:last-child)'  
                },
            ],
            
        });

        $(document).on('click', '.delete-btn', function() {
            var productId = $(this).data('id');
            var productName = $(this).data('name');

            if (confirm('Are you sure you want to delete the product "' + productName + '"?')) {
                $.ajax({
                    url: '/products/' + productId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#tbl_list').DataTable().ajax.reload();
                        alert('Product deleted successfully');
                    },
                    error: function(xhr, status, error) {
                        alert('There was an error deleting the product');
                    }
                });
            }
        });
    });
</script>
@endpush
