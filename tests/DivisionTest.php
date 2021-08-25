<?php

use App\Models\LocDivision;

class DivisionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    const ROUTE_PREFIX = "api.v1.divisions.";

    /**Division Create TestCase*/
    public function testCanCreateTask()
    {
        $formData = [
            "title_en" => "Test Division EN",
            "title_bn" => "Test Division Bn",
            "bbs_code" => 1001
        ];
        $this->post(route("api.v1.divisions.store"), $formData)
            ->seeStatusCode(201);

    }

    /**Read TestCase*/
    public function testCanGetReadTask()
    {
        $this->get(route("api.v1.divisions.get-list"))
            ->seeStatusCode(200);

    }

    /**Show TestCase*/
    public function testCanShowTask()
    {
        $lod_division = LocDivision::factory()->create();
        $this->get(route("api.v1.divisions.read", $lod_division->id))
            ->seeStatusCode(200);

    }

    /**Put TestCase*/
    public function testCanUpdateTask()
    {
        $lod_division = LocDivision::factory()->create();
        $formData = [
            "title_en" => "Test Division EN(Edited)",
            "title_bn" => "Test Division Bn(Edited)",
            "bbs_code" => 1001
        ];
        $this->put(route("api.v1.divisions.update", $lod_division->id), $formData)
            ->seeStatusCode(200);

    }

    /**Delete TestCase*/
    public function testCanDeleteTask()
    {
        $lod_division = LocDivision::factory()->create();

        $this->delete(route("api.v1.divisions.destroy", $lod_division->id))
            ->seeStatusCode(200);

    }

}
