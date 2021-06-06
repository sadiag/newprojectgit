
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Category
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


  @foreach ($categories as $category)

    <tr>
      <th scope="row">{{$categories->firstItem()+$loop->index}}</th>
      <td>{{$category->category_name}}</td>
      <td>{{$category->name}}</td>
      <td>

       @if($category->created_at == NULL)
      <span class="text_danger">No time set</span>
      @else
      {{ Carbon\Carbon::parse ($category->created_at)->diffForHumans()}}
      @endif
       </td>
       <td>
       <a href="{{ url('Category/Edit/'.$category->id) }}" class="btn btn-primary">Edit</a>
       <a href="{{ url('Softdelete/Category/'.$category->id) }}" class="btn btn-danger">Delete</a>
       </td>

    </tr>
      @endforeach

  </tbody>
</table>
{{$categories->links()}}


            </div>
            </div>
            </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add Category
                </div>

                <div class="card-body">

                <form action="{{route('store.category')}}" method="POST">
                @csrf
    <div class="form-group">
    <label for="exampleInputEmail1">Add Category</label>
    <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror"
    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Category">

    @error('category_name')
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


         @foreach ($trashCat as $category)

    <tr>
      <th scope="row">{{$trashCat->firstItem()+$loop->index}}</th>
      <td>{{$category->category_name}}</td>
      <td>{{$category->name}}</td>
      <td>

       @if($category->created_at == NULL)
      <span class="text_danger">No time set</span>
      @else

      {{ $category->created_at->diffForHumans()}}
      @endif

       </td>
       <td>

       <a href="{{ url('Category/restore/'.$category->id) }}" class="btn btn-primary">Restore</a>
       <a href="{{ url('pdelete/Category/'.$category->id) }}" class="btn btn-danger">P-Delete</a>
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
