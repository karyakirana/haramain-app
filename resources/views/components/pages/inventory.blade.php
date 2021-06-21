<x-LayoutMetronics>
    <x-mikro.card class="pt-0">
        <x-slot name="title">
            <x-nano.searchTable />
        </x-slot>
        <x-slot name="toolbar">
            <x-nano.button class="btn-primary" type="button" id="refreshButton">
                Refresh
            </x-nano.button>
            <x-nano.button class="btn-primary" type="button" id="refreshButton2">
                Refresh Gudang
            </x-nano.button>

        </x-slot>
        <x-nano.table class="align-middle gs-5 table-hover table-rounded table-striped border table-row-100" id="tableList" width="100%">
            <!--begin::Table head-->
            <x-nano.tableHead class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                <!--begin::Table row-->
                <th>Kode</th>
                <th>Produk</th>
                <th>Cabang</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Tersedia</th>
                <!--end::Table row-->
            </x-nano.tableHead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody></tbody>
            <!--end::Table body-->
        </x-nano.table>
    </x-mikro.card>

    @push('styles')
        <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>

            // deklarasi variabel
            let url = '{{ url('/') }}'
            let tableList = document.getElementById('tableList');
            let headersCSRF = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};

            // datatable
            $(tableList).DataTable({
                info : false,
                processing : true,
                serverSide : true,
                order : [],
                ajax : {
                    headers : headersCSRF,
                    url : url+'/inventory/refresh',
                    type : "PATCH",
                    data : {
                        columnDefs : ['idProduk', 'foreign.namaProduk', 'foreign.branch']
                    }
                },
                columns : [
                    { data : "idProduk"},
                    { data : "foreign.namaProduk"},
                    { data : "foreign.branch"},
                    {
                        data : "stockIn",
                        render: $.fn.dataTable.render.number('.', ',', '', ''),
                    },
                    { data : "stockOut"},
                    { data : "stockNow"},
                ],
                // lengthChange : false,
            });

            // search table
            $('#myInput').on( 'keyup', function () {
                $(tableList).DataTable().search( this.value ).draw();
            } );

            /**
             *
             * function of function
             */

            // reload table
            let reloadTable = function (){
                $(tableList).DataTable().ajax.reload();
            }

            // refresh from stock button
            let refreshButton = document.getElementById('refreshButton');

            function refreshStock()
            {
                $.ajax({

                    headers : headersCSRF,
                    url : url+'/inventory/refresh',
                    method : "PUT",
                    dataType : "JSON",
                    success : function(data)
                    {
                        if(data.status){
                            swal.fire({
                                html: data.messages,
                            });
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            $(refreshButton).on('click', function(){
                refreshStock();
            });

            function refreshStockFromStockMasuk()
            {
                $.ajax({

                    headers : headersCSRF,
                    url : url+'/inventory/refresh/fromstockmasuk',
                    method : "PUT",
                    dataType : "JSON",
                    success : function(data)
                    {
                        if(data.status){
                            swal.fire({
                                html: data.messages,
                            });
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            $('#refreshButton2').on('click', function(){
                refreshStockFromStockMasuk();
            });

        </script>
    @endpush
</x-LayoutMetronics>
