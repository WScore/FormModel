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

    protected function setUp(): void
    {
        $this->form = buildRealCaseForm();
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
        $inputs = array(
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
}
