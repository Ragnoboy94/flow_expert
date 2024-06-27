<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganizationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrganizationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrganizationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Organization::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organization');
        CRUD::setEntityNameStrings('организация', 'организации');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Название');
        CRUD::column('juridical_address')->label('Юридический адрес');
        CRUD::column('postal_address')->label('Почтовый адрес');
        CRUD::column('inn')->label('ИНН');
        CRUD::column('account_number')->label('Номер счета');
        CRUD::column('bank_account')->label('Банковский счет');
        CRUD::column('bik')->label('БИК');
        CRUD::column('ogrn')->label('ОГРН');
        CRUD::column('email')->label('Электронная почта');
        CRUD::column('phone')->label('Телефон');
        CRUD::column('status_id')->label('Статус');
        CRUD::column('paid_until')->label('Оплачено до');
        CRUD::column('confirmed_at')->label('Дата подтверждения');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrganizationRequest::class);

        CRUD::field('name')->label('Название');
        CRUD::field('juridical_address')->label('Юридический адрес');
        CRUD::field('postal_address')->label('Почтовый адрес');
        CRUD::field('inn')->label('ИНН');
        CRUD::field('account_number')->label('Номер счета');
        CRUD::field('bank_account')->label('Банковский счет');
        CRUD::field('bik')->label('БИК');
        CRUD::field('ogrn')->label('ОГРН');
        CRUD::field('email')->label('Электронная почта');
        CRUD::field('phone')->label('Телефон');
        CRUD::field('status_id')->label('Статус')->type('select')->entity('status')->attribute('name')->model("App\Models\OrganizationStatus");
        CRUD::field('paid_until')->label('Оплачено до')->type('date');
        CRUD::field('confirmed_at')->label('Дата подтверждения')->type('datetime');
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
