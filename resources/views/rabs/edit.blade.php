@extends('app')
@section('content')
<form action="{{ route('rabs.update', $rab->id ) }}" method="POST" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>NO RAB:</strong>
              <input type="text" name="no_trx" class="form-control" placeholder="NO RAB" value="{{ $rab->no_trx }}" disabled>
              @error('no_rab')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Tanggal RAB:</strong>
              <input type="date" name="tgl_rab" class="form-control" placeholder="Tanggal RAB" value="{{ $rab->tgl_rab }}" >
              @error('tgl_rab')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Penyusun :</strong>
              <select name="penyusun" id="penyusun" class="form-select">
                <option value="">Pilih</option>
                @foreach ($managers as $item)
                <option value="{{ $item->id }}" {{ ($item->id==$rab->penyusun)? 'selected': ''}}>{{ $item->name }}</option>
                @endforeach
              </select>
              @error('id_penyusun')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
          <div class="form-group col-10">
              <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Nama Product">
              @error('search')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group col-2">
              <button type="text" class="btn btn-secondary"> Tambah </button>
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name Product</th>
                <th scope="col">Price</th>
                <th scope="col">QTY</th>
                <th scope="col">Sub Total</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="detail">
                <?php $no=0; ?>
                @foreach($detail as $item)
                <?php $no++?>
                <tr>
                    <td>
                        <input type="hidden" name="productId{{$no}}" class="form-control" value="{{$item->id_product}}">
                        <span>{{$no}}</span>
                    </td>
                    <td>
                        <input type="text" name="productName{{$no}}" class="form-control" value="{{$item->getProduct->name}}">
                    </td>
                    <td>
                        <input type="text" name="price{{$no}}" class="form-control" value="{{$item->price}}" >
                    </td>
                    <td>
                        <input type="number" name="qty{{$no}}" class="form-control" oninput="sumQty('{{$no}}',this.value)" value="{{$item->qty}}">
                    </td>
                    <td>
                        <input type="number" name="sub_total{{$no}}" class="form-control" value="{{$item->sub_total}}" >
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-danger">X</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <input type="hidden" name="jml" class="form-control" value="{{count($detail)}}" >
          <div class="form-group">
              <strong>Grand Total:</strong>
              <input type="text" name="total" class="form-control" placeholder="Rp. 0" value="{{$rab->total}}">
              @error('tgl_rab')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
  </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.product') }}";
  
    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#search').val(ui.item.label);
        //    console.log($("input[name=jml]").val());
            if($("input[name=jml]").val() > 0){
                for (let i = 1; i <=  $("input[name=jml]").val(); i++) {
                    id = $("input[name=productId"+i+"]").val();
                    if(id==ui.item.id){
                        alert(ui.item.value+' sudah ada!');
                        break;
                    }else{
                        add(ui.item.id);
                    }
                }
            }else{
                add(ui.item.id);
            } 
           return false;
        }
      });

    function add(id){
        // console.log(id);
        const path = "{{ route('products.index') }}/"+id;
        var html = "";
        var no=0;
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            
            success: function( data ) {
                if($('#detail tr').length > no){
                    html = $('#detail').html();
                    no = $('#detail tr').length;
                }
                no++;
                html+='<tr>'+
                        '<td>'+
                            '<input type="hidden" name="productId'+no+'" class="form-control" value="'+data.id+'">'+
                            '<span>'+no+'</span>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="productName'+no+'" class="form-control" value="'+data.name+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="price'+no+'" class="form-control" value="'+data.price+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="qty'+no+'" class="form-control" oninput="sumQty('+no+',this.value)">'+
                        '</td>'+
                        '<td>'+
                            '<input type="number" name="sub_total'+no+'" class="form-control" >'+
                        '</td>'+
                        '<td>'+
                            '<a href="#" class="btn btn-sm btn-danger">X</a>'+
                        '</td>'+
                    '</tr>';

                    $('#detail').html(html);
                    $("input[name=jml]").val(no);
            }
          });
    }

    function sumQty(no, q){
        var price = $("input[name=price"+no+"]").val();
        var subtotal = q*parseInt(price);
        $("input[name=sub_total"+no+"]").val(subtotal);
        console.log(q+"*"+price+"="+subtotal);
        sumTotal();
    }

    function sumTotal(){
    var total = 0;
       for (let i = 1; i <=  $("input[name=jml]").val(); i++) {
        var sub = $("input[name=sub_total"+i+"]").val();
        total = total + parseInt(sub);
       }
       $("input[name=total]").val(total);
    }
  
</script>
@endsection