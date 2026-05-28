<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display the menu builder admin tree list.
     */
    public function index()
    {
        // Query root level items with active and inactive entries to manage fully
        $menuItems = MenuItem::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }])
            ->orderBy('sort_order', 'asc')
            ->get();

        return Inertia::render('Admin/MenuBuilder', [
            'menusList' => $menuItems,
        ]);
    }

    /**
     * Store a newly created menu item in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:menu_items,id',
            'is_active' => 'required|boolean',
        ]);

        // Auto calculate next sort order
        $maxSort = MenuItem::where('parent_id', $request->parent_id)->max('sort_order');
        $validated['sort_order'] = ($maxSort !== null ? $maxSort : -1) + 1;

        MenuItem::create($validated);

        return back()->with('success', 'Menu item created successfully.');
    }

    /**
     * Update the specified menu item properties.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:menu_items,id',
            'is_active' => 'required|boolean',
        ]);

        $menuItem->update($validated);

        return back()->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified menu item from database.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return back()->with('success', 'Menu item deleted successfully.');
    }

    /**
     * Batch save the reordered nested positions of all menu items.
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->items as $itemData) {
                MenuItem::where('id', $itemData['id'])->update([
                    'parent_id' => $itemData['parent_id'],
                    'sort_order' => $itemData['sort_order'],
                ]);
            }
        });

        return back()->with('success', 'Menu hierarchy updated successfully.');
    }
}
