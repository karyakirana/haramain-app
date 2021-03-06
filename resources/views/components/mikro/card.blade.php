@props(['title'=>'', 'toolbar'=>null, 'footer'=>''])
<div {{$attributes->merge(['class' => 'card'])}}>
    @if($toolbar != null)
    <!--begin::Header-->
    <div class="card-header border-0 pt-6">
        <h3 class="card-title">{{ $title }}</h3>
        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
            {{ $toolbar }}
            </div>
        </div>
    </div>
    @endif
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
    {{ $slot }}
    </div>
    <!--end::Body-->
    @if($footer != null)
    <div class="card-footer">
        {{ $footer }}
    </div>
    @endif
</div>
