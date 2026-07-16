<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuTb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = MenuTb::latest()->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_name'        => 'required|string|max:255',
            'menu_description' => 'nullable|string|max:1000',
            'menu_price'       => 'nullable|integer|min:0|max:999999999',
            'menu_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('menu_image')) {
            $validated['menu_image'] = $request->file('menu_image')
                ->store('menus', 'public');
        }

        MenuTb::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(MenuTb $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, MenuTb $menu)
    {
        $validated = $request->validate([
            'menu_name'        => 'required|string|max:255',
            'menu_description' => 'nullable|string|max:1000',
            'menu_price'       => 'nullable|integer|min:0|max:999999999',
            'menu_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('menu_image')) {
            // Delete old image
            if ($menu->menu_image) {
                Storage::disk('public')->delete($menu->menu_image);
            }
            $validated['menu_image'] = $request->file('menu_image')
                ->store('menus', 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(MenuTb $menu)
    {
        if ($menu->menu_image) {
            Storage::disk('public')->delete($menu->menu_image);
        }
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
