<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InquiryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InquiryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InquiryCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Inquiry::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/inquiry');
        CRUD::setEntityNameStrings('inquiry', 'inquiries');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('company_name')->label('Наименование компании');
        CRUD::column('position')->label('Должность');
        CRUD::column('surname')->label('Фамилия');
        CRUD::column('name')->label('Имя');
        CRUD::column('phone')->label('Телефон');
        CRUD::column('email')->label('Email');
        CRUD::column('comments')->label('Комментарий');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('company_name')->label('Наименование компании');
        CRUD::field('position')->label('Должность');
        CRUD::field('surname')->label('Фамилия');
        CRUD::field('name')->label('Имя');
        CRUD::field('phone')->label('Телефон');
        CRUD::field('email')->label('Email');
        CRUD::field('comments')->label('Комментарий');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
