<?php

use App\Services\ProrrogacaoService;
use App\Http\Requests\ProrrogacaoRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessarProrrogacaoJob;

beforeEach(function () {
    $this->withoutExceptionHandling();
    $this->seed();
});

/**
 * Testa a inserção de um único registro de prorrogação.
 *
 * @return void
 */
it('inserir um único registro de prorrogação', function () {
    $response = $this->post('/api/login', [
        'email' => 'AMANDAAG',
        'senha' => 'hNYLMM657*',
    ]);

    $token = $response->json('token');

    $data = [
        'configuracoes' => [
            'dias_mes' => 30,
            'ConsiderarIOF' => true,
            'recalculo' => false,
            'simulacao' => false,
            'contaRet' => 4,
        ],
        'Operacao_Parcelas' => [
            [
                'numeroDaParcela' => '1',
                'valorPresenteParcela' => 12.00,
                'vencimentoAnterior' => '2023-10-01',
                'vencimentoNovo' => '2023-11-01',
                'totalAReceber' => 12.00,
                'penalidade_taxa' => 0.05,
                'tipoProrrogacao' => 'P',
                'jurosPorAtraso' => 0,
                'descontoPorAntecipacao' => 0,
                'VaLorIOF' => 0,
                'Contrato' => '327',
                'Cronograma' => 9667,
            ]
        ]
    ];

    $request = new ProrrogacaoRequest($data);
    $this->withHeaders(['Authorization' => 'Bearer ' . $token]);

    $service = app(ProrrogacaoService::class);
    $result = $service->processarProrrogacao($request->validated());

    $this->assertDatabaseHas('icronoprorrogacao', [
        'NDOC' => '1',
        'VENCIMENTO_ANT' => '2023-10-01',
        'VENCIMENTO_NOVO' => '2023-11-01',
        'VALOR' => 12.00,
        'TPPRORROGACAO' => 'P',
        'CODOPERACAO' => '327',
        'CODCRONOGRAMA' => 9667,
    ]);
});

/**
 * Testa a inserção de registros em lote de prorrogação.
 *
 * @return void
 */
it('inserir registros em lote de prorrogação', function () {
    $data = [
        'configuracoes' => [
            'dias_mes' => 30,
            'ConsiderarIOF' => true,
            'recalculo' => false,
            'simulacao' => false,
            'contaRet' => 4,
        ],
        'Operacao_Parcelas' => [
            [
                'numeroDaParcela' => '1',
                'valorPresenteParcela' => 12.00,
                'vencimentoAnterior' => '2023-10-01',
                'vencimentoNovo' => '2023-11-01',
                'totalAReceber' => 12.00,
                'penalidade_taxa' => 0.05,
                'tipoProrrogacao' => 'P',
                'jurosPorAtraso' => 0,
                'descontoPorAntecipacao' => 0,
                'VaLorIOF' => 0,
                'Contrato' => '327',
                'Cronograma' => 9667,
            ],
            [
                'numeroDaParcela' => '2',
                'valorPresenteParcela' => 15.00,
                'vencimentoAnterior' => '2023-10-01',
                'vencimentoNovo' => '2023-11-01',
                'totalAReceber' => 15.00,
                'penalidade_taxa' => 0.05,
                'tipoProrrogacao' => 'P',
                'jurosPorAtraso' => 0,
                'descontoPorAntecipacao' => 0,
                'VaLorIOF' => 0,
                'Contrato' => '328',
                'Cronograma' => 9668,
            ]
        ]
    ];

    $request = new ProrrogacaoRequest($data);

    $service = app(ProrrogacaoService::class);
    $result = $service->processarProrrogacao($request->validated());

    $this->assertDatabaseHas('icronoprorrogacao', [
        'NDOC' => '1',
        'VENCIMENTO_ANT' => '2023-10-01',
        'VENCIMENTO_NOVO' => '2023-11-01',
        'VALOR' => 12.00,
        'TPPRORROGACAO' => 'P',
        'CODOPERACAO' => '327',
        'CODCRONOGRAMA' => 9667,
    ]);

    $this->assertDatabaseHas('icronoprorrogacao', [
        'NDOC' => '2',
        'VENCIMENTO_ANT' => '2023-10-01',
        'VENCIMENTO_NOVO' => '2023-11-01',
        'VALOR' => 15.00,
        'TPPRORROGACAO' => 'P',
        'CODOPERACAO' => '328',
        'CODCRONOGRAMA' => 9668,
    ]);
});
