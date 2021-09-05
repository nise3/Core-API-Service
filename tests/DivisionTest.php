<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

//use Laravel\Lumen\Testing\DatabaseMigrations;

use App\Models\LocDivision;

class DivisionTest extends TestCase
{
//    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    const ROUTE_PREFIX = "api.v1.divisions.";

    /** Division Create TestCase */
    public function testCanCreateTask()
    {
        $formData = [
            [
                "title_en" => "Test Division EN",
                "title_bn" => "Test Division Bn",
                "bbs_code" => 1001
            ],
            [
                "title_en" => "Test Division EN",
                "title_bn" => "বিভাগের নাম",
                "bbs_code" => "১২৩৪"
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "Test Division Bn",
                "bbs_code" => 1001
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "বিভাগের নাম",
                "bbs_code" => 1001
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "বিভাগের নাম",
            ],


        ];

        foreach ($formData as $data) {

            $this->post(route("api.v1.divisions.store"), $data)
                ->seeStatusCode(201);
        }

    }

    /** Read TestCase */
    public function testCanGetReadTask()
    {
        $this->get(route("api.v1.divisions.get-list"))
            ->seeStatusCode(200);

    }

    /** Show TestCase */
    public function testCanShowTask()
    {
        $lod_division = LocDivision::factory()->create();
        $this->get(route("api.v1.divisions.read", $lod_division->id))
            ->seeStatusCode(200);

    }

    /** Put TestCase */
    public function testCanUpdateTask()
    {
        $lod_division = LocDivision::factory()->create();
        $formData = [
            [
                "title_en" => "Test Division EN",
                "title_bn" => "Test Division Bn",
                "bbs_code" => 1001
            ],
            [
                "title_en" => "Test Division EN",
                "title_bn" => "বিভাগের নাম",
                "bbs_code" => "১২৩৪"
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "Test Division Bn",
                "bbs_code" => 1001
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "বিভাগের নাম",
                "bbs_code" => 1001111
            ],
            [
                "title_en" => "বিভাগের নাম",
                "title_bn" => "বিভাগের নাম",
            ]
        ];

        foreach ($formData as $data) {
            $this->put(route("api.v1.divisions.update", $lod_division->id), $data)
                ->seeStatusCode(200);
        }

    }

    /** Delete TestCase */
    public function testCanDeleteTask()
    {
        $lod_division = LocDivision::factory()->create();

        $this->delete(route("api.v1.divisions.destroy", $lod_division->id))
            ->seeStatusCode(200);

    }

}
