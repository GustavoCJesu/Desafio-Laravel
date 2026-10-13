<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplianceReportRequest;
use App\Models\Employee;
use App\Models\Sector;
use App\Models\SessionTraining;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Situações que contam como conformes, da melhor para a pior.
     * A ordem também decide qual registro representa o funcionário numa norma.
     *
     * @var array<string, int>
     */
    private const STATUS_RANK = [
        'Válido' => 0,
        'A vencer' => 1,
        'Vencido' => 2,
        'Pendente' => 3,
        'Certificado não emitido' => 4,
        'Reprovado por carga horária' => 5,
    ];

    private const COMPLIANT_STATUSES = ['Válido', 'A vencer'];

    public function index(): View
    {
        return view('pages.reports.index');
    }

    /**
     * Relatório de conformidade apresentável em auditoria.
     */
    public function compliance(ComplianceReportRequest $request): View
    {
        $filters = $request->validated();
        $report = $this->complianceReport($filters);

        return view('pages.reports.compliance', [
            'filters' => $filters,
            'sectors' => Sector::orderBy('name')->get(),
            'norms' => SessionTraining::distinct()->orderBy('norm')->pluck('norm'),
            'sectorName' => isset($filters['sector_id']) ? Sector::find($filters['sector_id'])?->name : null,
            'issuedAt' => now(),
            'issuedBy' => auth()->user()->employee->name ?? auth()->user()->email,
            'issuedByRole' => auth()->user()->userRole->title ?? null,
            'statusRank' => self::STATUS_RANK,
            ...$report,
        ]);
    }

    /**
     * Mesmos dados do relatório, em CSV (separador ";", compatível com o Excel em português).
     */
    public function complianceExport(ComplianceReportRequest $request): StreamedResponse
    {
        $report = $this->complianceReport($request->validated());

        $columns = ['Matrícula', 'Funcionário', 'Setor', 'Cargo', 'Norma', 'Treinamento', 'Situação',
            'Carga horária (h)', 'Horas cumpridas (h)', 'Instrutor', 'Código do certificado', 'Emissão', 'Validade', 'EPIs'];

        return response()->streamDownload(function () use ($report, $columns) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, $columns, ';');

            foreach ($report['visibleRows'] as $row) {
                fputcsv($output, array_map($this->neutralizeFormula(...), [
                    $row['registration'], $row['employee'], $row['sector'], $row['role'], $row['norm'], $row['title'],
                    $row['status'], $row['hours'], $row['attended_hours'], $row['instructor'], $row['code'] ?? '',
                    $row['issued_at'] ?? '', $row['expires_at'] ?? '', implode(', ', $row['epis']),
                ]), ';');
            }

            fclose($output);
        }, 'conformidade-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Uma linha por funcionário ativo convocado e norma, com a melhor situação encontrada.
     * Os indicadores consideram todas as linhas do escopo; a tabela pode mostrar só as pendências.
     *
     * @param  array{sector_id?: int|null, norm?: string|null, only_pending?: bool|null}  $filters
     * @return array<string, mixed>
     */
    private function complianceReport(array $filters): array
    {
        $sectorId = $filters['sector_id'] ?? null;
        $norm = $filters['norm'] ?? null;

        $trainings = SessionTraining::query()
            ->with([
                'instructor',
                'epis',
                'employees' => fn ($query) => $query
                    ->where('status', 'Ativo')
                    ->when($sectorId, fn ($query) => $query->where('sector_id', $sectorId))
                    ->with(['sector', 'companyRole']),
                'classes.attendanceSession',
                'certificate.epis',
            ])
            ->where('status', '!=', 'Cancelado')
            ->when($norm, fn ($query) => $query->where('norm', $norm))
            ->orderBy('norm')
            ->orderBy('id')
            ->get();

        $rows = $trainings
            ->flatMap(fn (SessionTraining $training) => $training->employees->map(
                fn (Employee $employee) => $this->complianceEntry($training, $employee)
            ))
            ->groupBy(fn (array $entry) => $entry['employee_id'].'|'.$entry['norm'])
            ->map(fn (Collection $entries) => $entries
                ->sort(fn (array $a, array $b) => [$a['rank'], -$a['expires_ts']] <=> [$b['rank'], -$b['expires_ts']])
                ->first())
            ->sort(fn (array $a, array $b) => [$a['sector'], $a['employee'], $a['norm']] <=> [$b['sector'], $b['employee'], $b['norm']])
            ->values();

        $visibleRows = ($filters['only_pending'] ?? false)
            ? $rows->reject(fn (array $row) => $row['compliant'])->values()
            : $rows;

        return [
            'trainings' => $trainings,
            'rows' => $rows,
            'visibleRows' => $visibleRows,
            'summary' => $this->summarize($rows),
            'byNorm' => $this->summarizeBy($rows, 'norm'),
            'bySector' => $this->summarizeBy($rows, 'sector'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function complianceEntry(SessionTraining $training, Employee $employee): array
    {
        $certificate = $training->certificate->firstWhere('employee_id', $employee->id);
        $attendedHours = $this->attendedHours($training, $employee);

        $status = match (true) {
            $certificate !== null => $certificate->currentStatus(),
            $training->status !== 'Concluído' => 'Pendente',
            $attendedHours < $training->min_hours => 'Reprovado por carga horária',
            default => 'Certificado não emitido',
        };

        return [
            'employee_id' => $employee->id,
            'employee' => $employee->name,
            'registration' => $employee->registration,
            'sector' => $employee->sector->name ?? 'Sem setor',
            'role' => $employee->companyRole->title ?? 'Sem cargo',
            'norm' => $training->norm,
            'title' => $training->title,
            'status' => $status,
            'rank' => self::STATUS_RANK[$status],
            'compliant' => in_array($status, self::COMPLIANT_STATUSES, true),
            'hours' => $training->class_min,
            'min_hours' => $training->min_hours,
            'attended_hours' => $attendedHours,
            'instructor' => $training->instructor->name ?? 'Não informado',
            'code' => $certificate ? sprintf('CERT-%s-%04d', $certificate->confirmed_at->format('Y'), $certificate->id) : null,
            'issued_at' => $certificate?->confirmed_at->format('d/m/Y'),
            'expires_at' => $certificate?->expires_at->format('d/m/Y'),
            'expires_ts' => $certificate?->expires_at->timestamp ?? 0,
            'epis' => ($certificate ? $certificate->epis : $training->epis)->pluck('name')->all(),
        ];
    }

    /**
     * Horas das aulas concluídas em que o funcionário compareceu.
     */
    private function attendedHours(SessionTraining $training, Employee $employee): float
    {
        return (float) $training->classes
            ->where('status', 'Concluído')
            ->filter(fn ($class) => $class->attendanceSession
                ->where('employee_id', $employee->id)
                ->where('employee_attendance', 'Compareceu')
                ->isNotEmpty())
            ->sum('duration_hours');
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $rows
     * @return array<string, mixed>
     */
    private function summarize(Collection $rows): array
    {
        $employees = $rows->groupBy('employee_id');

        return [
            'requirements' => $rows->count(),
            'compliant' => $rows->where('compliant', true)->count(),
            'rate' => $this->percentage($rows->where('compliant', true)->count(), $rows->count()),
            'employees' => $employees->count(),
            'employees_compliant' => $employees->filter(fn (Collection $own) => $own->every(fn (array $row) => $row['compliant']))->count(),
            'by_status' => collect(array_keys(self::STATUS_RANK))->mapWithKeys(fn (string $status) => [$status => $rows->where('status', $status)->count()])->all(),
        ];
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $rows
     * @return Collection<string, array{total: int, compliant: int, rate: int}>
     */
    private function summarizeBy(Collection $rows, string $key): Collection
    {
        return $rows->groupBy($key)->sortKeys()->map(fn (Collection $group) => [
            'total' => $group->count(),
            'compliant' => $group->where('compliant', true)->count(),
            'rate' => $this->percentage($group->where('compliant', true)->count(), $group->count()),
        ]);
    }

    private function percentage(int $part, int $total): int
    {
        return $total === 0 ? 0 : (int) round($part * 100 / $total);
    }

    /**
     * Impede que o Excel interprete texto vindo do banco como fórmula.
     */
    private function neutralizeFormula(mixed $value): mixed
    {
        return is_string($value) && preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value;
    }
}
