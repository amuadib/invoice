<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class CetakInvoiceController extends Controller
{
    public function cetak(int $id)
    {
        $data = Invoice::find($id);
        if (!$data) {
            abort(404);
        }
        return view('invoice', [
            'data' => $data,
            'invoice_no' => str_pad($data->id, 3, '0', STR_PAD_LEFT) . '/' . $this->decToRoman(substr($data->created_at, 5, 2)) . '/' . substr($data->created_at, 0, 4),
            'user' => auth()->user()
        ]);
    }
    // https://www.geeksforgeeks.org/converting-decimal-number-lying-between-1-to-3999-to-roman-numerals/
    private function decToRoman(int $number): string
    {
        $roman = '';
        $num = [1, 4, 5, 9, 10, 40, 50, 90, 100, 400, 500, 900, 1000];
        $sym = ["I", "IV", "V", "IX", "X", "XL", "L", "XC", "C", "CD", "D", "CM", "M"];
        $i = 12;
        while ($number > 0) {
            $div = floor($number / $num[$i]);
            $number = $number % $num[$i];
            while ($div--) {
                $roman .= $sym[$i];
            }
            $i--;
        }
        return $roman;
    }
}
