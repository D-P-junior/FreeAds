<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use App\Models\AdPhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ======= USER =======//

    //liste les users
        public function users(){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $users = User::latest()->paginate(10);
            return view('admin.users', compact('users'));
        }
    //edit user
        public function editUsers($id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $user = User::findOrFail($id);
            return view('admin.edit-user', compact('user'));
        }
    //sauvegarder user
        public function updateUser(Request $request, $id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $user = User::findOrFail($id);

            $request->validate([
                    'login'       => 'required|min:3|unique:users,login,' . $user->id,
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'phone' => 'required',
                    'role'       => 'required|in:user,admin'
                ]);

            $user->update([
                    'login' => $request->login,
                    'email'       => $request->email,
                    'phone' => $request->phone,
                    'role' => $request->role
                ]);

            return redirect('/admin/users');

        }

    //suprimer un user
        public function destroyUser($id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $user = User::findOrFail($id);
            $user->delete();
            return redirect('/admin/users');
        }

// ======= ad =========//
    //listes toyes les ad
        public function ads(){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $ads = Ad::with(['user', 'category', 'photos'])->latest()->paginate(8);
            return view('admin.ads', compact('ads'));
        }
    //modifier add
        public function editAd($id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $ad = Ad::findOrFail($id);
            $categories = Category::all();
            return view('admin.edit-ad', compact('ad', 'categories'));
        }

    //sauvegarder add
        public function updateAd(Request $request, $id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $ad = Ad::findOrFail($id);

            $request->validate([
                    'title'       => 'required|min:4',
                    'category_id' => 'required|exists:categories,id',
                    'description' => 'required|min:10',
                    'price'       => 'required|numeric|min:0',
                    'localisation'    => 'required',
                    'condition'   => 'required|in:neuf,bon etat,abimé',
                    'photos.*'    => 'image|mimes:jpeg,png,jpg|max:2048'

                ]);

                $ad->update([
                    'category_id' => $request->category_id,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'price'       => $request->price,
                    'localisation'    => $request->localisation,
                    'condition'   => $request->condition,
                ]);

                if ($request->hasFile('photos')) {
                    // Supprimer les anciennes photos
                    $ad->photos()->delete();

                    // Sauvegarder les nouvells
                    foreach ($request->file('photos') as $photo) {
                        $path = $photo->store('ads', 'public');
                        AdPhoto::create([
                            'ad_id' => $ad->id,
                            'path'  => $path,
                        ]);
                    }
                }

            return redirect('/admin/ads');
        }

    //supimer uen ad
        public function destroyAd($id){
            if (Auth::user()->role !== 'admin'){
                return redirect('/');
            }
            $user = Ad::findOrFail($id);
            $user->delete();
            return redirect('/admin/ads');
        }

    // add category
    public function showCat(){
        if (Auth::user()->role !== 'admin'){
            return redirect('/');
        }
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function adCategory(Request $request){
        if (Auth::user()->role !== 'admin'){
            return redirect('/');
        }
        $request->validate([
            'name' => 'required|min:5'
        ]);

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);
        return redirect('/admin/users');

    }
}
