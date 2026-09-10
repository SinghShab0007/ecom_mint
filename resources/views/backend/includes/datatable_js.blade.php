<!--Data Tables js-->
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jquery-3.5.1.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js')}}"></script>
<script>
    $(document).ready(function () {
        "use strict";

        $.extend( $.fn.dataTable.defaults, {
            "dom": 'lfBrtip',
            processing: true,
            "search": {
                "return": true
            },
            "order": [[ 0, "desc" ]],
            serverSide: true,
            buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        {
                            extend: 'copy',
                            text: 'copy',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'excel',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'csv',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'pdf',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        },
                        {
                            extend: 'print',
                            text: 'print',
                            exportOptions: {
                                columns: 'th:not(:last-child)'
                            }
                        }
                    ]
                }
            ]
        } );
    });
</script>
