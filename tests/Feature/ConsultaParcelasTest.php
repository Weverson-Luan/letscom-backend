<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Cronograma;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConsultaParcelasTest extends TestCase
{
    use RefreshDatabase;

    public function test_consulta_simples()
    {
        // Arrange
        $payload = [
            "configuracoes" => [
                "DataInicio" => "2024-01-01",
                "DataFim" => "2024-12-31",
                "Consultar_Parciais" => false,
                "Consultar_Splits" => false,
                "Consultar_Prorrogacao" => false,
                "RegistrosPorPagina" => 10,
                "Pagina" => 1
            ],
            "Operacao_Parcelas" => [
                [
                    "Operacao" => "",
                    "Cronograma" => "9665"
                ]
            ]
        ];

        // Act
        $response = $this->postJson('/api/consulta-parcelas', $payload);

        // Assert
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'CODCRONOGRAMA',
                            'VENCIMENTO',
                            'TOTRECEBIDO',
                            'VL_FACE',
                            'VL_JUROS',
                            'VL_MULTA',
                            'VL_DESCONTO',
                            'LIQUIDA'
                        ]
                    ],
                    'current_page',
                    'total'
                ]);
    }
}