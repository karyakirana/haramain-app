<x-LayoutMetronics>

    <div class="row">

        <div class="col-md-8">

            <x-mikro.card class="pt-0">
                <x-mikro.form id="formBesar" method="POST" action="{{ route('simpanStockMasuk') }}">
                    @csrf
                    <input type="text" name="temp" value="{{ $idTemp }}" hidden>
                    <input type="text" name="idStockMasuk" value="{{ $idStockMasuk ?? '' }}" hidden>
                    <input type="text" name="idSupplier" value="{{ $idSupplier ?? '' }}" hidden>
                    <!-- begin::header form -->
                    <div class="d-flex flex-column align-items-start flex-xxl-row">
                        <!--begin::Input group-->
                        <div class="d-flex align-items-center flex-equal fw-row me-4 order-2">
                            <!--begin::Date-->
                            <div class="fs-6 fw-bolder text-gray-700 text-nowrap">Date:</div>
                            <!--end::Date-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center w-150px">
                                <!--begin::Datepicker-->
                                <input class="form-control form-control-white fw-bolder pe-5" placeholder="Select date" name="tanggalMasuk" value="{{ $tglMasuk ?? '' }}"/>
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4" data-bs-toggle="tooltip" data-bs-trigger="hover" title="Enter invoice number">
                            <span class="fs-2x fw-bolder text-gray-800">Kode #</span>
                            <input type="text" class="form-control form-control-flush fw-bolder text-gray-400 fs-3 w-125px" value="{{ $kode ?? '' }}"/>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row">
                            <!--begin::Date-->
                            <div class="fs-6 fw-bolder text-gray-700 text-nowrap">Gudang :</div>
                            <!--end::Date-->
                            <!--begin::Input-->
                            <div class="position-relative d-flex align-items-center w-150px">
                                <!--begin::Datepicker-->
                                <select name="gudang" id="gudang" class="form-control orm-control-white fw-bolder pe-5">
                                    @forelse($data as $gudang)
                                        <option value="{{ $gudang->id }}" {{ (($branch ?? '') == $gudang->id) ? 'selected' : ''}}>{{ $gudang->branchName }}</option>
                                    @empty
                                        <option>--no data--</option>
                                    @endforelse
                                </select>
                                <!--end::Datepicker-->
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!-- end::header form -->

                    <div class="separator border-dark my-4"></div>
                    <!-- end::masterform -->
                    <!-- begin::baris -->
                    <div class="row mb-5">
                        <div class="col-md-6 row">
                            <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-sm-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control form-control-solid" name="supplier" id="supplier" aria-describedby="button-addon2" value="{{ $namaSupplier ?? '' }}">
                                    <button class="btn btn-primary" id="cariSupplierBtn" type="button">Cari</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row">
                            <label for="nomorPo" class="col-sm-4 col-form-label">Nomor PO</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-solid" id="nomorPo" name="nomorPo" value="{{ $nomorPO ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <label for="nomorPo" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control form-control-solid" id="keterangan" name="keterangan" value="{{ $keterangan ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <!-- end::baris -->

                </x-mikro.form>
                <x-nano.table class="align-middle gs-5 table-hover table-rounded table-striped border table-row-100" id="tableTemp" width="100%">
                    <!--begin::Table head-->
                    <x-nano.tableHead class="text-start text-gray-400 fw-bolder fs-7 text-uppercase">
                        <!--begin::Table row-->
                        <th>Nomor</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th class="text-center" width="15%">Actions</th>
                        <!--end::Table row-->
                    </x-nano.tableHead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody></tbody>
                    <!--end::Table body-->
                </x-nano.table>
            </x-mikro.card>

        </div>
        <x-mikro.card class="pt-0 col-md-4">
            <form class="form" id="formProduk">
                <input type="text" name="idDetilTemp" hidden>
                <input type="text" name="idTempforDetil" hidden value="{{$idTemp}}">
                <div class="form-group row mb-5">
                    <label class="col-md-4 col-form-label" for="idProduk">ID Produk</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" id="idProduk" name="idProduk" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-5">
                    <label class="col-md-4 col-form-label" for="namaProduk">Produk</label>
                    <div class="col-md-8">
                        <textarea name="namaProduk" id="namaProduk" rows="3" class="form-control" readonly=""></textarea>
                    </div>
                </div>
                <div class="form-group row mb-5">
                    <label class="col-md-4 col-form-label" for="kategoriHarga">Kategori</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" id="kategoriHarga" name="kategoriHarga" readonly="">
                    </div>
                </div>
                <div class="form-group row mb-5">
                    <label class="col-md-4 col-form-label" for="jumlah">Jumlah</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" id="jumlah" name="jumlah">
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col">
                        <button type="button" class="btn btn-success w-100" id="tambahBtn">simpan</button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-warning w-100" id="cariProdukBtn">Cari Produk</button>
                    </div>
                </div>
            </form>
            <div class="separator mb-5"></div>
            <button type="submit" href="#" class="btn btn-primary w-100" id="kt_invoice_submit_button">
                <!--begin::Svg Icon | path: icons/duotone/Map/Direction2.svg-->
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <path d="M14,13.381038 L14,3.47213595 L7.99460483,15.4829263 L14,13.381038 Z M4.88230018,17.2353996 L13.2844582,0.431083506 C13.4820496,0.0359007077 13.9625881,-0.12427877 14.3577709,0.0733126292 C14.5125928,0.15072359 14.6381308,0.276261584 14.7155418,0.431083506 L23.1176998,17.2353996 C23.3152912,17.6305824 23.1551117,18.1111209 22.7599289,18.3087123 C22.5664522,18.4054506 22.3420471,18.4197165 22.1378777,18.3482572 L14,15.5 L5.86212227,18.3482572 C5.44509941,18.4942152 4.98871325,18.2744737 4.84275525,17.8574509 C4.77129597,17.6532815 4.78556182,17.4288764 4.88230018,17.2353996 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.000087, 9.191034) rotate(-315.000000) translate(-14.000087, -9.191034)"></path>
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->Send Invoice</button>
        </x-mikro.card>

    </div>

    <x-mikro.modal class="modal-xl" id="modalProduk">

        <!--begin::Modal header-->
        <x-mikro.modalHeader id="kt_modal_add_user_header" title="Tambah Kategori Akun">
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" data-kt-users-modal-action="close">
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                            </g>
                        </svg>
                    </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
        </x-mikro.modalHeader>

        <x-mikro.modalBody class="scroll-y mx-5 mx-xl-15">
            <table class="table align-middle gs-5 table-hover table-rounded table-striped border table-row-100" width="100%" id="tableProduk">
                <thead class="fs-7 fw-bolder text-uppercase">
                    <tr>
                        <th>Kode</th>
                        <th>ID Lokal</th>
                        <th width="30%">Judul</th>
                        <th>Kategori</th>
                        <th>Kategori Harga</th>
                        <th>Penerbit</th>
                        <th>Cover</th>
                        <th class="none">Halaman</th>
                        <th class="none">Size</th>
                        <th class="none">Keterangan</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </x-mikro.modalBody>

    </x-mikro.modal>

    <x-mikro.modal class="modal-xl" id="modalSupplier">

        <!--begin::Modal header-->
        <x-mikro.modalHeader id="kt_modal_add_user_header" title="Tambah Kategori Akun">
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" data-kt-users-modal-action="close">
                <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                            </g>
                        </svg>
                    </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Close-->
        </x-mikro.modalHeader>

        <x-mikro.modalBody class="scroll-y mx-5 mx-xl-15">
            <table class="table align-middle gs-5 table-hover table-rounded table-striped border table-row-100" width="100%" id="tableSupplier">
                <thead class="fs-7 fw-bolder text-uppercase">
                <tr>
                    <th>ID</th>
                    <th>Supplier</th>
                    <th>Jenis</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </x-mikro.modalBody>

    </x-mikro.modal>

    @push('styles')
        <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script>
            let url = "{{ url('/') }}"; // url root
            let headersCSRF = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}; // headers
            let formProduk = document.getElementById('formProduk');

            // datatable produk
            var tableProduk = document.getElementById('tableProduk');
            $(tableProduk).DataTable({
                info : true,
                processing : true,
                serverSide : true,
                responsive: true,
                order : [],
                ajax : {
                    headers : headersCSRF,
                    url : url+'/stock/transaksiproduk',
                    type : "PATCH",
                    data : {
                        columnDefs : [
                            "id_produk",
                            "nama_produk",
                            "penerbit",
                            "hal",
                            "size",
                            "cover",
                            "harga",
                            "deskripsi",
                        ]
                    }
                },
                columns : [
                    { data : "id_produk"},
                    { data : "kode_lokal"},
                    { data : "nama_produk"},
                    { data : "foreign.kategori"},
                    { data : "foreign.kategoriHarga"},
                    { data : "penerbit"},
                    { data : "cover"},
                    { data : "hal"},
                    { data : "size"},
                    { data : "deskripsi"},
                    { data : "Actions"}
                ],
                lengthChange : true,
                dom : "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">",
            });


            // deklarasi modal produk
            let modalForm = new bootstrap.Modal(document.getElementById('modalProduk'), {
                keyboard: false
            })
            // Buka Modal Produk
            $('#cariProdukBtn').on('click', function (){
                modalForm.show();
            })

            /**
             * Supplier
             *
             */

            // deklarasi modal produk
            let modalSupplier = new bootstrap.Modal(document.getElementById('modalSupplier'), {
                    keyboard: false
                })
            // Buka Modal Produk
            $('#cariSupplierBtn').on('click', function (){
                modalSupplier.show();
            })

            // table Supplier
            var tableSupplier = document.getElementById('tableSupplier');
            $(tableSupplier).DataTable({
                info : true,
                processing : true,
                serverSide : true,
                responsive: true,
                order : [],
                ajax : {
                    headers : headersCSRF,
                    url : url+'/stock/transaksisupplier',
                    type : "PATCH",
                    data : {
                        columnDefs : [
                            "kodeSupplier",
                            "foreign.jenisSupplier",
                            "namaSupplier",
                            "alamatSupplier",
                            "tlpSupplier",
                            "keteranganSupplier",
                        ]
                    }
                },
                columns : [
                    { data : "kodeSupplier"},
                    { data : "foreign.jenisSupplier"},
                    { data : "namaSupplier"},
                    { data : "alamatSupplier"},
                    { data : "tlpSupplier"},
                    { data : "keteranganSupplier"},
                    { data : "Actions"}
                ],
                lengthChange : true,
                dom : "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">",
            });

            function setSupplier(id_supplier)
            {
                $.ajax({
                    headers : headersCSRF,
                    url : url+"/stock/transaksi/setsupplier/"+id_supplier,
                    method: "GET",
                    dataType : "JSON",
                    success : function (data) {
                        modalSupplier.hide();
                        // insert value
                        $('[name="idSupplier"]').val(data.id);
                        $('[name="supplier"]').val(data.namaSupplier);
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            // eksekusi setSupplier
            $('body').on('click', '#buttonEditSupplier',function (){
                let dataId = $(this).data('id');
                setSupplier(dataId);
            })

            // add produk
            function setProduk(id_produk)
            {
                $.ajax({
                    headers : headersCSRF,
                    url : url+"/stock/transaksi/setproduk/"+id_produk,
                    method: "GET",
                    dataType : "JSON",
                    success : function (data) {
                        var stock = (data.stock) ? data.stock : '';
                        formProduk.reset(); // reset form produk
                        removeErrorValidation();
                        // insert value
                        $('[name="idProduk"]').val(data.id_produk);
                        $('[name="namaProduk"]').val(data.nama_produk+'\n'+data.idLokal+'\n'+data.cover+'\n'+stock);
                        $('[name="kategoriHarga"]').val(data.id_kat_harga);
                        modalForm.hide();
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            // eksekusi setProduk
            $('body').on('click', '#buttonEdit',function (){
                let dataId = $(this).data('id');
                setProduk(dataId);
            })

            /**
             * Start with temporary
             * @type {HTMLElement}
             */

            //datatable temporary
            let tableTemp = document.getElementById('tableTemp');
            $(tableTemp).DataTable({
                info : false,
                processing : true,
                serverSide : true,
                responsive: true,
                order : [],
                ajax : {
                    headers : headersCSRF,
                    url : url+'/stock/temp/detil/'+'{{$idTemp}}',
                    type : "PATCH",
                    data : {
                        columnDefs : [
                            "idProduk",
                            "foreign.produk",
                            "jumlah",
                        ]
                    }
                },
                columns : [
                    { data : "idProduk"},
                    { data : "foreign.produk"},
                    { data : "jumlah"},
                    { data : "Actions"}
                ],
                lengthChange : false,
            });

            function reloadTableTemp()
            {
                $(tableTemp).DataTable().ajax.reload();
            }

            // remove validation
            function removeErrorValidation()
            {
                $('.invalid-feedback').remove();
                $('.is-invalid').removeClass('is-invalid');
            }

            function storeDetilTemp()
            {
                $.ajax({
                    headers : headersCSRF,
                    url : url+"/stock/temp/detil",
                    method : "POST",
                    data : $('#formProduk').serialize(),
                    dataType : "JSON",
                    success : function(data)
                    {
                        if(data.status){
                            $('#alertTable').addClass('alert-light-success show');
                            $("#alertText").append("Data Berhasil Diubah");
                            reloadTableTemp();
                            document.getElementById('formProduk').reset();
                            removeErrorValidation();
                        }
                    },
                    error : function(jqXHR, textStatus, errorThrown0)
                    {
                        // console.log(jqXHR.responseJSON);
                        // swal.fire({
                        //     html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        // });
                        // console.log(jqXHR.responseJSON.errors);
                        removeErrorValidation();
                        for (const [key, value] of Object.entries(jqXHR.responseJSON.errors)){
                            console.log(`${key}: ${value}`);
                            $('[name="'+`${key}`+'"').addClass('is-invalid').after('<div class="invalid-feedback" style="display: block;">'+`${value}`+'</div>');
                        }
                    }
                });
            }

            // store event
            $('#tambahBtn').on('click', function (){
                storeDetilTemp();
            });

            function editDetilTemp(id)
            {
                $.ajax({
                    headers : headersCSRF,
                    url : url+'/stock/temp/detil'+'/'+id,
                    method: "GET",
                    dataType : "JSON",
                    success : function (data) {
                        removeErrorValidation();
                        document.getElementById('formProduk').reset(); // reset data
                        // insert value
                        $('[name="idDetilTemp"]').val(data.id);
                        $('[name="idProduk"]').val(data.idProduk);
                        $('[name="namaProduk"]').val(data.namaProduk+'\n'+data.kategori+'\n'+data.cover);
                        $('[name="kategoriHarga"]').val(data.kategori_harga);
                        $('[name="jumlah"]').val(data.jumlah);
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            // edit event
            $('body').on('click', '#buttonEditTemp', function(){
                let dataId = $(this).data('id');
                editDetilTemp(dataId);
            })

            function destroyDetilTemp(id)
            {
                $.ajax({
                    headers : headersCSRF,
                    url : url+'/stock/temp/detil'+'/'+id,
                    method: "DELETE",
                    dataType : "JSON",
                    success : function (data) {
                        removeErrorValidation();
                        reloadTableTemp();
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            // edit event
            $('body').on('click', '#buttonDeleteTemp', function(){
                let dataId = $(this).data('id');
                destroyDetilTemp(dataId);
            })

            // date
            var form;
            var invoiceDate = $('[name="tanggalMasuk"]');
            invoiceDate.flatpickr({
                enableTime: false,
                dateFormat: "d-m-Y",
            });

            // submit form total
            $('#kt_invoice_submit_button').on('click', function(){
                document.getElementById("formBesar").submit();
            });
        </script>
    @endpush

</x-LayoutMetronics>
