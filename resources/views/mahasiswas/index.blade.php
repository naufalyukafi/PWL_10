@extends('mahasiswas.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-3">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-3">
                <div class="row ">
                    <div class="col-sm-auto"><a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a></div>
                </div>    
            </div>
            <div>
                <form class="input-group" action="{{ route('mahasiswa.index') }}" method="GET">
                    <input type="text" class="form-control" name="search" placeholder="Search by name mahasiswa">
                </form>
            </div>
        </div>
    </div>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
<table class="table table-bordered">
<tr>
    <th>Nim</th>
    <th>Nama</th>
    <th>Foto</th>
    {{-- <th>E-mail</th>
    <th>Tgl_Lahir</th> --}}
    <th>Kelas</th>
    <th>Jurusan</th>
    {{-- <th>No_Handphone</th> --}}
    <th width="280px">Action</th>
</tr>

{{-- @if (count($posts) > 0) --}}
    @foreach ($paginate as $Mahasiswa)
    <tr>
        <td>{{ $Mahasiswa->nim }}</td>
        <td>{{ $Mahasiswa->name }}</td>
        <td>
            <img width="100px" src="{{asset('storage/'.$Mahasiswa->foto)}}" alt="image" style="object-fit: cover">
        </td>
        {{-- <td>{{ $Mahasiswa->e_mail }}</td>
        <td>{{ $Mahasiswa->tgl_lahir }}</td> --}}
        <td>{{ $Mahasiswa->kelas->nama_kelas }}</td>
        <td>{{ $Mahasiswa->jurusan }}</td>
        <td>
            <form action="{{ route('mahasiswa.destroy', $Mahasiswa->nim) }}" method="POST">
                <a class="btn btn-info" href="{{ route('mahasiswa.show',$Mahasiswa->nim) }}">Show</a>
                <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$Mahasiswa->nim) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
                <a class="btn btn-warning" href="{{ route('mahasiswa.showKhs', $Mahasiswa->nim) }}">Nilai</a>
            </form>
        </td>
    </tr>
    
    @endforeach
{{-- @else
 <h4 class="text-danger">*User Not Found</h4>   
@endif --}}

</table>
<div class="d-flex float-right">
    {{$paginate->links('pagination::bootstrap-4')}}
</div>
@endsection