<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstrategiaWms extends Model
{
    protected $primaryKey = 'cd_estrategia_wms';

    // Se a chave primária não for auto-incremental, ajuste esta linha
    public $incrementing = true;

    // Definindo o tipo de chave primária se não for do tipo int
    protected $keyType = 'int';

    // Nome da tabela se diferente do nome padrão (convencional)
    protected $table = 'tb_estrategia_wms';

    protected $fillable = [
        'ds_estrategia_wms',
        'nr_prioridade',
        'dt_registro',
        'dt_modificado',
    ];

    // Desabilitar timestamps automáticos se não for necessário
    public $timestamps = false;

    public function horariosPrioridade()
    {
        return $this->hasMany(EstrategiaWmsHorarioPrioridade::class, 'cd_estrategia_wms', 'cd_estrategia_wms');
    }
}
