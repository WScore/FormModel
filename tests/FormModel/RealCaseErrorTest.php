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

class RealCaseErrorTest extends TestCase
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
        $this->inputs = [];
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
    public function testErrorData()
    {
        $inputs = $this->inputs;

        $validation = $this->form->createValidation($inputs);
        $this->assertFalse($validation->isValid());
        $this->assertEquals([], $validation->getInputs());
    }

    public function testCreateViewOnSimpleText()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $element = $view['title'];
        $this->assertStringContainsString('<input type="text"', $element->widget());
        $this->assertStringContainsString('name="book[title]"', $element->widget());
        $this->assertStringContainsString('is-invalid', $element->widget());
        $this->assertStringNotContainsString("value=", $element->widget());
        $this->assertEquals('<label class="form-label required">Book Title</label>', $element->label());

        $this->assertEquals('<div class=\'invalid-feedback d-block\'>The input field is required.
enter title here</div>', $element->error());
    }

    public function testCreateViewOnTextArea()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $element = $view['abstract'];
        $this->assertStringContainsString('<textarea', $element->widget());
        $this->assertStringContainsString('name="book[abstract]"', $element->widget());
        $this->assertStringContainsString('is-invalid', $element->widget());
        $this->assertEquals('<label class="form-label required">Abstracts</label>', $element->label());

        $this->assertEquals('<div class=\'invalid-feedback d-block\'>The input field is required.
summary</div>', $element->error());
    }

    public function testCreateViewOnButtons()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for case1.
        $element = $view['cases']['case1'];
        $this->assertStringContainsString('<input type="radio"', $element->widget());
        $this->assertStringContainsString('name="book[cases]"', $element->widget());
        $this->assertStringContainsString("value=\"case1\"", $element->widget());
        // test for case2.
        $element = $view['cases']['case2'];
        $this->assertStringContainsString('<input type="radio"', $element->widget());
        $this->assertStringContainsString('name="book[cases]"', $element->widget());
        $this->assertStringContainsString("value=\"case2\"", $element->widget());
        // test for case3.
        $element = $view['cases']['case3'];
        $this->assertStringContainsString("value=\"case3\"", $element->widget());
        $this->assertEquals('<label class="form-label required">Various Cases</label>', $view['cases']->label());

        $this->assertEquals('', $element->error());
        $this->assertEquals('<div class=\'invalid-feedback d-block\'>The input field is required.
check some</div>', $view['cases']->error());
    }

    public function testCreateViewNestedForm()
    {
        $inputs = $this->inputs;
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $element = $view['publisher']['name'];
        $this->assertStringContainsString('<input type="text"', $element->widget());
        $this->assertStringContainsString('name="book[publisher][name]"', $element->widget());
        $this->assertStringNotContainsString("value=", $element->widget());
        $this->assertStringContainsString('is-invalid', $element->widget());
        $this->assertEquals('<label class="form-label required">publisher name</label>', $element->label());

        $this->assertEquals('<div class=\'invalid-feedback d-block\'>The input field is required.</div>', $element->error());
    }

    public function testCreateViewOneToMany()
    {
        $inputs = [
            'book' => [
                'authors' => [
                        1 => ['type' => 'STORY'],
                ],
            ],
        ];
        $validation = $this->form->createValidation($inputs);
        $view = $validation->createView();

        // test for titles.
        $element = $view['authors'][1]['name'];
        $this->assertStringContainsString('<input type="text"', $element->widget());
        $this->assertStringContainsString('name="book[authors][1][name]"', $element->widget());
        $this->assertStringNotContainsString("value=", $element->widget());
        $this->assertStringContainsString('is-invalid', $element->widget());
        $this->assertEquals('<label class="form-label required">author name</label>', $element->label());

        $this->assertEquals('<div class=\'invalid-feedback d-block\'>The input field is required.
names here</div>', $element->error());
    }
}
