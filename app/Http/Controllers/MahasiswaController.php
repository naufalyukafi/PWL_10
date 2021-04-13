<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     $search = request()->query('search');
    //     if($search) {
    //         // dd(request()->query('search'));
    //         $posts = Mahasiswa::where('name', 'LIKE', "%{$search}%")->paginate(3);
    //     } else {
    //         $posts = Mahasiswa::with('kelas')->get();
    //     }
        
        //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        $posts = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('nim', 'desc')->paginate(5);
        return view('mahasiswas.index', ['mahasiswa' => $posts, 'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'name' => 'required',
            'kelas_id' => 'required',
            'jurusan'=> 'required',
        ]);
        // fungsi eloquent untuk menambahkan data
        // Mahasiswa::create($request->all());

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->name = $request->get('name');
        $mahasiswa->jurusan = $request->get('jurusan');

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas_id');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
            
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan nim mahasiswa
        //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($nim);
        // $Mahasiswa = Mahasiswa::find($nim);
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        return view('mahasiswas.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    public function showKhs($nim) {
        $mahasiswa = Mahasiswa::with('kelas', 'matakuliah')->where('nim', $nim)->first();
        return view('mahasiswas.detailKhs', compact('mahasiswa'));
        // dd($mahasiswa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        // $Mahasiswa = Mahasiswa::find($nim);
        //menampilkan detail data menemukan berdasarkan nim mahasiswa untuk di edit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); //menampilkan data dari tabel kelas
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
        $request->validate([
            'nim' => 'required',
            'name' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required', 
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('nim');
        $mahasiswa->name = $request->get('name');
        $mahasiswa->jurusan = $request->get('jurusan');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');
        //fungsi eloquent untuk mengupdate data inputan kita
        // Mahasiswa::find($nim)->update($request->all());

        //fungsi eloquent untuk mengupdate data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        Mahasiswa::find($nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
}