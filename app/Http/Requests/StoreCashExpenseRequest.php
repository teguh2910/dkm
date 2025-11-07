<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'barcode_id' => ['required', 'exists:barcodes,id'],
            'tanggal' => ['required', 'date'],
            'dibayarkan_kepada' => ['required', 'string', 'max:255'],
            'sebesar' => ['required', 'numeric', 'min:0'],
            'terbilang' => ['required', 'string'],
            'keterangan2' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'year' => 'tahun',
            'barcode_id' => 'kode barcode',
            'tanggal' => 'tanggal',
            'dibayarkan_kepada' => 'dibayarkan kepada',
            'sebesar' => 'jumlah',
            'terbilang' => 'terbilang',
            'keterangan2' => 'keterangan',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'year.required' => 'Tahun wajib dipilih',
            'year.integer' => 'Tahun harus berupa angka',
            'year.min' => 'Tahun minimal 2000',
            'year.max' => 'Tahun maksimal 2100',
            'barcode_id.required' => 'Kode barcode wajib dipilih',
            'barcode_id.exists' => 'Kode barcode tidak valid',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'dibayarkan_kepada.required' => 'Dibayarkan kepada wajib diisi',
            'sebesar.required' => 'Jumlah wajib diisi',
            'sebesar.numeric' => 'Jumlah harus berupa angka',
            'sebesar.min' => 'Jumlah harus lebih dari 0',
            'terbilang.required' => 'Terbilang wajib diisi',
            'expense_category_id.required' => 'Kategori pengeluaran wajib dipilih',
            'expense_category_id.exists' => 'Kategori pengeluaran tidak valid',
        ];
    }
}
