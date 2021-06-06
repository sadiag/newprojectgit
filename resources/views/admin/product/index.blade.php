
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Product
                </div>

                <div class="card-body">


                <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">SI NO</th>
      <th scope="col">NAME</th>
      <th scope="col">ADDED</th>
      <th scope="col">CREATED _AT</th>
      <th scope="col">Action</th>
    </tr>
    </thead>
  <tbody>

@php($i = 1)

  @foreach ($products as $product)

    <tr>
      <th scope="row">{{$i++}}</th>
      <td>{{$product->name}}</td>
      <td>{{$product->user_id}}</td>
      <td>{{$product->created_at}}</td>
      <td>
    

       @if($product->created_at == NULL)
      <span class="text_danger">No time set</span>
      @else
      {{ Carbon\Carbon::parse ($product->created_at)->diffForHumans()}}
      @endif
       </td>
       <td>
       <a href="{{ url('Product/Edit/'.$product->id) }}" class="btn btn-primary">Edit</a>
       <a href="{{ url('Softdelete/Product/'.$product->id) }}" class="btn btn-danger">Delete</a>
       </td>

    </tr>
      @endforeach

  </tbody>
</table>
{{$products->links()}}


            </div>
            </div>
            </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add Product
                </div>

                <div class="card-body">

                <form action="{{route('store.product')}}" method="POST">
                @csrf
    <div class="form-group">
    <label for="exampleInputEmail1">Add Product</label>
    <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="EnterProduct">

    @error('product_name')
    <span class="text_danger">{{$message}}</span>
    @enderror

  </div>

  <button type="submit" class="btn btn-primary">Add</button>
</form>

                </div>
            </div>
        </div>
        </div>
        </div>



        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Trash list
                </div>

                <div class="card-body">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{session('success')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                @endif


                <table class="table table-bordered">
              <thead>
             <tr>
               <th scope="col">SI NO</th>
               <th scope="col">NAME</th>
               <th scope="col">ADDED</th>
               <th scope="col">CREATED _AT</th>
               <th scope="col">Action</th>
          </tr>
         </thead>
       <tbody>


         @foreach ($trashCat as $product)

    <tr>
      <th scope="row">{{$trashCat->firstItem()+$loop->index}}</th>
      <td>{{$product->product_name}}</td>
      <td>{{$product->name}}</td>
      <td>

       @if($product->created_at == NULL)
      <span class="text_danger">No time set</span>
      @else

      {{ $product->created_at->diffForHumans()}}
      @endif

       </td>
       <td>

       <a href="{{ url('Product/restore/'.$product->id) }}" class="btn btn-primary">Restore</a>
       <a href="{{ url('pdelete/Product/'.$productF->id) }}" class="btn btn-danger">P-Delete</a>
       </td>
       </tr>
      @endforeach

   </tbody>
   </table>
     {{$trashCat->links()}}


             </div>
           </div>
       </div>
    </div>
    <div class="col-md-4"> </div>

 @endsection
