@extends("master")
@section("content")
<div class="row justify-content-center">

<div class="col-md-10" style="text-align:center;">
<h1> Clientes </h1>
@if (Session::has('message'))
<p class="alert alert-success"> {{Session::get('message')}} </p>
@endif
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Nombres</th>
      <th scope="col">Apellidos</th>
      <th scope="col">Email</th>
      <th scope="col">Telefono</th>
      <th scope="col">Direccion</th>
      <th scope="col">Foto</th>
      <th scope="col">Del</th>
    </tr>
  </thead>
  <tbody>
    


    @foreach ($customers as $customer)
    <tr>
      <th scope="row"><a href="{{route ('customers.show', $customer->id)}}" >  {{$customer->id}}</a></th>
      <td>{{$customer->firstname}}</td>
      <td>{{$customer->lastname}}</td>
      <td>{{$customer->email}}</td>
      <td>{{$customer->phone}}</td>
      <td>{{$customer->address}}</td>
      <td><img src=" {{$customer->photo}}" height="30px" ></td>
      <td>
      {!! Form::open(['route' => ['customers.destroy', $customer->id], 'method' => 'DELETE']) !!}
      <button type="submit" class="btn btn-danger"> Eliminar </button>
      {!!   Form::close()!!}
      
      </td>
    </tr>
   
    @endforeach
    </tbody>
</table>
 {{$customers->links()}}
</div>
</div>


@endsection