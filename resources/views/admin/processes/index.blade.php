@extends('layouts.admin')
@section('content')
@can('process_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.processes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.process.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.process.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Process">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.process.fields.identifiant') }}
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.activities') }}                              
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.informations') }}
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.security_need') }}
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.macroprocessus') }}
                        </th>
                        <th>
                            {{ trans('cruds.process.fields.owner') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($processes as $key => $process)
                        <tr data-entry-id="{{ $process->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $process->identifiant ?? '' }}
                            </td>
                            <td>
                                {!! $process->description ?? '' !!}
                            </td>
                            <td>
                                @foreach($process->activities as $key => $activities)
                                    <span class="label label-info">{{ $activities->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($process->processInformation as $key => $informations)
                                    <span class="label label-info">{{ $informations->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if ($process->security_need==1) 
                                    Public
                                @elseif ($process->security_need==2)
                                    Internal
                                @elseif ($process->security_need==3)
                                    Confidential
                                @elseif ($process->security_need==4)
                                    Secret
                                @endif
                            </td>
                            <td>
                                {{ $process->macroProcess->name ?? '' }}
                            </td>
                            <td>
                                {{ $process->owner ?? '' }}
                            </td>
                            <td>
                                @can('process_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.processes.show', $process->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('process_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.processes.edit', $process->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('process_delete')
                                    <form action="{{ route('admin.processes.destroy', $process->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('process_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.processes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Process:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection