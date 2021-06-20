<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" id="{{$id}}">
    <!--begin::Modal dialog-->
    <div {{ $attributes->merge(['class' => 'modal-dialog modal-dialog-centered ']) }}>
        <!--begin::Modal content-->
        <div class="modal-content">
        {{ $slot }}
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
