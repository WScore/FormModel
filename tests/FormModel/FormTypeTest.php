<?php
/**
 * Created by PhpStorm.
 * User: asao
 * Date: 2019-03-20
 * Time: 10:12
 */

use WScore\FormModel\Element\TextType;
use WScore\FormModel\FormType;
use PHPUnit\Framework\TestCase;
use WScore\FormModel\Interfaces\BaseElementInterface;

class FormTypeTest extends TestCase
{
    private function buildForm($name = 'user'): FormType
    {
        return FormType::create($name, 'Model: ' . $name);
    }

    private function buildTextType($name = 'name'): TextType
    {
        return TextType::create($name, $name . ' Input');
    }

    public function testGetName()
    {
        $model = $this->buildForm();
        $this->assertEquals('user', $model->getName());
    }

    public function testGetLabel()
    {
        $model = $this->buildForm();
        $this->assertEquals('Model: user', $model->getLabel());
    }

    public function testIsFormType()
    {
        $model = $this->buildForm();
        $this->assertTrue($model->isFormType());
        $this->assertEquals(BaseElementInterface::TYPE_FORM, $model->getType());
    }

    public function testChildElementHasNestedFullName()
    {
        $model = $this->buildForm();
        $model->add(
            $this->buildTextType()
        );
        $element = $model->get('name');
        $this->assertEquals(TextType::class, get_class($element));
        $this->assertTrue($model->hasChildren());
        $this->assertEquals('name', $element->getName());
        $this->assertEquals('user[name]', $element->getFullName());
    }

    /**
     * @dataProvider provideFormTypes
     * @param FormType $user
     */
    public function testAddFormSetsFullName(FormType $user)
    {
        $this->assertEquals('user', $user->getFullName());
        $this->assertEquals('user[address]', $user->get('address')->getFullName());
        $this->assertEquals('user[address][post_code]', $user->get('address')->get('post_code')->getFullName());
    }

    /**
     * @return array
     */
    public function provideFormTypes()
    {
        $provided = [];

        // create FormType in correct order

        $address = $this->buildForm('address');
        $zipCode = $this->buildTextType('post_code');
        $user = $this->buildForm('user')
            ->addForm($address);
        $address->add($zipCode);

        $provided['correct order'] = [$user];

        // create FormType in add-hoc manner

        $user = $this->buildForm('user')
            ->addForm($this->buildForm('address')
                ->add($this->buildTextType('post_code'))
            );

        $provided['ad-hoc manner'] = [$user];

        return $provided;
    }

    public function testAddRepeatedForm()
    {
        $user = $this->buildForm('user');
        $user->addRepeatedForm(3, $this->buildForm('address')
            ->add($this->buildTextType('post_code')));
        $addresses = $user->get('address');
        $this->assertEquals(FormType::class, get_class($addresses));
        $this->assertTrue($addresses->hasChildren());
        foreach ($addresses->getChildren() as $idx => $address) {
            $this->assertEquals("address[$idx]", $address->getName());
            $this->assertEquals("user[address][{$idx}]", $address->getFullName());
        }
    }
}
