<?php
declare(strict_types=1);

namespace tests\FormModel;

require_once __DIR__ . '/builder.php';

use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;
use WScore\FormModel\FormModel;
use WScore\FormModel\Html\HtmlForm;
use WScore\FormModel\ToString\ViewModel;
use WScore\FormModel\Validation\ValidationModel;

class RealCaseTest extends TestCase
{
    /**
     * @var FormModel
     */
    private $form;

    /**
     * @var array
     */
    private $inputs = [];

    protected function setUp(): void
    {
        $this->form = RealCases::forge()->build();
        $this->inputs = array(
            'book' => array(
                'title' => 'Developing a Form Model',
                'abstract' => "This is an abstract.\nThis field is textarea.",
                'million' => 'MILLION',
                'checked' => 'RADIO',
                'cases' => 'case2',
                'published_at' => '2019-06-01',
                'isbn_code' => '978-1-4028-9462-6',
                'language' => 'ja',
                'format' => 'PAPERBACK',
                'type' =>
                    array(
                        'C' => 'C',
                    ),
                'publisher' =>
                    array(
                        'name' => 'Tuum Publishing',
                        'url' => 'https://www.workspot.jp',
                    ),
                'authors' =>
                    array(
                        1 =>
                            array(
                                'name' => 'One',
                                'type' => 'STORY',
                            ),
                        2 =>
                            array(
                                'name' => 'Murata',
                                'type' => 'ILLUSTRATION',
                            ),
                    ),
            ),
        );
    }

    public function test0()
    {
        $this->assertEquals(FormModel::class, get_class($this->form));
        $this->assertEquals(HtmlForm::class, get_class($this->form->createHtml()));
        $this->assertEquals(ViewModel::class, get_class($this->form->createView()));
        $this->assertEquals(ValidationModel::class, get_class($this->form->createValidation()));
    }

    /**
     * @throws Exception
     */
    public function testSuccessfulData()
    {
        $inputs = $this->inputs;

        $validation = $this->form->createValidation($inputs);
        $this->assertTrue($validation->isValid());
        $this->assertEquals($inputs, $validation->getInputs());

        $validated = $inputs['book'];

        // date type is converted to \DateTimeImmutable object.
        $this->assertEquals(new DateTimeImmutable($inputs['book']['published_at']), $validation->getData()['published_at']);
        $validated['published_at'] = new DateTimeImmutable($inputs['book']['published_at']);

        // type is replaced with the choice's value.
        $this->assertEquals('Comic', $validation->getData()['type']['C']);
        $validated['type']['C'] = 'Comic';

        $this->assertEquals($validated, $validation->getData());
    }

    public function testCreateViewOnSimpleText()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $title = $view['title'];
        $this->assertStringContainsString('<input type="text"', $title->widget());
        $this->assertStringContainsString('name="book[title]"', $title->widget());
        $this->assertStringContainsString("value=\"{$inputs['book']['title']}\"", $title->widget());
        $this->assertEquals('<label class="form-label required">Book Title</label>', $title->label());
    }

    public function testCreateViewOnTextArea()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $abstract = $view['abstract'];
        $this->assertStringContainsString('<textarea', $abstract->widget());
        $this->assertStringContainsString('name="book[abstract]"', $abstract->widget());
        $this->assertStringContainsString(">This is an abstract.
This field is textarea.</textarea>", $abstract->widget());
        $this->assertEquals('<label class="form-label required">Abstracts</label>', $abstract->label());
    }

    public function testCreateViewOnButtons()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for case1.
        $case = $view['cases']['case1'];
        $this->assertStringContainsString('<input type="radio"', $case->widget());
        $this->assertStringContainsString('name="book[cases]"', $case->widget());
        $this->assertStringContainsString("value=\"case1\"", $case->widget());
        // test for case2.
        $case = $view['cases']['case2'];
        $this->assertStringContainsString('<input type="radio"', $case->widget());
        $this->assertStringContainsString('name="book[cases]"', $case->widget());
        $this->assertStringContainsString("value=\"case2\"", $case->widget());
        // test for case3.
        $case = $view['cases']['case3'];
        $this->assertStringContainsString("value=\"case3\"", $case->widget());
        $this->assertEquals('<label class="form-label required">Various Cases</label>', $view['cases']->label());
    }

    public function testCreateViewNestedForm()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $name = $inputs['book']['publisher']['name'];
        $nameView = $view['publisher']['name'];
        $this->assertStringContainsString('<input type="text"', $nameView->widget());
        $this->assertStringContainsString('name="book[publisher][name]"', $nameView->widget());
        $this->assertStringContainsString("value=\"{$name}\"", $nameView->widget());
        $this->assertEquals('<label class="form-label required">publisher name</label>', $nameView->label());
    }

    public function testCreateViewOneToMany()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $name = $inputs['book']['authors'][1]['name'];
        $nameView = $view['authors'][1]['name'];
        $this->assertStringContainsString('<input type="text"', $nameView->widget());
        $this->assertStringContainsString('name="book[authors][1][name]"', $nameView->widget());
        $this->assertStringContainsString("value=\"{$name}\"", $nameView->widget());
        $this->assertEquals('<label class="form-label required">author name</label>', $nameView->label());
    }
}
