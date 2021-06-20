<x-LayoutMetronics>
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
                <th>Nomor</th>
                <th>Nama Gudang</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Keterangan</th>
                <th class="text-center" width="15%">Actions</th>
                <!--end::Table row-->
            </x-nano.tableHead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody></tbody>
            <!--end::Table body-->
        </x-nano.table>
    </x-mikro.card>

    <!-- begin::modal -->
    <x-mikro.modal class="mw-950px" id="modal_standart">
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
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <x-mikro.modalBody class="scroll-y mx-5 mx-xl-15 my-7">
            <!--begin::Form-->
            <x-mikro.form id="modal_form" action="#">
                <input type="text" name="id" hidden>
                <div class="mb-5">
                    <label class="required">Nama Gudang</label>
                    <input class="form-control" type="text" name="namaGudang" required>
                </div>
                <div class="mb-5">
                    <label class="required">Alamat</label>
                    <input class="form-control" type="text" name="alamat" required>
                </div>
                <div class="mb-5">
                    <label for="kota">Kota</label>
                    <input type="text" class="form-control" name="kota">
                </div>
                <div class="mb-5">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan">
                </div>
                <!--begin::Actions-->
                <div class="text-center pt-15">
                    <x-nano.button type="reset" class="btn-white me-3" id="cancelModal">Discard</x-nano.button>
                    <x-nano.button type="button" class="btn-primary" id="submitModal">
                        <span class="indicator-label">Submit</span>
                    </x-nano.button>
                </div>
                <!--end::Actions-->
            </x-mikro.form>
            <!--end::Form-->
        </x-mikro.modalBody>
        <!--end::Modal body-->
    </x-mikro.modal>
    <!-- end::modal -->

    @push('styles')
        <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('scripts')
        <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>

        <script>

            // deklarasi variabel
            let tableList = document.getElementById('tableList');
            const buttonAdd = document.getElementById('tambahData');
            const buttonCloseModal = document.getElementById('cancelModal');
            let buttonSubmitModal = document.getElementById('submitModal');
            // var buttonEdit = document.getElementById('buttonEdit');
            const formData = document.getElementById('modal_form');
            const headersCSRF = {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
            let modalForm = new bootstrap.Modal(document.getElementById('modal_standart'), {
                keyboard: false
            })

            /**
             * Event DOM
             */
            buttonAdd.addEventListener('click', addData);
            buttonCloseModal.addEventListener('click', closeModal);
            buttonSubmitModal.addEventListener('click', storeData); // update Or create
            // edit
            $('body').on('click', '#buttonEdit', function (){
                let dataId = $(this).data('id');
                editData(dataId);
            })
            // delete
            $('body').on('click', '#buttonDelete', function (){
                let dataId = $(this).data('id');
                deleteData(dataId);
            })

            // datatable
            $(tableList).DataTable({
                info : false,
                processing : true,
                serverSide : true,
                order : [],
                ajax : {
                    headers : headersCSRF,
                    url : '{{ url('/') }}'+'/stock/daftargudang',
                    type : "PATCH",
                    data : {
                        columnDefs : ['branchName', 'alamat', 'kota',] // search
                    }
                },
                columns : [
                    { data : "DT_RowIndex"},
                    { data : "branchName"},
                    { data : "alamat"},
                    { data : "kota"},
                    { data : "keterangan"},
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

            // open modal
            function addData()
            {
                modalForm.show();
            }

            // close modal
            function closeModal()
            {
                formData.reset(); // reset data
                modalForm.hide()
            }

            function removeErrorValidation()
            {
                $('.invalid-feedback').remove();
                $('is-invalid').removeClass();
            }

            // store data
            function storeData()
            {
                $.ajax({
                    headers : headersCSRF,
                    url : '{{ url('/') }}'+'/stock/daftargudang',
                    method : "POST",
                    data : $(formData).serialize(),
                    dataType : "JSON",
                    success : function(data)
                    {
                        if(data.status){
                            closeModal();
                            reloadTable();
                        }
                    },
                    error : function(jqXHR, textStatus, errorThrown0)
                    {
                        console.log(jqXHR.responseJSON);
                        // swal.fire({
                        //     html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        // });
                        removeErrorValidation();
                        console.log(jqXHR.responseJSON.errors);
                        for (const [key, value] of Object.entries(jqXHR.responseJSON.errors)){
                            console.log(`${key}: ${value}`);
                            $('[name="'+`${key}`+'"').addClass('is-invalid').after('<div class="invalid-feedback" style="display: block;">'+`${value}`+'</div>');
                        }
                    }
                });
            }

            // get data
            function editData(id)
            {
                $.ajax({
                    headers : headersCSRF,
                    url : '{{ url('/') }}'+'/stock/daftargudang'+'/'+id,
                    method: "GET",
                    dataType : "JSON",
                    success : function (data) {
                        removeErrorValidation();
                        document.getElementById('modal_form').reset(); // reset data
                        // insert value
                        $('[name="id"]').val(data.id);
                        $('[name="namaGudang"]').val(data.branchName);
                        $('[name="alamat"]').val(data.alamat);
                        $('[name="kota"]').val(data.kota);
                        $('[name="keterangan"]').val(data.keterangan);
                        modalForm.show();
                    },
                    error : function (jqXHR, textStatus, errorThrown)
                    {
                        swal.fire({
                            html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                        });
                    }
                });
            }

            function deleteData(id)
            {
                if (confirm('Serius untuk hapus data?')){

                    $.ajax({
                        headers : headersCSRF,
                        url : '{{ url('/') }}'+'/stock/daftargudang'+'/'+id,
                        method: "DELETE",
                        dataType : "JSON",
                        success : function (data) {
                            reloadTable();
                        },
                        error : function (jqXHR, textStatus, errorThrown)
                        {
                            swal.fire({
                                html: jqXHR.responseJSON.message+"<br><br>"+jqXHR.responseJSON.file+"<br><br>Line: "+jqXHR.responseJSON.line,
                            });
                        }
                    });
                }
            }

            // ajax communication

        </script>
    @endpush
</x-LayoutMetronics>
