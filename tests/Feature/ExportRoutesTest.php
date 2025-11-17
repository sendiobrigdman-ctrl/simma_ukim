<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Aplikasi;
use App\Models\Lowongan;
use App\Models\Logbook;
use App\Models\Nilai;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExportRoutesTest extends TestCase
{
	use RefreshDatabase;

	public function test_aplikasis_export_returns_xlsx_headers(): void
	{
		$user = User::factory()->create(['role' => 'admin']);

		Aplikasi::factory()->create(['name' => 'Demo Aplikasi']);

		$resp = $this->actingAs($user)
			->get(route('export.aplikasis'));

		$resp->assertStatus(200)
			->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$this->assertStringContainsString('attachment', $resp->headers->get('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'xlsx');
		file_put_contents($path, $resp->getContent());
		$spreadsheet = IOFactory::load($path);
		$sheet = $spreadsheet->getActiveSheet();
		$this->assertEquals('Aplikasi', $sheet->getCell('A1')->getValue());
		$this->assertEquals('Demo Aplikasi', $sheet->getCell('A2')->getValue());
		@unlink($path);
	}

	public function test_lowongans_export_returns_xlsx_headers(): void
	{
		$user = User::factory()->create(['role' => 'admin']);

		Lowongan::factory()->create(['title' => 'Demo Lowongan']);

		$resp = $this->actingAs($user)
			->get(route('export.lowongans'));

		$resp->assertStatus(200)
			->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$this->assertStringContainsString('attachment', $resp->headers->get('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'xlsx');
		file_put_contents($path, $resp->getContent());
		$spreadsheet = IOFactory::load($path);
		$sheet = $spreadsheet->getActiveSheet();
		$this->assertEquals('Lowongan', $sheet->getCell('A1')->getValue());
		$this->assertEquals('Demo Lowongan', $sheet->getCell('A2')->getValue());
		@unlink($path);
	}

	public function test_logbook_export_returns_xlsx_headers(): void
	{
		$user = User::factory()->create(['role' => 'admin']);

		$aplikasi = Aplikasi::factory()->create();
		Logbook::factory()->create(['aplikasi_id' => $aplikasi->id, 'content' => "Entry for aplikasi {$aplikasi->id}"]); 

		$resp = $this->actingAs($user)
			->get(route('export.logbook', ['aplikasi' => $aplikasi->id]));

		$resp->assertStatus(200)
			->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$this->assertStringContainsString('attachment', $resp->headers->get('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'xlsx');
		file_put_contents($path, $resp->getContent());
		$spreadsheet = IOFactory::load($path);
		$sheet = $spreadsheet->getActiveSheet();
		$this->assertEquals('Logbook', $sheet->getCell('A1')->getValue());
		$this->assertEquals('Entry for aplikasi 1', $sheet->getCell('A2')->getValue());
		@unlink($path);
	}

	public function test_logbooks_index_export_returns_xlsx_headers(): void
	{
		$user = User::factory()->create(['role' => 'admin']);

		$aplikasi = Aplikasi::factory()->create();
		Logbook::factory()->create(['aplikasi_id' => $aplikasi->id, 'content' => "Index entry for aplikasi {$aplikasi->id}"]); 

		$resp = $this->actingAs($user)
			->get(route('export.logbooks-index', ['aplikasi' => $aplikasi->id]));

		$resp->assertStatus(200)
			->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$this->assertStringContainsString('attachment', $resp->headers->get('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'xlsx');
		file_put_contents($path, $resp->getContent());
		$spreadsheet = IOFactory::load($path);
		$sheet = $spreadsheet->getActiveSheet();
		$this->assertEquals('Logbooks Index', $sheet->getCell('A1')->getValue());
		$this->assertEquals('Index entry for aplikasi 1', $sheet->getCell('A2')->getValue());
		@unlink($path);
	}

	public function test_nilai_export_returns_xlsx_headers(): void
	{
		$user = User::factory()->create(['role' => 'admin']);

		Nilai::factory()->create(['value' => 100]);

		$resp = $this->actingAs($user)
			->get(route('export.nilai'));

		$resp->assertStatus(200)
			->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$this->assertStringContainsString('attachment', $resp->headers->get('Content-Disposition'));

		$path = tempnam(sys_get_temp_dir(), 'xlsx');
		file_put_contents($path, $resp->getContent());
		$spreadsheet = IOFactory::load($path);
		$sheet = $spreadsheet->getActiveSheet();
		$this->assertEquals('Nilai', $sheet->getCell('A1')->getValue());
		$this->assertEquals(100, $sheet->getCell('A2')->getValue());
		@unlink($path);
	}
}
