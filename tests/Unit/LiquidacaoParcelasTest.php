<?php

namespace Tests\Unit;

use App\Repositories\LiquidacaoParcelasRepository;
use App\Repositories\MockLiquidacaoParcelasRepository;
use Tests\TestCase;

class LiquidacaoParcelasTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        $this->app->bind(
            LiquidacaoParcelasRepository::class, 
            MockLiquidacaoParcelasRepository::class
        );
    }

}
