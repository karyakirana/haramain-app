@props(['title'=>'', 'toolbar'=>''])
<div {{$attributes->merge(['class' => 'card'])}}>
    <!--begin::Header-->
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        <div class="card-toolbar">
            {{ $toolbar }}
        </div>
    </div>
    <!--end::Header-->
    <form>
        <div class="card-body">
            {{ $slot }}
        </div>
        <div class="card-footer">
            {{ $footer }}
        </div>
    </form>
</div>
