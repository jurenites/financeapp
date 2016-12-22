<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;

use App\BudgetCategory;

class BudgetCategoryController extends Controller
{
    protected $currentNamespace = 'Shared';

    public function index()
    {
        $budgetCategories = BudgetCategory::all();
        return view('shared.categories.index', compact('budgetCategories'));
    }

    public function store(Request $request)
    {
        return $this->save(new BudgetCategory, $request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->save(BudgetCategory::findOrFail($id), $request->all());
    }

    public function destroy(Request $request, $id)
    {
        $budgetCategory = BudgetCategory::findOrFail($id);
        $budgetCategory->delete();
        return $id;
    }

    private function save($budgetCategory, $data)
    {
        $budgetCategory->name = $data['name'];
        $budgetCategory->save();
        return $budgetCategory->id;
    }
}
