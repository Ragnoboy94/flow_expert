<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'ФИО']);
        $this->crud->addColumn(['name' => 'email', 'type' => 'email', 'label' => 'Email']);
        $this->crud->addColumn(['name' => 'phone', 'type' => 'text', 'label' => 'Телефон']);
        $this->crud->addColumn(['name' => 'company', 'type' => 'text', 'label' => 'Компания']);
        $this->crud->addColumn([
            'name' => 'role',
            'type' => 'select',
            'label' => 'Роль',
            'entity' => 'role',
            'attribute' => 'description',
            'model' => "App\Models\Role",
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'ФИО']);
        $this->crud->addField(['name' => 'email', 'type' => 'email', 'label' => 'Email']);
        $this->crud->addField(['name' => 'phone', 'type' => 'text', 'label' => 'Телефон']);
        $this->crud->addField(['name' => 'password', 'type' => 'password', 'label' => 'Пароль']);
        $this->crud->addField(['name' => 'company', 'type' => 'text', 'label' => 'Компания']);
        $this->crud->addField(['name' => 'position', 'type' => 'text', 'label' => 'Должность']);
        $this->crud->addField([
            'name' => 'inn',
            'type' => 'text',
            'label' => 'ИНН'
        ]);
        $this->crud->addField(['name' => 'kpp', 'type' => 'text', 'label' => 'КПП']);
        $this->crud->addField([
            'label' => "Роль",
            'type' => 'select',
            'name' => 'role_id',
            'entity' => 'role',
            'attribute' => 'description',
            'model' => "App\Models\Role",
        ]);

        $this->crud->addField([
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id',
            'entity' => 'category',
            'model' => "App\Models\Category",
            'attribute' => 'name',
        ]);




    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'ФИО']);
        $this->crud->addField(['name' => 'email', 'type' => 'email', 'label' => 'Email']);
        $this->crud->addField(['name' => 'phone', 'type' => 'text', 'label' => 'Телефон']);
        $this->crud->addField(['name' => 'company', 'type' => 'text', 'label' => 'Компания']);
        $this->crud->addField(['name' => 'position', 'type' => 'text', 'label' => 'Должность']);
        $this->crud->addField([
            'name' => 'inn',
            'type' => 'text',
            'label' => 'ИНН'
        ]);
        $this->crud->addField(['name' => 'kpp', 'type' => 'text', 'label' => 'КПП']);
        $this->crud->addField([
            'label' => "Роль",
            'type' => 'select',
            'name' => 'role_id',
            'entity' => 'role',
            'attribute' => 'description',
            'model' => "App\Models\Role",
        ]);

        $this->crud->addField([
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id',
            'entity' => 'category',
            'model' => "App\Models\Category",
            'attribute' => 'name',
        ]);
    }
}
