<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstrategiaWms;
use App\Models\EstrategiaWmsHorarioPrioridade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstrategiaWMSController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dsEstrategia' => 'required|string|max:255',
            'nrPrioridade' => 'required|integer',
            'horarios' => 'required|array',
            'horarios.*.dsHorarioInicio' => 'required|string|max:5|date_format:H:i',
            'horarios.*.dsHorarioFinal' => 'required|string|max:5|date_format:H:i',
            'horarios.*.nrPrioridade' => 'required|integer',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Insere o registro na tabela tb_estrategia_wms
            $estrategia = EstrategiaWms::create([
                'ds_estrategia_wms' => $validatedData['dsEstrategia'],
                'nr_prioridade' => $validatedData['nrPrioridade'],
                'dt_registro' => Carbon::now(),
                'dt_modificado' => Carbon::now(),
            ]);

            // Insere os registros na tabela tb_estrategia_wms_horario_prioridade
            foreach ($validatedData['horarios'] as $horario) {
                EstrategiaWmsHorarioPrioridade::create([
                    'cd_estrategia_wms' => $estrategia->cd_estrategia_wms,
                    'ds_horario_inicio' => $horario['dsHorarioInicio'],
                    'ds_horario_final' => $horario['dsHorarioFinal'],
                    'nr_prioridade' => $horario['nrPrioridade'],
                    'dt_registro' => Carbon::now(),
                    'dt_modificado' => Carbon::now(),
                ]);
            }
        });

        return response()->json(['message' => 'Estratégia WMS criada com sucesso.'], 201);
    }

    public function getPrioridade($cdEstrategia, $dsHora, $dsMinuto)
    {
        $time = sprintf('%02d:%02d', $dsHora, $dsMinuto); // Formata a hora e minuto para 'HH:MM'

        // Busca a estratégia com base no ID fornecido
        $estrategia = EstrategiaWms::find($cdEstrategia);

        if (!$estrategia) {
            return response()->json(['message' => 'Estratégia não encontrada.'], 404);
        }

        // Busca o intervalo de horário correspondente
        $horarioPrioridade = EstrategiaWmsHorarioPrioridade::where('cd_estrategia_wms', $cdEstrategia)
            ->where('ds_horario_inicio', '<=', $time)
            ->where('ds_horario_final', '>=', $time)
            ->orderBy('nr_prioridade', 'desc')
            ->first();

        // Retorna a prioridade do horário específico ou a prioridade padrão da estratégia
        $prioridade = $horarioPrioridade ? $horarioPrioridade->nr_prioridade : $estrategia->nr_prioridade;

        return response()->json(['prioridade' => $prioridade], 200);
    }
}
