@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success  alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" 
  aria-label="Close"></button>
</div>
@endif
<div class="text-end mb-2">
<a class="btn btn-secondary" href="{{ route('rabs.create') }}"> Add Departement</a>
</div>
<table id="example" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th scope="col">#</th>        
      <th scope="col">NO TRX</th>   
      <th scope="col">Tanggal RAB</th>
      <th scope="col">Manager Name</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Total</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rabs as $data)
    <tr>
        <td>{{ $data->id }}</td>
        <td>{{ $data->no_trx }}</td>
        <td>{{ $data->tgl_rab }}</td>
        <td>{{ 
          (isset($data->getManager->name)) ? 
          $data->getManager->name : 
          'Tidak Ada'
          }}
        </td>
        <td>{{ $data->detail->count() }}</td>
        <td>{{ $data->total }}</td>
        <td>
            <form action="{{ route('rabs.destroy',$data->id) }}" method="Post">
                <a class="btn btn-primary" href="{{ route('rabs.edit',$data->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
@section('js')
<script>
  $(document).ready(function () {
      $('#example').DataTable();
  });
</script>
@endsection