<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AplikasiExport;
use App\Exports\LowonganExport;
use App\Exports\LogbookExport;
use App\Exports\LogbooksIndexExport;
use App\Exports\NilaiExport;

class ExportController extends Controller
{
	protected function responseFromExport($export, string $filename)
	{
		$content = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

		return response($content, 200, [
			'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'Content-Disposition' => 'attachment; filename="'.$filename.'"',
		]);
	}
	// Controller now delegates to Export classes via Excel::download

	public function aplikasis(Request $request)
	{
		return $this->responseFromExport(new AplikasiExport, 'aplikasis.xlsx');
	}

	public function lowongans(Request $request)
	{
		return $this->responseFromExport(new LowonganExport, 'lowongans.xlsx');
	}

	public function logbook(Request $request, $aplikasi)
	{
		return $this->responseFromExport(new LogbookExport($aplikasi), 'logbook-'.$aplikasi.'.xlsx');
	}

	public function logbooksIndex(Request $request, $aplikasi)
	{
		return $this->responseFromExport(new LogbooksIndexExport($aplikasi), 'logbooks-'.$aplikasi.'.xlsx');
	}

	public function nilai(Request $request)
	{
		return $this->responseFromExport(new NilaiExport, 'nilai.xlsx');
	}
}

