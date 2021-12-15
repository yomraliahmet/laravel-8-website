@php
    $title = $title ?? trans("admin.common.records");
@endphp
<x-card :title=$title :buttons=$buttons type="default">
    <table id="{{ $name ?? "table" }}" class="table table-bordered table-striped">
        <thead>
        <tr>
            @foreach(json_decode($columns) as $column)
                <th {{ isset($column->width) ? 'style="width:'.$column->width.'"' : '' }}>{!! $column->header ?? ""  !!}</th>
            @endforeach
        </tr>
        </thead>
    </table>
</x-card>

@section("css")
    <style>
        div.dt-buttons {
            float: right;
            margin-left:10px;
        }
        tbody tr.selected{
            background-color: #292929 !important;
        }
        table.dataTable tbody tr.selected a, table.dataTable tbody th.selected a, table.dataTable tbody td.selected a, table.dataTable tbody tr.selected i {
            color: #ffffff !important;
        }
        .btn-group, .btn-group-vertical {
            display: inline-block;
        }
        div.dt-buttons{
            margin-bottom:4px;
        }
        div.dataTables_wrapper div.dataTables_info {
            padding-top: 0.85em;
            white-space: pre-wrap;
        }
    </style>
@endsection


@section("cssFile")
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/datatables-rowreorder/css/rowReorder.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset("assets/backend") }}/plugins/datatables-select/css/select.bootstrap4.min.css">
@endsection

@section("footerJSFile")
    <!-- DataTables -->
    <script src="{{ asset("assets/backend") }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-rowreorder/js/dataTables.rowReorder.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-rowreorder/js/rowReorder.bootstrap4.js"></script>

    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/buttons.flash.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/buttons.bootstrap4.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/buttons.colVis.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/buttons.html5.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-buttons/js/buttons.print.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/pdfmake/pdfmake.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-select/js/dataTables.select.js"></script>
    <script src="{{ asset("assets/backend") }}/plugins/datatables-select/js/select.bootstrap4.js"></script>
@endsection

@section("footerJS")
    <script>
        $(function () {

        var datatableConfig =
            {
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "aaSorting": [],
                "stateSave": true,
                "responsive": {
                    "breakpoints": [
                        {name: 'bigdesktop', width: Infinity},
                        {name: 'meddesktop', width: 1480},
                        {name: 'smalldesktop', width: 1280},
                        {name: 'medium', width: 1188},
                        {name: 'tabletl', width: 1024},
                        {name: 'btwtabllandp', width: 848},
                        {name: 'tabletp', width: 768},
                        {name: 'mobilel', width: 480},
                        {name: 'mobilep', width: 320}
                    ]
                },
                "dom": "<'row'<'col-md-6'l><'col-md-6'Bf>>" +
                    "<'row'<'col-md-6'><'col-md-6'>>" +
                    "<'row'<'col-md-12'tr>><'row'<'col-md-12'ip>>",
                "buttons": [
                    {
                        extend: 'collection',
                        text: '{{ trans("admin.common.export") }}',
                        className: 'btn-sm',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ],
                    },
                    {
                        className: 'btn-sm',
                        extend: 'colvis',
                        text: '{{ trans("admin.common.display") }}',
                    },
                    @can($deleteAllPermission)
                    {
                        className: 'btn-sm btn-danger btn-selected-delete',
                        text: '{{ trans("admin.common.delete_selected_btn") }}',
                    }
                    @endcan
                ],
                "columnDefs": [{
                    "targets": 'searchable',
                    "orderable": false,
                }],
                "ajax": "{{ $url }}",
                "columns": {!! $columns !!},
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Turkish.json"
                },
                @if(isset($order))
                "rowReorder": {
                    "dataSrc": 'order',
                    "selector": 'div.move',
                },
                "order": [[{{ $sort ?? 0 }}, "asc"]]
                @else
                "order": [[{{ $sort ?? 0 }}, "desc"]]
                @endif
            }
            $('#{{ $name ?? "table" }}').dataTable().fnDestroy();
            var datatable = $('#{{ $name ?? "table" }}').DataTable(datatableConfig);
            @if(isset($order))
                datatable.on( 'row-reordered', function ( e, details, edit ) {
                var orders = [];
                for ( var i = 0; i < details.length ; i++ ) {
                    var rowData = datatable.row( details[i].node ).data();
                    orders.push({
                        id: rowData['id'],
                        order: details[i].newData
                    });
                }

                if (orders.length === 0) {
                    return;
                }

                var post = $.post("{{ $order }}",{"orders": orders,"_token": $('meta[name="csrf-token"]').attr('content')});
                post.done(function(xhr){
                    datatable.draw(false);
                });
            });
            @endif


            $("input#checkAll").on("change", function(){
                var ischecked= $(this).is(':checked');
                var checkboxEl = $(this).closest("table").find("tbody").find(":checkbox");
                if(ischecked){
                    checkboxEl.prop("checked", true);
                    checkboxEl.closest("tr").addClass('selected');
                }else{
                    checkboxEl.prop("checked", false);
                    checkboxEl.closest("tr").removeClass('selected');
                }
            });

            $(document).on("change", "input.checkAll", function(){
                console.log("seçildi");
                var ischecked= $(this).is(':checked');
                if(ischecked){

                    $(this).prop("checked", true);
                    $(this).closest("tr").addClass('selected');
                }else{
                    $(this).prop("checked", false);
                    $(this).closest("tr").removeClass('selected');
                }
            });


            $(document).on("click", ".btn-selected-delete", function(){
               var selectedEl = $(this).closest(".dataTables_wrapper").find("tr.selected");
               var data = [];
               selectedEl.each(function(k, v){
                   var id = $(v).find(".checkAll").data("id");
                   data.push(id);
               });

               var postData = {
                   "id": data,
                   "_method": "DELETE",
                   "_token": "{{ csrf_token() }}",
               }

               if(selectedEl.length < 1){
                   Swal.fire({
                       position: 'top-end',
                       icon: 'warning',
                       title: trans("messages.common.not_selected"),
                       showConfirmButton: false,
                       timer: 1500
                   });

                   return false;
               }

                Swal.fire({
                    title: trans("admin.common.delete_title"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "<i class='fas fa-check-circle'></i> "+ trans("admin.common.confirm"),
                    cancelButtonText: "<i class='far fa-times-circle'></i> "+trans_choice("admin.common.cancel"),
                }).then((result) => {
                    if (result.isConfirmed) {

                        var post = $.post('{{ $selectedDestroy ?? "" }}',postData);
                        post.done(function(xhr){

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: trans("messages.common.success_message"),
                                showConfirmButton: false,
                                timer: 1500
                            });

                            selectedEl.closest("table").DataTable().draw(false);

                        });

                    }
                });

            });

        });
    </script>
    @parent
@endsection
