@extends('mahasiswas.layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
    <div class="card" style="width: 24rem;">
        <div class="card-header">Tambah Mahasiswa</div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="post" action="{{ route('mahasiswa.store') }}" id="myForm" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="nim">Nim</label>
            <input type="text" name="nim" class="form-control" id="nim" aria-describedby="nim" >
        </div>
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="name" name="name" class="form-control" id="name" aria-describedby="name" >
        </div>
        <div class="form-group">
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" class="form-control select2">
                @foreach ($kelas as $kls)
                    <option value="{{$kls->id}}" {{ old('kelas_id') == "$kls->id" ? 'selected' : '' }}>{{$kls->nama_kelas}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <input type="jurusan" name="jurusan" class="form-control" id="jurusan" aria-describedby="jurusan" >
        </div>
        <div class="form-group">
            <label for="image">Foto: </label>
            <input type="file" class="form-control" required="required" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    </div>
    </div>
</div>
@endsection