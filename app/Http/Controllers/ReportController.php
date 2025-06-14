<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function expenseReport(Request $request)
    {
        $expenses = $this->getFilteredExpenses($request);
        $filterRange = $this->getFilterRange($request);
        return view('reports.expense_report', compact('expenses', 'filterRange'));
    }

    public function exportExpensePdf(Request $request)
    {
        $expenses = $this->getFilteredExpenses($request);
        $filterRange = $this->getFilterRange($request);
        $pdf = Pdf::loadView('reports.expense_pdf', compact('expenses', 'filterRange'));
        return $pdf->stream('expense_report.pdf');
    }
    
    private function getFilterRange($request)
    {
        if ($request->filter === '7days') {
            return now()->subDays(7)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->filter === '15days') {
            return now()->subDays(15)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->filter === '30days') {
            return now()->subDays(30)->format('d-m-Y') . ' to ' . now()->format('d-m-Y');
        } elseif ($request->start_date && $request->end_date) {
            return \Carbon\Carbon::parse($request->start_date)->format('d-m-Y') . ' to ' . \Carbon\Carbon::parse($request->end_date)->format('d-m-Y');
        }
        return null;
    }

    private function getFilteredExpenses($request)
    {
        $query = \App\Models\Expense::query();

        if ($request->filter === '7days') {
            $query->where('date', '>=', now()->subDays(7));
        } elseif ($request->filter === '15days') {
            $query->where('date', '>=', now()->subDays(15));
        } elseif ($request->filter === '30days') {
            $query->where('date', '>=', now()->subDays(30));
        } elseif ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        return $query->orderBy('updated_at', 'desc')->get();
    }
}
