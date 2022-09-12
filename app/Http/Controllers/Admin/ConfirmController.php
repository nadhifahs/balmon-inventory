<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Yajra\DataTables\Facades\DataTables;

class ConfirmController extends Controller
{
    public function index()
    {
        $mainPageTitle = 'Confirm Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Home Confirm';

        return view('admin.confirm.scan', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function edit($id)
    {
        $mainPageTitle = 'Confirm Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Update Confirm';

        $status = [
            'WAITING ACCEPTMENT' => 'SETUJUI PEMINJAMAN',
            'READY TO PICKUP' => 'SUDAH DIAMBIL',
            'RENT' => 'SUDAH DIKEMBALIKAN',
            'RETURN' => '',
        ];

        $cart = Cart::with('cart_detail', 'cart_detail.product', 'admin')
            ->where('rent_code', $id)
            ->first();
        $cartStatus = $status[$cart->status];
        return view('admin.confirm.edit', compact('cart', 'mainPageTitle', 'subPageTitle', 'pageTitle', 'cartStatus'));
    }

    public function listRent(Request $request)
    {
        $mainPageTitle = 'Rent Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Index Rent';

        if ($request->ajax()) {
            $cartData = Cart::with('user')
                ->whereNotIn('status', ['WAITING'])
                ->select();
            return datatables()
                ::of($cartData)
                ->addIndexColumn()
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.confirm.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function report()
    {
        $mainPageTitle = 'Report Management';
        $subPageTitle = 'Main';
        $pageTitle = 'Index Report';

        return view('admin.report.index', compact('mainPageTitle', 'subPageTitle', 'pageTitle'));
    }

    public function export(Request $request)
    {
        if ($request->month) {
            $month = explode('-', $request->month)[0];
            $year = explode('-', $request->month)[1];

            $data = Cart::whereStatus('RETURN')
                ->whereMonth('updated_at', $month)
                ->whereYear('updated_at', $year)
                ->get();
        } else {
            $data = Cart::whereStatus('RETURN')->get();
        }

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Rent Transaction Report");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Export Data.xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Reference Code');
        $sheet->setCellValue('D1', 'Rent Code');
        $sheet->setCellValue('E1', 'Rent File');
        $sheet->setCellValue('F1', 'Rent Time');
        $sheet->setCellValue('G1', 'Return Time');
        $sheet->setCellValue('H1', 'Status');

        $no = 1;
        foreach ($data as $each) {
            $sheet->setCellValue('A' . $no + 1, $no);
            $sheet->setCellValue('B' . $no + 1, $each->name);
            $sheet->setCellValue('C' . $no + 1, $each->ref_code);
            $sheet->setCellValue('D' . $no + 1, $each->rent_code);
            $sheet->setCellValue('E' . $no + 1, $each->ref_file);
            $sheet->setCellValue('F' . $no + 1, $each->rent_time);
            $sheet->setCellValue('G' . $no + 1, $each->return_time);
            $sheet->setCellValue('H' . $no + 1, $each->status);
        }

        $writer = new Xls($spreadsheet);
        $writer->save('php://output');
        // $writer->save('Export.xls');
    }

    public function store(Request $request)
    {
        $status = [
            'WAITING ACCEPTMENT' => 'READY TO PICKUP',
            'READY TO PICKUP' => 'RENT',
            'RENT' => 'RETURN',
        ];

        $statusMsg = [
            'WAITING ACCEPTMENT' => 'Telah menyetujui peminjaman barang.',
            'READY TO PICKUP' => 'Telah meminjamkan barang.',
            'RENT' => 'Telah menerima barang pinjaman',
        ];

        $cartData = Cart::where('rent_code', $request->rent_code)->first();
        $msg = $statusMsg[$cartData->status];
        $cart = Cart::where('rent_code', $request->rent_code)->update([
            'status' => $status[$cartData->status],
            'admin_id' => Auth::guard('admin')->user()->id,
        ]);

        if ($cartData->status == 'READY TO PICKUP') {
            CartDetail::whereHas('cart', function ($query) use ($request) {
                $query->where('rent_code', $request->rent_code);
            })->update([
                'status' => 'RENT',
            ]);
        }

        return redirect()
            ->route('admin.home.index')
            ->with('status', $msg);
    }

    public function returnProduct($id, Request $request)
    {
        $this->validate($request, [
            'condition' => 'required',
        ]);
        $cartDetail = CartDetail::with('product')->whereId($id);
        $cartDetail->update(['status' => 'RETURN']);
        $cartDetail->first()->product->increment('quantity', 1);
        $cartDetail
            ->first()
            ->product()
            ->update([
                'condition' => $request->condition,
            ]);

        return back()->with('status', 'Success Dikembalikan');
    }

    public function getActionColumn($data)
    {
        $rentView = route('admin.scan.edit', $data->rent_code);
        return '<a href="' . $rentView . '" class="btn btn-outline-primary">Check</a>';
    }
}
