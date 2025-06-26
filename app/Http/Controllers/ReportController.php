<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ExpensePerson;
use App\Models\Wallet;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Show HTML report
    public function expenses(Request $request)
    {
        $type = $request->input('type', 'all');
        $person = $request->input('person');
        $category = $request->input('category');
        $search = $request->input('search');
        $filterRange = $this->getFilterRange($request);

        $query = Transaction::with(['category', 'person'])
            ->where('user_id', $request->user()->id);

        // Date filters
        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '30days') {
            $query->where('date', '>=', now()->subDays(30));
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by type
        if ($type === 'income') {
            $query->where('type', 'income');
        } elseif ($type === 'expense' || $type === 'expenses_only') {
            $query->where('type', 'expense');
        }

        // Filter by person
        if ($person) {
            $query->where('person_id', $person);
        }

        // Filter by category
        if ($category) {
            $query->where('category_id', $category);
        }

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('person', function ($q3) use ($search) {
                      $q3->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(12);

        $people = ExpensePerson::where('user_id', $request->user()->id)
            ->select('id', 'name')->distinct()->orderBy('name')->get();

        $categories = \App\Models\Category::where('user_id', $request->user()->id)
            ->orderBy('name')->get();

        return view('reports.expenses', compact('expenses', 'people', 'categories', 'filterRange', 'type'));
    }

    // Generate PDF report
    public function expensesPdf(Request $request)
    {
        $type = $request->input('type', 'all');
        $person = $request->input('person');
        $filterRange = $this->getFilterRange($request);

        $query = Transaction::with(['category', 'person'])
            ->where('user_id', $request->user()->id);

        // Date filters
        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '30days') {
            $query->where('date', '>=', now()->subDays(30));
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        // Filter by type/person
        if ($type === 'expenses_only') {
            $query->where('type', 'expense');
        } elseif ($type === 'person' && $person) {
            $query->whereHas('person', function ($q) use ($person) {
                $q->where('name', $person);
            })->where('type', 'expense');
        }

        $expenses = $query->orderBy('date', 'asc')->get();

        // Group by person and sort each group by date
        $groupedExpenses = $expenses->groupBy(function ($item) {
            return $item->person->name ?? 'N/A';
        })->map(function ($group) {
            return $group->sortBy('date');
        });

        // Get current account and cash balance from balances table
        $userId = $request->user()->id;
        $wallets = Wallet::where('user_id', $userId)->get();

        $pdf = Pdf::loadView('reports.expense_report', [
            'expenses' => $groupedExpenses,
            'filterRange' => $filterRange,
            'reportType' => $type,
            'wallets' => $wallets,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('expense_report_' . now()->format('Ymd_His') . '.pdf');
    }

    // Get readable date range
    private function getFilterRange(Request $request)
    {
        if ($request->filter === '7days') {
            return now()->subDays(7)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->filter === '15days') {
            return now()->subDays(15)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->filter === '30days') {
            return now()->subDays(30)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->start_date && $request->end_date) {
            return Carbon::parse($request->start_date)->format('d-m-Y') . ' to ' . Carbon::parse($request->end_date)->format('d-m-Y');
        }

        return 'Full Report';
    }
}
