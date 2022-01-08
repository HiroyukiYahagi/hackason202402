<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Account;
use App\Models\Senario;

class SenarioTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testApplicable()
    {
        $account = factory(Account::class)->create();

        $senario = factory(Senario::class)->create();

        $this->assertTrue($senario->isApplicable($account));
    }

    public function testApplicableOnlyRegisgteredPet()
    {
        $senario = factory(Senario::class)->create();
        $senario->condition = <<<'EOM'
return $account->getProperty("pet_names")->count() != 0;
EOM;

        $account = factory(Account::class)->create();
        $this->assertTrue($senario->isApplicable($account));

        $account->removeProperty("pet_names");
        $this->assertTrue(!$senario->isApplicable($account));
    }
}
