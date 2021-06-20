<x-LayoutMetronics>
    <x-slot name="pageToolbar">

    </x-slot>
    <x-mikro.card class="pt-0">
        <x-slot name="title">
            <x-nano.searchTable />
        </x-slot>
        <x-slot name="toolbar">
            <x-nano.button class="btn-primary" type="button" id="tambahData">
                <span class="svg-icon svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1" />
                        <rect fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000)" x="4" y="11" width="16" height="2" rx="1" />
                    </svg>
                </span>
                Tambah Data
            </x-nano.button>

        </x-slot>
        <x-nano.table class="align-middle gs-5 table-hover table-rounded table-striped border table-row-100" id="tableList" width="100%">
            <!--begin::Table head-->
            <x-nano.tableHead class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                <!--begin::Table row-->
                <th>Kode</th>
                <th>Supplier</th>
                <th>Gudang</th>
                <th>Pencatat</th>
                <th>Tanggal Masuk</th>
                <th>Nomor PO</th>
                <th class="none">Keterangan</th>
                <th class="text-center" width="15%">Actions</th>
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
            let tableList = document.getElementById('tableList');
            const headersCSRF = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};

            // datatable
            $(tableList).DataTable({
                info : false,
                processing : true,
                serverSide : true,
                order : [],
                responsive : true,
                ajax : {
                    headers : headersCSRF,
                    url : '{{ url('/') }}'+'/stock/daftarmasuk',
                    type : "PATCH",
                    data : {
                        columnDefs : [
                            'stockmasukId', 'kode', 'tglNota', 'namaSupplier', 'name', 'tglMasuk', 'nomorPo',
                        ]
                    }
                },
                columns : [
                    {data: 'kode'},
                    {data: 'relation.supplierNama'},
                    {data: 'relation.branchNama'},
                    {data: 'relation.userNama'},
                    {data: 'tanggal_masuk_id'},
                    {data: 'nomorPo'},
                    {data: 'keterangan'},
                    { data : "Actions"}
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

        </script>
    @endpush
</x-LayoutMetronics>
