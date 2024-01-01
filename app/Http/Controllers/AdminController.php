<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Alat;
use App\Models\User;
use App\Models\Carts;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Penyewa;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\HistoryPenyewa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        $topUser = Penyewa::withCount('payment')->orderBy('payment_count', 'DESC')->limit(5)->get();
        $topProducts = Alat::withCount('order')->orderBy('order_count', "DESC")->limit(5)->get();
        return view('admin.admin',[
            'loggedUsername' => Auth::user()->name,
            'total_user' => Penyewa::count(),
            'total_alat' => Alat::count(),
            'total_kategori' => Category::count(),
            'total_penyewaan' => Payment::count(),
            'top_user' => $topUser,
            'top_products' => $topProducts
        ]);
    }

    public function usermanagement() {

        $user = Penyewa::with(['payment'])->get();

        return view('admin.user.user',[
            'penyewa' => $user->where('role', 0)
        ]);
    }
    public function detailUser($id){
        $user = Penyewa::findOrFail($id);
        return view('admin.user.detail',[
            'penyewa'=>$user
        ]);
    }

   

    public function newUser(Request $request) {
        $validated = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'gambar-ktp' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // dd($request->all());
        if ($request->hasFile('gambar-ktp')) {
            $file = $request->file('gambar-ktp');
            $nama_file = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file ke storage
            $path = $file->storeAs('public/gambar_ktp', $nama_file);
    
            // Buat link ke direktori public
            $url = Storage::url($path);
            // dd($url);
    
            Penyewa::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telepon' => $request->telepon,
                'ktp' => $url, // Simpan URL file ke dalam database
            ]);
        }
    
        $request->session()->flash('registrasi', 'Registrasi Penyewa Berhasil');
        return redirect()->route('admin.user');
    }



    public function newOrderIndex($penyewaId) {
        $penyewa = Penyewa::find($penyewaId);
        $alat = Alat::with(['category'])->get();
        $cart = Carts::with(['penyewa'])->where('penyewa_id', $penyewaId)->get();

        return view('admin.penyewaan.reservasibaru',[
            'penyewa' => $penyewa,
            'alat' => $alat,
            'cart' => $cart,
            'total' => $cart->sum('harga')
        ]);
    }

    public function createNewOrder(Request $request, $penyewaId) {
        $cart = Carts::where('penyewa_id', $penyewaId)->get();
        $pembayaran = new Payment();

        $pembayaran->no_invoice = $penyewaId."/".Carbon::now()->timestamp;
        $pembayaran->penyewa_id = $penyewaId;
        $pembayaran->status = 1;
        $pembayaran->total = $cart->sum('harga');
        $pembayaran->save();

        foreach($cart as $c) {
            Order::create([
                'alat_id' => $c->alat_id,
                'penyewa_id' => $c->penyewa_id,
                'payment_id' => Payment::where('penyewa_id',$penyewaId)->orderBy('id','desc')->first()->id,
                'durasi' => $c->durasi,
                'starts' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time'])),
                'ends' => date('Y-m-d H:i', strtotime($request['start_date'].$request['start_time']."+".$c->durasi." hours")),
                'harga' => $c->harga,
                'status' => 1
            ]);
            $c->delete();
        }

        return redirect(route('penyewaan.index'));
    }

}
