@php
  $isYajra = $isYajra ?? false;
@endphp

@extends($data->count() > 0 || $isYajra ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0 || $isYajra)
          @if ($canExport)
            <div class="card">
              <div class="card-header">
                <h4><i class="{{ $moduleIcon }}"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                <div class="card-header-action">
                  @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
                  @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
                  @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
                  @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
                </div>
              </div>
            </div>
          @endif

          <div class="card">
            <div class="card-header">
              <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>

              <div class="card-header-action">
                @if ($canImportExcel)
                  @include('stisla.includes.forms.buttons.btn-import-excel')
                @endif
                @if ($canCreate)
                  @include('stisla.includes.forms.buttons.btn-add', ['link' => $route_create])
                @endif
              </div>
            </div>
            <div class="card-body">
              @include('stisla.includes.forms.buttons.btn-datatable')
              <div class="table-responsive">
                @yield('table')
              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => $moduleIcon, 'link' => $route_create])
        @endif
      </div>

    </div>
  </div>

@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
  @if ($isYajra)
    <script>
      $(function() {
        var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ $routeYajra }}",
          columns: JSON.parse('{!! $yajraColumns !!}'),
        });

      });
    </script>
  @endif
@endpush

@push('modals')
  @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => $routeImportExcel,
        'downloadLink' => $routeExampleExcel,
    ])
  @endif
@endpush
